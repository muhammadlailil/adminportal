<?php
namespace Laililmahfud\Adminportal\Http\Crud;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Laililmahfud\Adminportal\Http\Exceptions\BadRequestException;

trait AdminModuleController
{
     public function __construct()
     {
          static::resolve();
          $route = request()->route()->getActionMethod();
          $data = [
               'breadcrumb' => breadcrumb(action : match ($route) {
                    'show' => 'Detail',
                    'create' => 'Create',
                    'edit' => 'Update',
                    default => 'List',
               },title : static::getTitle()),
               'pageTitle' => static::getTitle(),
               'pageDescription' => match ($route) {
                    'index' => static::$description ?? "Manage your " . static::getTitle() . " data here.",
                    'create' => static::$description ?? "Add your new " . static::getTitle() . " data here.",
                    'edit' => static::$description ?? "Update your " . static::getTitle() . " data here.",
                    'show' => static::$description ?? "See detail your " . static::getTitle() . " data here.",
                    default => '',
               },
          ];
          view()->share($data);
     }
     public function index(Request $request)
     {
          abort_if(!$request->admin(true)?->can('view', static::$policy), Response::HTTP_UNAUTHORIZED);

          $table = static::getTables();
          $indexProps = static::$shared->index;
          $allProps = static::$shared->all;
          $actions = static::getActions();

          $data = [
               'actions' => $actions,
               'columns' => $table->columns,
               'view' => [
                    'table' => static::$resourcePath . ".index",
                    'form' => static::$resourcePath . ".form",
               ],
               'route' => [
                    'store' => static::$action->create ? route_from_current('store') : null,
                    'update' => static::$action->update ? route_from_current('update', old('uuid') ?: ":uuid") : null,
                    'delete' => static::$action->delete ? route_from_current('destroy', ":uuid") : null,
                    'import' => static::$action->import ? route_from_current('import') : null,
                    'export' => count(static::$action->export) ? route_from_current('export') : null,
                    'bulk_actions' => count(static::$action->bulkActions) ? route_from_current('bulk-actions') : null,
               ],
               'import' => static::getImport(),
               'result' => app(static::$repository)->datatable($request, $table->limit),
               ...$allProps(),
               ...$indexProps(),
          ];
          return view("portal::default.index", $data);
     }

     public function show(Request $request, $uuid)
     {
          abort_if(!$request->admin(true)?->can('view', static::$policy), Response::HTTP_UNAUTHORIZED);
          $id = id_from_uuid($uuid);

          $row = app(static::$repository)->firstOrFail($id);
          $detailProps = static::$shared->detail;

          $data = [
               'row' => $row,
               'view' =>  static::$resourcePath . ".show",
               ...$detailProps($row)
          ];
          return view("portal::default.show", $data);
     }

     public function create(Request $request){
          abort_if(!$request->admin(true)?->can('create', static::$policy), Response::HTTP_UNAUTHORIZED);

          $createProps = static::$shared->create;
          $allProps = static::$shared->all;

          $data = [
               'view' =>  static::$resourcePath . ".create",
               'action' => [
                    'route' => route_from_current('store'),
                    'method' => 'POST'
               ],
               ...$allProps(),
               ...$createProps(),
          ];
          return view("portal::default.form", $data);
     }

     public function store(Request $request)
     {
          abort_if(!$request->admin(true)?->can('create', static::$policy), Response::HTTP_UNAUTHORIZED);


          try {
               $request->validate([
                    ...static::$rules->all,
                    ...static::$rules->create,
               ]);

               $action = static::$action->create;               
               if($action instanceof Closure){
                    $action($request);
               }else{
                    app($action)->handle($request);
               }

               return redirect(route_from_current('index'))->withToast([
                    'title' => 'Congratulation !',
                    'message' => __('adminportal.alert.data_created'),
                    'variant' => 'success'
               ]);

          } catch (\Illuminate\Validation\ValidationException $e) {
               return redirect()->back()
                    ->withErrors($e->errors())
                    ->withInput()
                    ->with('openDialog', 'create-crud-form');
          } catch (BadRequestException $e) {
               return redirect()->back()
                    ->withToast([
                         'title' => 'Oops! Something went wrong.',
                         'message' => $e->getMessage(),
                         'variant' => 'danger'
                    ]);
          }
     }

