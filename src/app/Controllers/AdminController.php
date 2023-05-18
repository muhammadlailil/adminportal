<?php

namespace Laililmahfud\Adminportal\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Laililmahfud\Adminportal\Helpers\ExportPdf;
use Laililmahfud\Adminportal\Helpers\ExportExcel;
use Laililmahfud\Adminportal\Models\CmsImportLog;

class AdminController extends Controller
{
    /**
     * The route base name for the controller module.
     *
     * @var string
     */
    protected $routePath;

    /**
     * The module name of the controller
     *
     * @var string
     */
    protected $pageTitle;

    /**
     * The base resource path for the module
     *
     * @var string
     */
    protected $resourcePath;

    /**
     * The service class for handling crud function
     *
     * @var YourServiceClass
     */
    protected $moduleService;

    /**
     * The import class for handling import excel function
     * More detail about import excel function read this documentation [link]
     *
     * @var YourImportExcelClass|null
     */
    protected $importExcel;

    /**
     * The list of main table view column
     * Example :
     * [["label" => "Name","name"=>"user.name"]]
     *
     * @var array
     */
    protected $tableColumns;

    /**
     * The rule of validation for store and update rules
     *
     * @var array
     */
    protected $rules = [];

    /**
     * The rule of validation for store rule
     *
     * @var array|null
     */
    protected $createRules = [];

    /**
     * The rule of validation for update rule, if the value is null, validation process will use the storeRule
     *
     * @var array|null
     */
    protected $updateRules = [];

    /**
     * Indicates if the user can add record, this will display add button
     *
     * @var bool
     */
    protected $add = true;

    /**
     * Indicates if the user can filter record, this will display filter button
     *
     * @var bool
     */
    protected $filter = false;

    /**
     * Indicates if the user can import record, this will display import button
     *
     * @var bool
     */
    protected $import = false;

    /**
     * Indicates if the user can export record, this will display export button
     *
     * @var bool
     */
    protected $export = false;

    /**
     * Indicates if the user can do bulk action of the record, this will display checkbox in the table
     *
     * @var bool
     */
    protected $bulkAction = true;

    /**
     * Indicates if the table has action function, this will show action in header table
     *
     * @var bool
     */
    protected $tableAction = true;

    /**
     * The paginate per page list
     */
    protected $perPage = 10;

    /**
     * If you prefer use js data table
     * see : https://jstable.github.io/index.html
     */
    protected $jstable = false;

    /**
     * The variable for assign data to view
     * @return array
     */
    protected $data = [];

    /**
     * Custom message actions
     * 
     * protected $message = [
     *      "store" => "",
     *      "failed_store => "",
     *      "update" => "",
     *      "failed_update" => "",
     *      "delete" => "",
     *      "failed_delete" => "",
     *      "bulk_delete" => ""
     * ];
     */
    protected $message = [];

    /**
     * The function to new class of crud service
     */
    protected function moduleService()
    {
        return new $this->moduleService;
    }

    /**
     * The main index function to showing datatable
     */
    public function index(Request $request)
    {
        if (!itcan($this->accessmodule("view"))) return to_route('admin.dashboard')->with(['alert_error' => __('adminportal.dont_have_access')]);

        $this->data = [
            ...$this->data,
            "page_title" => $this->pageTitle,
            "datatable_views" => "{$this->resourcePath}.table",
            "table_columns" => $this->tableColumns,
            "route" => $this->routePath,
            'jstable' => $this->jstable,
            "button" => [
                "add" => $this->add && itcan($this->accessmodule("add")),
                "filter" => $this->filter,
                "bulkAction" => $this->bulkAction && itcan($this->accessmodule("delete")),
                "tableAction" => $this->tableAction && (itcan($this->accessmodule("edit")) || itcan($this->accessmodule("delete"))),
                "import" => $this->import && itcan($this->accessmodule("add")),
                "export" => $this->export,
            ],
            "data" => (!$this->jstable) ? $this->moduleService()->datatable($request, $this->perPage) : [],
        ];

        return view($this->jstable ? "portal::default.jstable" : "portal::default.datatable", $this->data);
    }


    /**
     * The main function to generate json datatable for datatable 
     */
    public function datatable(Request $request)
    {
        return $this->moduleService()->datatable($request, $this->perPage);
    }

    /**
     * The main function to showing create view
     */
    public function create(Request $request)
    {
        if (!itcan($this->accessmodule("add"))) return to_route('admin.dashboard')->with(['alert_error' => __('adminportal.dont_have_access')]);

        $this->data = [
            ...$this->data,
            "page_title" => $this->pageTitle,
            "route" => $this->routePath,
            "action" => route("{$this->routePath}.store"),
            "form_views" => "{$this->resourcePath}.create",
            "type" => "create",
        ];

        return view("portal::default.form", $this->data);
    }

    /**
     * The main function to showing edit view
     */
    public function edit(Request $request, $uuid)
    {
        if (!itcan($this->accessmodule("edit"))) return to_route('admin.dashboard')->with(['alert_error' => __('adminportal.dont_have_access')]);

        $this->data =  [
            ...$this->data,
            "page_title" => $this->pageTitle,
            "route" => $this->routePath,
            "action" => route("{$this->routePath}.update", $uuid),
            "form_views" => "{$this->resourcePath}.edit",
            "type" => "update",
            "row" => $this->moduleService()->findByUuId($uuid),
            "id" => $uuid
        ];

        return view("portal::default.form", $this->data);
    }

