<?php
namespace Laililmahfud\Adminportal\JsTable;


class JsTableResources
{
     public function send($data)
     {
          return response()->json([
               'recordsTotal' => $data->total(),
               'recordsFiltered' => $data->total(),
               'data' => collect($data->items())->map(function ($row) {
                    return $this->toArray($row);
               })
          ]);
     }

     public function toArray($row)
     {
     }
}
