<?php
namespace Laililmahfud\Adminportal\Helpers;

use Laililmahfud\Adminportal\Helpers\AdminPortal;

class ModuleBuilder
{
    /**
     * 1. Generate Model ✅
     * 2. Generate Service ✅
     * 3. Generate Controller ✅
     * 4. Generate Resource View ✅
     * 5. Generate Route
     */

    public function generate()
    {
        $modelName = $this->generateModel();
        $serviceName = $this->generateService($modelName);
        $importClass = $this->generateImportClass($modelName);
        $controller = $this->generateController($serviceName,$importClass);
        $this->generateResource();
        return $controller;
    }

    public function generateImportClass($modelName)
    {
        if (request('has_import')) {
            $table = request('table');
            $importName = str_replace(' ', '', ucwords(str_replace(["-", "_"], [" ", " "], $table))) . "Import";
            $importDir = app_path('Imports');
            if (!file_exists($importDir)) {
                @mkdir($importDir, 0755);
            }
            if (!file_exists(app_path("Imports/{$importName}.php"))) {
                $importTemplate = file_get_contents(__DIR__ . '/../../stubs/importclass.blade.php.stub');

                //assign all variable to model template
                $importTemplate = str_replace('[importName]', $importName, $importTemplate);
                $importTemplate = str_replace('[modelName]', $modelName, $importTemplate);

                file_put_contents($importDir . '/' . $importName . '.php', $importTemplate);
            }
            return $importName;
        }
        return null;
    }

    public function generateModel()
    {
        $table = request('table');

        $modelName = str_replace(' ', '', ucwords(str_replace(["-", "_"], [" ", " "], $table)));
        $modelDir = app_path('Models');
        if (!file_exists($modelDir)) {
            @mkdir($modelDir, 0755);
        }
        if (!file_exists(app_path("Models/{$modelName}.php"))) {
            $modelTemplate = file_get_contents(__DIR__ . '/../../stubs/model.blade.php.stub');

            $tableColumns = AdminPortal::getAllColumTable($table);
            //assign all variable to model template
            $modelTemplate = str_replace('[modelName]', $modelName, $modelTemplate);
            $modelTemplate = str_replace('[tableName]', $table, $modelTemplate);
            $modelTemplate = str_replace('[columTable]', json_encode($tableColumns), $modelTemplate);

            file_put_contents($modelDir . '/' . $modelName . '.php', $modelTemplate);
        }
        return $modelName;
    }

    public function generateService($modelName)
    {
        $table = request('table');

        $serviceName = str_replace(' ', '', ucwords(str_replace(["-", "_"], [" ", " "], $table))) . "Service";
        $serviceDir = app_path('Services');
        if (!file_exists($serviceDir)) {
            @mkdir($serviceDir, 0755);
        }

        if (!file_exists(app_path("Services/{$serviceName}.php"))) {
            $serviceTemplate = file_get_contents(__DIR__ . '/../../stubs/service.blade.php.stub');
            $useClass = '';

            //assign all variable to service template
            $storeData = $this->createStoreData();
            if($storeData->has_file){
                $useClass = 'use Laililmahfud\Adminportal\Helpers\AdminPortal;';
            }
            $serviceTemplate = str_replace('[serviceName]', $serviceName, $serviceTemplate);
            $serviceTemplate = str_replace('[modelName]', $modelName, $serviceTemplate);
            $serviceTemplate = str_replace('[tableName]', $table, $serviceTemplate);
            $serviceTemplate = str_replace('[defaultQuery]', $this->createDefaultQuery(), $serviceTemplate);
            $serviceTemplate = str_replace('[storeData]', $storeData->html, $serviceTemplate);
            $serviceTemplate = str_replace('[updateData]', $this->createUpdateData(), $serviceTemplate);
            $serviceTemplate = str_replace('[useClass]', $useClass, $serviceTemplate);

            file_put_contents($serviceDir . '/' . $serviceName . '.php', $serviceTemplate);
        }
        return $serviceName;
    }