    /**
     *  The main function to store data from create view
     */
    public function store(Request $request)
    {
        if (!itcan($this->accessmodule("add"))) return redirect()->back()->with(['alert_error' => __('adminportal.dont_have_access')]);

        $request->validate($this->validationRules('create'));
        try {
            $this->moduleService()->store($request);

            $successMessage = @$this->message['store'] ?? __('adminportal.data_success_add');
            return redirect(return_url() ?: route("{$this->routePath}.index"))->with(['success' => $successMessage]);
        } catch (\Exception $e) {

            $errorMessage = @$this->message['failed_store'] ?? __('adminportal.data_failed_add', ['reason' => $e->getMessage()]);
            return redirect()->back()->with(['error' =>  $errorMessage]);
        }
    }

    /**
     *  The main function to update data from edit view
     */
    public function update(Request $request, $id)
    {
        if (!itcan($this->accessmodule("edit"))) return redirect()->back()->with(['alert_error' => __('adminportal.dont_have_access')]);


        $request->validate($this->validationRules('update', $id));

        try {
            $this->moduleService()->update($request, $id);

            $successMessage = @$this->message['update'] ?? __('adminportal.data_success_update');
            return redirect(return_url() ?: route("{$this->routePath}.index"))->with(['success' => $successMessage]);
        } catch (\Exception $e) {

            $errorMessage = @$this->message['failed_update'] ?? __('adminportal.data_failed_update', ['reason' => $e->getMessage()]);
            return redirect()->back()->with(['error' => $errorMessage]);
        }
    }

    public function destroy(Request $request, $id)
    {
        if(!itcan($this->accessmodule("delete"))) return redirect()->back()->with(['alert_error' => __('adminportal.dont_have_access')]);
     
        try {
            $this->moduleService()->deleteByUuid($id);

            $successMessage = @$this->message['delete'] ?? __('adminportal.data_success_delete');
            return redirect(return_url() ?: route("{$this->routePath}.index"))->with(['success' =>  $successMessage]);
        } catch (\Exception $e) {

            $errorMessage = @$this->message['failed_delete'] ?? __('adminportal.data_failed_delete', ['reason' => $e->getMessage()]);
            return redirect()->back()->with(['error' =>  $errorMessage]);
        }
    }

    public function export(Request $request)
    {
        if(!itcan($this->accessmodule("view"))) return redirect()->back()->with(['alert_error' => __('adminportal.dont_have_access')]);
       

        $file_format = $request->file_format;
        $data = $this->moduleService()->datatable($request, null);
        switch ($file_format) {
            case 'pdf':
                return ExportPdf::paperSize($request->papersize)
                    ->paperOrientation($request->page_orientation)
                    ->view("{$this->resourcePath}.export")
                    ->data($data)
                    ->download($request->file_name);

            case 'csv':
                $format = \Maatwebsite\Excel\Excel::CSV;
                break;
            case 'xls';
                $format = \Maatwebsite\Excel\Excel::XLS;
                break;
            default:
                $format = \Maatwebsite\Excel\Excel::XLSX;
                break;
        }
        return Excel::download(new ExportExcel([
            'view' => "{$this->resourcePath}.export",
            'data' => $data,
        ]), "{$request->file_name}.{$file_format}", $format);
    }

    /**
     * Excel import with relationships : https://daengweb.id/import-with-relationships-using-laravel-excel     *
     */
    public function import(Request $request)
    {
        if(!itcan($this->accessmodule("add"))) return redirect()->back()->with(['alert_error' => __('adminportal.dont_have_access')]);

        if (!$this->importExcel)  return redirect()->back()->with(['error' => "Please define importExcel class first"]);

        $importFile = $request->file('import_file');
        $logs = CmsImportLog::create([
            'filename' => $importFile->getClientOriginalName(),
            'import_by' => admin()->user->id,
            'row_count' => 0,
            'progres' => 0,
        ]);

        $importClass = new $this->importExcel($logs->id);
        if ($importClass instanceof ShouldQueue) {
            $message = __('adminportal.import_data_in_progres');
            Excel::queueImport($importClass, $importFile);
        } else {
            $message = __('adminportal.import_data_success');
            Excel::import($importClass, $importFile);
        }
        return redirect()->back()->with(['success' => $message]);
    }


    public function bulkAction(Request $request)
    {
        $bulk_action = $request->bulk_action;
        $selected_ids = $request->selected_ids;
        if ($bulk_action == 'delete') {
            if(!itcan($this->accessmodule("delete"))) return to_route('admin.dashboard')->with(['alert_error' => __('adminportal.dont_have_access')]);
            $this->moduleService()->bulkDeleteByUuid($selected_ids);

            $successMessage = @$this->message['bulk_delete'] ?? __('adminportal.data_success_delete');
            return redirect(return_url() ?: route("{$this->routePath}.index"))->with(['success' =>  $successMessage]);
        }
        return $this->actionSelected($bulk_action, $selected_ids);
    }

    public function actionSelected($type, $selectedIds)
    {
        return redirect(return_url() ?: route("{$this->routePath}.index"))->with(['success' => "Not implement",]);
    }

    protected function validationRules($type, $id = null)
    {
        $rules = ($type == 'create')
            ? $this->createRules
            : $this->updateRules;

        foreach ($rules as $input => $rule) {
            $separator = (@$this->rules[$input]) ? "|" : "";
            $this->rules[$input] = @$this->rules[$input] . $separator . $rule;
        }

        return collect($this->rules)->map(function ($item) use ($id) {
            return str_replace('{id}', $id, $item);
        })->toArray();
    }

    protected function accessmodule($str = "")
    {
        return $str . " " . $this->routePath;
    }
}
