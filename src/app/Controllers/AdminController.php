<?php
namespace Laililmahfud\Adminportal\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
    protected $crudService;

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
    protected $canAdd = true;

    /**
     * Indicates if the user can filter record, this will display filter button
     *
     * @var bool
     */
    protected $canFilter = false;

    /**
     * Indicates if the user can import record, this will display import button
     *
     * @var bool
     */
    protected $canImport = false;

    /**
     * Indicates if the user can export record, this will display export button
     *
     * @var bool
     */
    protected $canExport = false;

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
     * The variable for assign data to view
     * @return array
     */
    protected $data = [];
    /**
     * The function to new class of crud service
     */
    
    protected function crudService()
    {
        return (new $this->crudService);
    }

    /**
     * The main index function to showing datatable
     */
    public function index(Request $request)
    {
        $this->data = array_merge($this->data, [
            "page_title" => $this->pageTitle,
            "datatable_views" => "{$this->resourcePath}.table",
            "table_columns" => $this->tableColumns,
            "route" => $this->routePath,
            "button" => [
                "add" => $this->canAdd,
                "filter" => $this->canFilter,
                "bulkAction" => $this->bulkAction,
                "tableAction" => $this->tableAction,
                "import" => $this->canImport,
                "export" => $this->canExport,
            ],
            "data" => $this->crudService()->datatable($request, $this->perPage),
        ]);
        return view("portal::default.datatable", $this->data);
    }

    /**
     * The main function to showing create view
     */
    public function create(Request $request)
    {
        $this->data = array_merge($this->data, [
            "page_title" => $this->pageTitle,
            "route" => $this->routePath,
            "action" => route("{$this->routePath}.store"),
            "form_views" => "{$this->resourcePath}.create",
            "type" => "create",
        ]);

        return view("portal::default.form", $this->data);
    }

    /**
     * The main function to showing edit view
     */
    public function edit(Request $request, $id)
    {
        $this->data = array_merge($this->data, [
            "page_title" => $this->pageTitle,
            "route" => $this->routePath,
            "action" => route("{$this->routePath}.update", $id),
            "form_views" => "{$this->resourcePath}.edit",
            "type" => "update",
            "row" => $this->crudService()->findById($id),
        ]);

        return view("portal::default.form", $this->data);
    }

    /**
     *  The main function to store data from create view
     */
    public function store(Request $request)
    {
        $request->validate($this->validationRules('create'));
        try {
            $this->crudService()->store($request);
            return redirect(return_url() ?: route("{$this->routePath}.index"))->with([
                'success' => __('adminportal.data_success_add'),
            ]);
        } catch (\Exception$e) {
            return redirect()->back()->with([
                'error' => __('adminportal.data_failed_add', [
                    'reason' => $e->getMessage(),
                ]),
            ]);
        }
    }

    /**
     *  The main function to update data from edit view
     */
    public function update(Request $request, $id)
    {
        $request->validate($this->validationRules('update', $id));

        try {
            $this->crudService()->update($request, $id);

            return redirect(return_url() ?: route("{$this->routePath}.index"))->with([
                'success' => __('adminportal.data_success_update'),
            ]);
        } catch (\Exception$e) {
            return redirect()->back()->with([
                'error' => __('adminportal.data_failed_update', [
                    'reason' => $e->getMessage(),
                ]),
            ]);
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $this->crudService()->delete($id);

            return redirect(return_url() ?: route("{$this->routePath}.index"))->with([
                'success' => __('adminportal.data_success_delete'),
            ]);
        } catch (\Exception$e) {
            return redirect()->back()->with([
                'error' => __('adminportal.data_failed_delete', [
                    'reason' => $e->getMessage(),
                ]),
            ]);
        }
    }

    public function export(Request $request)
    {
        $file_format = $request->file_format;
        $data = $this->crudService()->datatable($request, null);
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
        return \Excel::download(new ExportExcel([
            'view' => "{$this->resourcePath}.export",
            'data' => $data,
        ]), "{$request->file_name}.{$file_format}", $format);
    }

    /**
     * Excel import with relationships : https://daengweb.id/import-with-relationships-using-laravel-excel     *
     */
    public function import(Request $request)
    {
        if(!$this->importExcel){
            return redirect()->back()->with(['error' => "Please define importExcel class first"]);
        }
        $importFile = $request->file('import_file');
        $logs = CmsImportLog::create([
            'filename' => $importFile->getClientOriginalName(),
            'import_by' => admin()->user->id,
            'row_count' => 0,
            'progres' => 0,
        ]);
        
        $importClass = (new $this->importExcel($logs->id));
        if ($importClass instanceof ShouldQueue) {
            \Excel::queueImport($importClass, $importFile);
        }else{
            \Excel::import($importClass, $importFile);
        }        
        return redirect()->back()->with(['success' => __('adminportal.import_data_in_progres')]);
    }

    protected function validationRules($type, $id = null)
    {
        $rules = ($type == 'create')
        ? $this->createRules
        : $this->updateRules;

        foreach ($rules as $input => $rule) {
            $sparator = (@$this->rules[$input]) ? "|" : "";
            $this->rules[$input] = @$this->rules[$input] . $sparator . $rule;
        }

        return collect($this->rules)->map(function ($item) use ($id) {
            $item = str_replace('{id}', $id, $item);
            return $item;
        })->toArray();
    }
}