    public function generateController($serviceName,$importClass)
    {
        $controllerName = request('module_controller');
        $module_path = request('module_path');
        $module_path = explode('/',$module_path);
        $module_path = $module_path[count($module_path)-1];

        $module_name = request('module_name');

        $controllerDir = app_path('Http/Controllers/Admin');
        if (!file_exists($controllerDir)) {
            @mkdir($controllerDir, 0755);
        }
        if (!file_exists("{$controllerDir}/{$controllerName}.php")) {
            $controllerTemplate = file_get_contents(__DIR__ . '/../../stubs/controller.blade.php.stub');

            //assign all variable to controller template
            $controllerTemplate = str_replace('[controllerName]', $controllerName, $controllerTemplate);
            $controllerTemplate = str_replace('[serviceName]', $serviceName, $controllerTemplate);
            $controllerTemplate = str_replace('[routePath]', "admin.{$module_path}", $controllerTemplate);
            $controllerTemplate = str_replace('[pageTitle]', $module_name, $controllerTemplate);
            $controllerTemplate = str_replace('[resourcePath]', "admin.{$module_path}", $controllerTemplate);
            $controllerTemplate = str_replace('[tableColumns]', $this->createTableColumns(), $controllerTemplate);
            $controllerTemplate = str_replace('[rules]', $this->createRules('rules'), $controllerTemplate);
            $controllerTemplate = str_replace('[createRules]', $this->createStoreRules(), $controllerTemplate);
            $controllerTemplate = str_replace('[updateRules]', $this->createUpdateRules(), $controllerTemplate);

            $controllerTemplate = str_replace('[configuration]', $this->controllerConfiguration($importClass), $controllerTemplate);
            $useImportClass = '';
            if (request('has_import')) {
                $useImportClass = "use App\Imports\\$importClass;\r\n";
            }
            $controllerTemplate = str_replace('[useClass]', $useImportClass, $controllerTemplate);

            file_put_contents($controllerDir . '/' . $controllerName . '.php', $controllerTemplate);
        }
        return $controllerName;
    }

    public function generateResource()
    {
        $module_path = request('module_path');
        $module_path = explode('/',$module_path);
        $module_path = $module_path[count($module_path)-1];

        $resourcePath = resource_path("views/admin/{$module_path}");
        if (!file_exists($resourcePath)) {
            if (!file_exists(resource_path('views/admin'))) {
                @mkdir(resource_path('views/admin'), 0755);
            }
            @mkdir($resourcePath, 0755);
        }
        if (!file_exists("{$resourcePath}/table.blade.php")) {
            $tableTemplate = file_get_contents(__DIR__ . '/../../stubs/table.blade.php.stub');
            $tableTemplate = str_replace('[tableData]', $this->createResourceTableData(), $tableTemplate);
            file_put_contents($resourcePath . '/table.blade.php', $tableTemplate);
        }

        if (!file_exists("{$resourcePath}/create.blade.php")) {
            $formTemplate = file_get_contents(__DIR__ . '/../../stubs/form.blade.php.stub');
            $formTemplate = str_replace('[formData]', $this->createResourceFormData(), $formTemplate);
            file_put_contents($resourcePath . '/create.blade.php', $formTemplate);
        }

        if (!file_exists("{$resourcePath}/edit.blade.php")) {
            $formTemplate = file_get_contents(__DIR__ . '/../../stubs/form.blade.php.stub');
            $formTemplate = str_replace('[formData]', $this->createResourceFormData(true), $formTemplate);
            file_put_contents($resourcePath . '/edit.blade.php', $formTemplate);
        }

        if (request('has_export')) {
            if (!file_exists("{$resourcePath}/export.blade.php")) {
                $exportTemplate = file_get_contents(__DIR__ . '/../../stubs/export.blade.php.stub');
                $exportTemplate = str_replace('[columTable]', $this->createExportTableColumns(), $exportTemplate);
                $exportTemplate = str_replace('[tableData]', $this->createResourceTableData(false), $exportTemplate);
                file_put_contents($resourcePath . '/export.blade.php', $exportTemplate);
            }
        }

    }

