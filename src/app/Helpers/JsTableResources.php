<?php
namespace Laililmahfud\Adminportal\Helpers;

class JsTableResources{
     
     public function __construct()
     {
     }

     public function send($data){
          return response()->json([
               'recordsTotal' => $data->total,
               'recordsFiltered' => $data->total,
               'data' => collect($data->items)->map(function($row){
                   return $this->toJson($row);
               })
          ]);
     }

     public function toJson($row){
     }
}