<?php
namespace Laililmahfud\Adminportal\JsTable\Resources;

use Laililmahfud\Adminportal\Helpers\JsTableResources;
use Laililmahfud\Adminportal\JsTable\TableHtml;

class UserJsTableResources extends JsTableResources{

     public function toJson($row){
          return [
               TableHtml::bulkCheckbox($row->id),
               TableHtml::profileUser($row->name,$row->profile),
               $row->email,
               $row->role_name,
               TableHtml::labelBadge($row->status),
               TableHtml::actions()
          ];
     }

}