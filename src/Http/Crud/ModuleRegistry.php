<?php

namespace Laililmahfud\Adminportal\Http\Crud;

use Illuminate\Routing\Route;
use Illuminate\Support\Collection;

class ModuleRegistry
{
    protected array $modules = [];

    public function register(string $class)
    {
        $this->modules[] = $class;
    }

    public function routes(): Collection
    {
        $routes = [];
        foreach($this->modules as $class){
            if($class::expose()){
                $resources = $class::getRoutes();
                $routes[] = [
                    'url' => $resources['prefix'],
                    'controller' => $class,
                    'resources' => $resources['resources'],
                    'additionals' => $resources['additionals']
                ];
            }
        }
        return collect($routes);
    }

    public function modules($badge = false,$resolve = false): array
    {
        $modules = [];
        foreach ($this->modules as $class) {   
            if($class::expose()){         
                if($resolve){
                    $class::resolve();
                }
                if ($module = $class::getModule()) {
                    if($badge){
                        $module['badge'] = $class::navigationBadge();
                    }
                    $modules[] = $module;
                }
            }
        }
        return $modules;
    }

    public function navigations($dashboard = true)
    {
        $permission = admin()->permission;
        $modules = collect($this->modules(badge : true))
            ->when(!$permission->is_superadmin, fn($modules) => $modules->filter(fn($module) => in_array("view:" . $module['policy'], $permission->permissions ?: [])))
            ->toArray();

        if($dashboard){
            $modules = collect([
                [
                    'group' => 'General',
                    'policy' => 'public',
                    'sorting' => -1,
                    'parent' => null,
                    'parent_icon' => null,
                    'url' => portal('home_page'),
                    'title' => 'Dashboard',
                    'icon' => 'layout-dashboard',
                    'badge' => '0'
                ],
                ...$modules
            ]);
        }else{
            $modules = collect($modules);
        }

        $top = $modules->where('is_bottom', false);
        $top = $top
            ->groupBy('group')
            ->map(
                fn($items) => $this->buildNavigationHierarchy($items, $top)
            )
            ->toArray();

        $bottom = $modules->where('is_bottom', true);
        $bottom = $this->buildNavigationHierarchy($bottom, $bottom);

        return (object) [
            'top' => $top,
            'bottom' => $bottom,
        ];
    }

    private function buildNavigationHierarchy($items, $navigations)
    {
        return $items->map(function ($item) use ($navigations) {
            $childrens = $navigations
                ->where('parent', '!=', '')
                ->where('parent', $item['parent']);
            $sorting = count($childrens) ? $item['parent_sorting'] : $item['sorting'];
            $sorting = $sorting ?: count($navigations);
            return (object) [
                'sorting' => $sorting,
                'title' => $item['parent'] ?: $item['title'],
                'icon' => $item['parent_icon'] ?: $item['icon'],
                'url' => !$item['parent'] ? $item['url'] : null,
                'badge' => $item['badge'],
                'childrens' => $childrens
                    ->map(fn($child) => (object) [
                        'sorting' => $child['sorting'] ?: count($childrens),
                        'title' => $child['title'],
                        'url' => $child['url'],
                        'badge' => $child['badge'],
                    ])
                    ->sortBy('sorting')
                    ->values()
                    ->toArray()
            ];
        })
            ->unique()
            ->sortBy('sorting')
            ->values();
    }
}
