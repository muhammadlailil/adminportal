<?php
namespace Laililmahfud\Adminportal\JsTable\Resources;

use Laililmahfud\Adminportal\JsTable\TableHtml;
use Laililmahfud\Adminportal\JsTable\JsTableResources;

class UserJsTableResources extends JsTableResources{

     public function toArray($row){
          return [
               TableHtml::checkbox($row->id),
               TableHtml::profileUser($row->name,$row->profile),
               $row->email,
               $row->role_name,
               TableHtml::labelBadge($row->status),
               TableHtml::actions()
          ];
     }

}