    public function controllerConfiguration($importClass)
    {
        $str = '';
        if (request('has_import')) {
            $str .= '    protected $importExcel = '.$importClass.'::class;';
        }
        if (!request('has_create')) {
            if ($str != '') {
                $str .= "\r\n";
            }

            $str .= '    protected $canAdd = false;';
        }
        if (!request('bulk_action')) {
            if ($str != '') {
                $str .= "\r\n";
            }

            $str .= '    protected $bulkAction = false;';
        }
        if (request('has_filter')) {
            if ($str != '') {
                $str .= "\r\n";
            }

            $str .= '    protected $canFilter = true;';
        }
        if (request('has_import')) {
            if ($str != '') {
                $str .= "\r\n";
            }

            $str .= '    protected $canImport = true;';
        }
        if (request('has_export')) {
            if ($str != '') {
                $str .= "\r\n";
            }

            $str .= '    protected $canExport = true;';
        }
        if (!request('has_edit') && !request('has_delete')) {
            if ($str != '') {
                $str .= "\r\n";
            }

            $str .= '    protected $tableAction = true;';
        }
        return $str;
    }

    public function createResourceFormData($isEdit = false)
    {
        $form_name = request('form_name') ?? [];
        $form_type = request('form_type');
        $form_label = request('form_label');

        $str = '';
        $hasSelect = false;
        $hasEditor = false;
        foreach ($form_name as $i => $name) {
            $type = $form_type[$i];
            $label = $form_label[$i];
            $value = ($isEdit) ? '{{$row->' . $name . '}}' : '{{old(\'' . $name . '\')}}';
            switch ($type) {
                case 'text':
                    $str .= '<x-portal::input type="text" name="' . $name . '" label="' . $label . '" placeholder="' . $label . '" horizontal>' . $value . '</x-portal::input>';
                    break;
                case 'file':
                    $str .= '<x-portal::input type="file" name="' . $name . '" label="' . $label . '" placeholder="' . $label . '" horizontal>' . $value . '</x-portal::input>';
                    break;
                case 'foto':
                    $str .= '<x-portal::input.image name="' . $name . '" label="' . $label . '" placeholder="' . $label . '" horizontal>' . $value . '</x-portal::input.image>';
                    break;
                case 'email':
                    $str .= '<x-portal::input type="email" name="' . $name . '" label="' . $label . '" placeholder="' . $label . '" horizontal>' . $value . '</x-portal::input>';
                    break;
                case 'number':
                    $str .= '<x-portal::input type="number" name="' . $name . '" label="' . $label . '" placeholder="' . $label . '" horizontal>' . $value . '</x-portal::input>';
                    break;
                case 'password':
                    $str .= '<x-portal::input.password name="' . $name . '" label="' . $label . '" placeholder="' . $label . '" horizontal>' . $value . '</x-portal::input.password>';
                    break;
                case 'checkbox':
                    $str .= '<x-portal::input.checkbox name="' . $name . '" label="' . $label . '" horizontal>' . "\r\n";
                    $str .= '    <x-portal::input.checkbox.option class="me-5" checked name="' . $name . '" label="Sample option" value="1"></x-portal::input.checkbox.option>' . "\r\n";
                    $str .= '</x-portal::input.checkbox>';
                    break;
                case 'time':
                    $str .= '<x-portal::input type="time" name="' . $name . '" label="' . $label . '" placeholder="' . $label . '" horizontal>' . $value . '</x-portal::input>';
                    break;
                case 'date':
                    $str .= '<x-portal::input type="date" name="' . $name . '" label="' . $label . '" placeholder="' . $label . '" horizontal>' . $value . '</x-portal::input>';
                    break;
                case 'datetime':
                    $str .= '<x-portal::input type="tidatetime-localme" name="' . $name . '" label="' . $label . '" placeholder="' . $label . '" horizontal>' . $value . '</x-portal::input>';
                    break;
                case 'googlemaps':
                    $str .= '<x-portal::input type="text" name="' . $name . '" label="' . $label . '" placeholder="Location" horizontal>' . $value . '</x-portal::input>';
                    break;
                case 'hidden':
                    $str .= '<input name="' . $name . '" type="hidden" value=""/>';
                    break;
                case 'money':
                    $str .= '<x-portal::input type="number" step="any" name="' . $name . '" label="' . $label . '" placeholder="' . $label . '" horizontal>' . $value . '</x-portal::input>';
                    break;
                case 'radio':
                    $str .= '<x-portal::input type="number" name="' . $name . '" label="' . $label . '" placeholder="' . $label . '" class="input-money" horizontal>' . $value . '</x-portal::input>';
                    break;
                case 'select':
                    $str .= '<x-portal::input.select name="' . $name . '" label="' . $label . '" horizontal>' . "\r\n";
                    $str .= '    <option value="">Select ' . $label . '</option>' . "\r\n";
                    $str .= '</x-portal::input.select>';
                    $hasSelect = true;
                    break;
                case 'selectsearch':
                    $str .= '<x-portal::input.select name="' . $name . '" label="' . $label . '" class="searchable" horizontal>' . "\r\n";
                    $str .= '    <option value="">Select ' . $label . '</option>' . "\r\n";
                    $str .= '</x-portal::input.select>';
                    $hasSelect = true;
                    break;
                case 'textarea':
                    $str .= '<x-portal::input.textarea name="' . $name . '" label="' . $label . '" placeholder="' . $label . '" horizontal>' . $value . '</x-portal::input.textarea>';
                    break;
                case 'wysiwyg':
                    $values = ($isEdit) ? '{!!$row->' . $name . '!!}' : '{!!old(\'' . $name . '\')!!}';
                    $str .= '<x-portal::input.wysiwyg name="'.$name.'" label="'.$label.'" placeholder="'.$label.'" horizontal>'.$values.'</x-portal::input.wysiwyg>';
                    $hasEditor = true;
                    break;
                default:
                    break;
            }
            if ($i != count($form_name) - 1) {
                $str .= "\r\n";
            }
        }
        if ($hasSelect) {
            $str .= "\r\n<x-portal::input.select.asset />";
        }
        if($hasEditor){
            $str .= "\r\n<x-portal::input.wysiwyg.asset/>";
        }
        return $str;
    }
    public function createResourceTableData($index = true)
    {
        $table_name = request('table_name');
        $table_join = request('table_join');
        $table_join_relation = request('table_join_relation');
        $bulk_action = request('bulk_action');
        $has_edit = request('has_edit');
        $has_delete = request('has_delete');
        $module_path = request('module_path');
        $module_path = explode('/',$module_path);
        $module_path = $module_path[count($module_path)-1];

        $str = '';
        if ($bulk_action && $index) {
            $str .= "    @canDo('delete admin.{$module_path}')\r\n";
            $str .= "    <td>\r\n";
            $str .= '        <div class="form-checkbox">' . "\r\n";
            $str .= '            <input type="checkbox" class="table-checkbox" value="{{$row->id}}" name="selected_ids[]">' . "\r\n";
            $str .= '        </div>' . "\r\n";
            $str .= '    </td>' . "\r\n";
            $str .= "    @endcanDo\r\n";
        }
        foreach ($table_name as $i => $name) {
            $columnValue = ($table_join[$i]) ? "{$table_join[$i]}_{$table_join_relation[$i]}" : $name;

            if ($index) {
                $str .= "    ";
            } else {
                $str .= "            ";
            }
            $str .= '<td>{{$row->' . $columnValue . '}}</td>' . "\r\n";
        }
        if (($has_edit || $has_delete) && $index) {
            $str .= '    <td class="text-end">' . "\r\n";
            $str .= "        @if(canDo('edit admin.{$module_path}') || canDo('delete admin.{$module_path}'))\r\n";
            $str .= '        <div class="btn-group">' . "\r\n";
            $str .= '            <button type="button" class="btn btn-secondary dropdown-toggle btn-action" data-bs-toggle="dropdown" aria-expanded="false">' . "\r\n";
            $str .= "                Action\r\n";
            $str .= "            </button>\r\n";
            $str .= '            <ul class="dropdown-menu dropdown-menu-end dropdown-action">' . "\r\n";
            if ($has_edit) {
                $str .= "                @canDo('edit admin.{$module_path}')\r\n";
                $str .= "                <li>\r\n";
                $str .= '                    <a href="{{adminroute(\'admin.' . $module_path . '.edit\',$row->id)}}" class="dropdown-item">Edit</a>' . "\r\n";
                $str .= "                </li>\r\n";
                $str .= "                @endcanDo\r\n";
            }
            if ($has_delete) {
                $str .= "                @canDo('delete admin.{$module_path}')\r\n";
                $str .= "                <li>\r\n";
                $str .= '                    <a href="javascript:;" data-toggle="confirmation"' . "\r\n";
                $str .= '                        data-message="{{__(\'adminportal.delete_confirmation\')}}"' . "\r\n";
                $str .= '                        data-action="{{adminroute(\'admin.' . $module_path . '.destroy\',$row->id)}}" data-method="DELETE"' . "\r\n";
                $str .= '                        class="dropdown-item">Delete</a>' . "\r\n";
                $str .= "                </li>\r\n";
                $str .= "                @endcanDo\r\n";
            }
            $str .= "            </ul>\r\n";
            $str .= "        </div>\r\n";
            $str .= "        @endif\r\n";
            $str .= "    </td>";
        }
        return $str;
    }

