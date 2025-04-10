<?php
namespace Laililmahfud\Adminportal\Http\Crud;

use Laililmahfud\Adminportal\Attributes\Route;
use ReflectionClass;
use Laililmahfud\Adminportal\Http\Crud;

class AdminModule
{
    use AdminModuleController;
    protected static string $url;
    protected static string $description;
    protected static string $policy;
    protected static string $repository;
    protected static string $title = "";
    protected static string $icon = "";
    protected static string $group = "General";
    protected static string $resourcePath = "";
    protected static string $parent = "";
    protected static string $parentIcon = "";
    protected static bool $bottomNavigation = false;
    protected static bool $hideNavigation = false;
    protected static int $sorting = 0;
    protected static int $parentSorting = 0;
    protected static Crud\Action $action;
    protected static Crud\Table $table;
    protected static Crud\SharedProp $shared;
    protected static Crud\Rules $rules;

    public static function resolve()
    {
        $shared = app(Crud\SharedProp::class);
        $shared->init();

        self::$action = static::action(app(Crud\Action::class));
        self::$shared = static::shared($shared);
        self::$rules = static::rules(app(Crud\Rules::class));
    }
    public static function getRoutes()
    {
        self::$action = static::action(app(Crud\Action::class));

        return [
            'prefix' => "/" . static::$url,
            'policy' => static::$policy,
            'resources' => self::getRouteResources(),
            'additionals' => self::getAdditionalRoutes()
        ];
    }
    public static function getRouteResources(): array
    {
        $resources = ['index'];

        foreach (['create' => ['create', 'store'], 'update' => ['edit', 'update'], 'delete' => ['destroy'], 'detail' => ['show']] as $key => $actions) {
            if (self::$action->{$key}) {
                if (self::$action->crudPopup && in_array($key, ['create', 'update'])) {
                    $actions = $key == 'create' ? ['store'] : ['update'];
                }
                $resources = array_merge($resources, (array) $actions);
            }
        }

        return $resources;
    }

    public static function getAdditionalRoutes(): array
    {
        $action = self::$action;

        $routes = [];
        $routeName = explode("/", static::$url);
        $routeName = $routeName[count($routeName) - 1];
        if (count($action->bulkActions)) {
            $routes[] = [
                'url' => '/' . static::$url . "/bulk-actions",
                'action' => 'bulkActions',
                'name' => $routeName . '.bulk-actions',
                'method' => 'POST'
            ];
        }
        if (count($action->export)) {
            $routes[] = [
                'url' => '/' . static::$url . "/export",
                'action' => 'export',
                'name' => $routeName . '.export',
                'method' => 'POST'
            ];
        }

        if ($action->import) {
            $routes[] = [
                'url' => '/' . static::$url . "/import",
                'action' => 'import',
                'name' => $routeName . '.import',
                'method' => 'POST'
            ];
        }

        
        $reflection = new ReflectionClass(static::class);
        foreach ($reflection->getMethods() as $method) {
            $attributeInstances = $method->getAttributes(Route::class);
            if (!empty($attributeInstances)) {
                foreach ($attributeInstances as $attributeInstance) {
                    $route = $attributeInstance->newInstance();
                    $name = $route->name;
                    if(!$name){
                        $names = explode("/", $route->url);
                        $name = $names[count($names) - 1];
                    }
                    $routes[] = [
                        'url' => '/' . static::$url .$route->url,
                        'action' => $method->getName(),
                        'name' => $routeName . '.'.$name,
                        'method' => $route->method
                    ];
                }
            }
        }
        return $routes;
    }
    public static function getActions(): array
    {
        $actions = [];
        $action = self::$action;

        foreach (['create', 'update', 'delete', 'detail', 'import', 'bulkAction', 'filter'] as $key) {
            if ($action->{$key}) {
                $actions[$key] = true;
            }
        }

        $actions['export'] = collect($action->export)->map(fn(Export $export) => [
            'key' => $export->type,
            'label' => "Export to " . $export->label,
            'icon' => $export->icon,
        ]);
        $actions['bulk_actions'] = collect($action->bulkActions)->map(fn(BulkAction $action) => [
            'key' => $action->key,
            'label' => $action->label . " Selected",
            'icon' => $action->icon,
            'variant' => $action->variant,
            'dialog' => $action->dialogConfirmation
        ]);
        $actions['in_left'] = $action->actionInLeft;
        $actions['action'] = $action->action;
        $actions['popup_form'] = $action->crudPopup;

        return $actions;
    }


    public static function getPermission(): array
    {
        $permissions = [
            'view:'.static::$policy
        ];
        $action = static::$action;

        foreach (['create', 'update', 'delete', 'detail', 'import','export'] as $key) {
            if ($action->{$key}) {
                $permissions[] = $key.":".static::$policy;
            }
        }

        foreach($action->bulkActions as $bulkAction){
            $permissions[] = "bulk-action:".$bulkAction->key."-".static::$policy;
        }
      
        return $permissions;
    }

    public static function getTables(): object
    {
        self::$table = static::table(app(Crud\Table::class));
        $columns = collect(self::$table->columns)->map(fn(Column $column) => [
            'name' => $column->name,
            'label' => $column->label,
            'sorting' => $column->sortable
        ]);
        return (object) [
            'columns' => $columns,
            'limit' => request('limit', self::$table->limit)
        ];
    }

    public static function getImport()
    {
        if (!static::$action->import) {
            return [];
        }
        return [
            'sample' => static::$action->import->sample,
            'accepted' => static::$action->import->mimeType,
            'format' => static::$action->import->format,
        ];
    }

    public static function getModule($permission = true): ?array
    {
        if(static::$hideNavigation){
            return null;
        }

        return [
           'group' => static::$group,
           'policy' => static::$policy,
           'title' => static::getNavigationTitle(),
           'icon' => static::$icon,
           'sorting' => static::$sorting,
           'parent_sorting' => static::$parentSorting,
           'url' => portal("admin_path")."/".static::$url,
           'parent' => static::getNavigationParentTitle(),
           'parent_icon' => static::$parentIcon,
           'is_bottom' => static::$bottomNavigation,
           'permissions' => $permission ? self::getPermission() : []
        ];
    }

    public static function getUrl(): string
    {
        return static::$url ?? "";
    }

    public static function action(Crud\Action $action): Crud\Action
    {
        return $action;
    }

    public static function table(Crud\Table $table): Crud\Table
    {
        return $table;
    }

    public static function shared(Crud\SharedProp $shared): Crud\SharedProp
    {
        return $shared;
    }

    public static function rules(Crud\Rules $rules): Crud\Rules
    {
        return $rules;
    }

    public static function navigationBadge()
    {
        return null;
    }

    public static function getTitle(){
        return static::$title;
    }

    public static function getNavigationTitle(){
        return static::$title;
    }

    public static function getNavigationParentTitle(){
        return static::$parent;
    }
    public static function expose(){
        return true;
    }
}