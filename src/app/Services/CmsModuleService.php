<?php
namespace Laililmahfud\Adminportal\Services;

use Laililmahfud\Adminportal\Models\CmsModuls;

class CmsModuleService
{
    public function __construct(
        public $model = CmsModuls::class,
    ) {}

    public function updateOrCreate($attributes = [], $id)
    {
        return $this->model::updateOrCreate(['id' => $id], $attributes);
    }

    public function create($attributes = [])
    {
        return $this->model::create($attributes);
    }

    public function update($attributes = [], $id)
    {
        return $this->model::findOrFail($id)->update($attributes);
    }

    public function delete($id)
    {
        return $this->model::findOrFail($id)->delete();
    }

    public function findBy($where)
    {
        return $this->model::where($where);
    }

    public function find($id)
    {
        return $this->model::findOrFail($id);
    }

    public function all(){
        return $this->model::oldest('sorting')->get();
    }

    public function treeModuls($user_id = null)
    {
        $subModul = $this->model::whereNotNull('parent_id')
            ->select(['name', 'path', 'icon', 'id', 'parent_id', 'type'])
            ->oldest('sorting')
            ->get();

        return json_decode($this->model::whereNull('parent_id')
                ->select(['name', 'path', 'icon', 'id', 'type'])
                ->oldest('sorting')
                ->get()
                ->map(function ($row) use ($subModul) {
                    $row->sub = json_decode($subModul->filter(function ($item) use ($row) {
                        return $item->parent_id == $row->id;
                    })
                            ->values()
                            ->toJson());
                    return $row;
                })
                ->values()
                ->toJson());
    }
}