     public function edit(Request $request,$uuid){
          abort_if(!$request->admin(true)?->can('update', static::$policy), Response::HTTP_UNAUTHORIZED);
          $id = id_from_uuid($uuid);

          $updateProps = static::$shared->update;
          $allProps = static::$shared->all;
          $data = [
               'view' =>  static::$resourcePath . ".update",
               'action' => [
                    'route' => route_from_current('update',$uuid),
                    'method' => 'PATCH'
               ],
               ...$allProps(),
               ...$updateProps($id),
          ];
          if(!@$data['row']){
               $data['row'] = app(static::$repository)->firstOrFail($id);;
          }
          return view("portal::default.form", $data);
     }
     public function update(Request $request, $uuid)
     {
          abort_if(!$request->admin(true)?->can('update', static::$policy), Response::HTTP_UNAUTHORIZED);
          $id = id_from_uuid($uuid);


          $request->merge([
               'id' => $id,
               'uuid' => $uuid
          ]);
          try {
               $request->validate([
                    ...static::$rules->all,
                    ...static::$rules->update,
               ]);

               $action = static::$action->update;               
               if($action instanceof Closure){
                    $action($request,$id);
               }else{
                    app($action)->handle($request, $id);
               }

               return redirect(route_from_current('index'))->withToast([
                    'title' => 'Congratulation !',
                    'message' => __('adminportal.alert.data_updated'),
                    'variant' => 'success'
               ]);

          } catch (\Illuminate\Validation\ValidationException $e) {
               return redirect()->back()
                    ->withErrors($e->errors())
                    ->withInput()
                    ->with([
                         'openDialog'=> 'update-crud-form'
                    ]);
          } catch (BadRequestException $e) {
               return redirect()->back()
                    ->withToast([
                         'title' => 'Oops! Something went wrong.',
                         'message' => $e->getMessage(),
                         'variant' => 'danger'
                    ]);
          }
     }


     public function destroy(Request $request, $uuid)
     {
          abort_if(!$request->admin(true)?->can('delete', static::$policy), Response::HTTP_UNAUTHORIZED);
          $id = id_from_uuid($uuid);


          try {

               
               $action = static::$action->delete;               
               if($action instanceof Closure){
                    $action($id);
               }else{
                    app($action)->handle($id);
               }

               return redirect(route_from_current('index'))->withToast([
                    'title' => 'Congratulation !',
                    'message' => __('adminportal.alert.data_deleted'),
                    'variant' => 'success'
               ]);

          } catch (BadRequestException $e) {
               return redirect()->back()
                    ->withToast([
                         'title' => 'Oops! Something went wrong.',
                         'message' => $e->getMessage(),
                         'variant' => 'danger'
                    ]);
          }
     }

     public function bulkActions(Request $request)
     {
          abort_if(!$request->admin(true)?->can('bulk-action', $request->action.'-'.static::$policy), Response::HTTP_UNAUTHORIZED);

          $action = collect(static::$action->bulkActions)->where('key', $request->action)->first();
          abort_if(!$action, Response::HTTP_NOT_FOUND);

          try {
               $handling = $action->handle;
               $handling($request);

               return redirect(route_from_current('index'))->withToast([
                    'title' => 'Congratulation !',
                    'message' => __('adminportal.alert.bulk_action_success', [
                         'action' => "<strong>" . strtoupper($action->label) . "</strong>"
                    ]),
                    'variant' => 'success'
               ]);
          } catch (BadRequestException $e) {
               return redirect()->back()
                    ->withToast([
                         'title' => 'Oops! Something went wrong.',
                         'message' => $e->getMessage(),
                         'variant' => 'danger'
                    ]);
          }
     }

     public function import(Request $request)
     {
          abort_if(!$request->admin(true)?->can('create', static::$policy), Response::HTTP_UNAUTHORIZED);

          try {
               $request->validate([
                    'file' => 'required|file|mimes:' . static::$action->import->validation
               ]);
               
               $file = $request->file('file');
               $action = static::$action->import->action;               
               if($action instanceof Closure){
                    $action($file);
               }else{
                    app($action)->handle($file);
               }

               return redirect(route_from_current('index'))->withToast([
                    'title' => 'Congratulation !',
                    'message' => __('adminportal.alert.import_success'),
                    'variant' => 'success'
               ]);
          } catch (\Illuminate\Validation\ValidationException $e) {
               return redirect()->back()
                    ->withErrors($e->errors())
                    ->withInput()
                    ->with('openDialog', 'import-data');
          } catch (BadRequestException $e) {
               return redirect()->back()
                    ->withToast([
                         'title' => 'Oops! Something went wrong.',
                         'message' => $e->getMessage(),
                         'variant' => 'danger'
                    ]);
          }
     }

     public function export(Request $request)
     {
          abort_if(!$request->admin(true)?->can('view', static::$policy), Response::HTTP_UNAUTHORIZED);

          try {
               $actions = collect(static::$action->export)->where('type', $request->type)->first();
               abort_if(!$actions, Response::HTTP_NOT_FOUND);

               $action = $actions->handle;               
               if($action instanceof Closure){
                    return $action($request);
               }else{
                    return app($action)->handle($request);
               }

          } catch (BadRequestException $e) {
               return redirect()->back()
                    ->withToast([
                         'title' => 'Oops! Something went wrong.',
                         'message' => $e->getMessage(),
                         'variant' => 'danger'
                    ]);
          }
     }

}