    public function createDefaultQuery()
    {
        $table = request('table');
        $table_columns = request('table_name');
        $table_join = request('table_join');
        $table_join_relation = request('table_join_relation');

        $selectField = "";
        $tableSelect = "";
        $filterQuery = '';

        $joinQuery = null;
        foreach ($table_join as $y => $join) {
            if ($join) {
                if ($joinQuery) {
                    $joinQuery .= "            ->";
                }
                if ($joinQuery) {
                    $filterQuery .= "                ";
                }
                $filterQuery .= '$q->orWhere("' . $join . '.' . $table_join_relation[$y] . '", "like", "%" . $search . "%");' . "\r\n";
                $joinQuery .= 'join("' . $join . '", "' . $table . '.' . $join . '_id", "' . $join . '.id")' . "\r\n";
                $selectField .= ',"' . $join . '.' . $table_join_relation[$y] . ' as ' . $join . '_' . $table_join_relation[$y] . '"';
                $tableSelect = "{$table}.";
            }
        }

        $selectField = '"' . $tableSelect . '*"' . $selectField;
        foreach ($table_columns as $i => $col) { // loop table_columns
            if ($col) {
                if (($i == 0 && $joinQuery) || ($i != 0 && !$joinQuery)) {
                    $filterQuery .= '                ';
                }
                $filterQuery .= '$q->orWhere("' . $tableSelect . $col . '", "like", "%" . $search . "%");';
                if ($i != count($table_columns) - 1) {
                    $filterQuery .= "\r\n";
                }
            }
        }
        if ($filterQuery) {
            $filterQuery .= ";";
        }
        $whereCondition = ($joinQuery) ? '            ->' : '';
        $whereCondition .= 'where(function ($q) use ($search) {
                ' . $filterQuery . '
            })';
        $selectList = "\r\n" . '            ->select(' . $selectField . ')';

        return $joinQuery . $whereCondition . $selectList;
    }

    public function createStoreData()
    {
        $form_name = request('form_name') ?? [];
        $form_type = request('form_type');
        $str = '';
        $hasFile = false;
        foreach ($form_name as $i => $name) {
            $type = $form_type[$i];
            if ($i != 0) {
                $str .= "            ";
            }
            if (str_contains($type, 'password')) {
                $str .= '"' . $name . '" => \Hash::make($request->' . $name . '),';
            } else if (in_array($type, ['file', 'foto'])) {
                $str .= '"' . $name . '" => AdminPortal::uploadFile($request->' . $name . '),';
                $hasFile = true;
            } else {
                $str .= '"' . $name . '" => $request->' . $name . ',';
            }
            if ($i != count($form_name) - 1) {
                $str .= "\r\n";
            }
        }
        return (object)[
            'html' => $str,
            'has_file' => $hasFile
        ];
    }

    public function createUpdateData()
    {
        $form_name = request('form_name') ?? [];
        $form_type = request('form_type');
        $requestUpdate = "'" . implode("','", $form_name) . "'";
        $str = '$data =  $request->only([' . $requestUpdate . ']);' . "\r\n";
        foreach ($form_name as $i => $name) {
            $type = $form_type[$i];
            if (str_contains($type, 'password')) {
                $str .= '        if ($request->' . $name . ')  $data["' . $name . '"] = \Hash::make($request->' . $name . ');' . "\r\n";
            } else if (in_array($type, ['file', 'foto'])) {
                $str .= '        if ($request->' . $name . ') $data["' . $name . '"] = AdminPortal::uploadFile($request->' . $name . ');' . "\r\n";
            }
        }
        return $str;
    }

    public function createExportTableColumns()
    {
        $table_label = request('table_label');
        $str = '';

        foreach ($table_label as $i => $label) {
            if ($i != 0) {
                $str .= "            ";
            }
            $str .= "<th>{$label}</th>\r\n";
        }
        return $str;
    }

    public function createTableColumns()
    {
        $table = request('table');
        $table_name = request('table_name');
        $table_label = request('table_label');
        $columName = "";
        foreach (request('table_join') as $join) {
            if ($join != null) {
                $columName = "{$table}.";
            }
        }
        $str = '';

        $index = 0;
        foreach ($table_name as $i => $name) {
            $index++;
            $label = $table_label[$i];
            if ($index == 1 && $i != 0) {
                $str .= "        ";
            }
            $str .= '["label" => "' . $label . '", "name" => "' . $columName . $name . '"],';
            if ($index == 2 && $i != count($table_name) - 1) {
                $index = 0;
                $str .= "\r\n";
            }
        }
        return $str;
    }

    public function createRules($name)
    {
        $form_name = request('form_name') ?? [];
        $rules = request($name);
        $str = '';
        $index = 0;
        foreach ($form_name as $i => $name) {
            $rule = $rules[$i];
            if ($rule) {
                $index++;
                if ($i != 0) {
                    $str .= "        ";
                }
                $str .= '"' . $name . '" => "' . $rule . '",';
                if ($i != count($form_name) - 1) {
                    $str .= "\r\n";
                }
            }
        }
        return $str;
    }

    public function createStoreRules()
    {
        $hasRules = false;
        $str = '';
        foreach (request('rules_create') ?? [] as $rule) {
            if ($rule) {$hasRules = true;
                break;}
        }
        if ($hasRules) {
            $rules = $this->createRules('rules_create');
            $str .= "\r\n" . '    protected $createRules = [' . "\r\n";
            $str .= $rules;
            $str .= "\r\n" . '    ];';
        }
        return $str;
    }

    public function createUpdateRules()
    {
        $hasRules = false;
        $str = '';
        foreach (request('rules_update') ?? [] as $rule) {
            if ($rule) {$hasRules = true;
                break;}
        }
        if ($hasRules) {
            $rules = $this->createRules('rules_update');
            $str .= "\r\n" . '    protected $updateRules = [' . "\r\n";
            $str .= $rules;
            $str .= "\r\n" . '    ];';
        }
        return $str;
    }
}
