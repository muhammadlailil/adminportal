<?php

namespace Laililmahfud\Adminportal\JsTable;

class TableHtml
{
     public static function bulkCheckbox($id)
     {
          return '<div class="form-checkbox">
               <input type="checkbox" class="table-checkbox" value="' . $id . '" name="selected_ids[]">
          </div>';
     }

     public static function profileUser($name,$profile){
          return '<div class="profile-table align-items-center">
               <img src="'.asset($profile).'" alt="">
               '.$name.'
          </div>';
     }

     public static function labelBadge(){
          return '<span class="badge bg-success">Active</span>';
     }

     public static function actions($actions= []){
          return '<div class="btn-group d-block text-webkit-right">
          <button type="button" class="btn btn-secondary dropdown-toggle btn-action" data-bs-toggle="dropdown"
              aria-expanded="false">
              Action
          </button>
          <ul class="dropdown-menu dropdown-menu-end dropdown-action">
              <li>
                  <a href="" class="dropdown-item">Edit</a>
              </li>
              <li>
                  <a href="javascript:;" data-toggle="confirmation"
                      data-message=""
                      data-action="" data-method="DELETE"
                      class="dropdown-item">Delete</a>
              </li>
          </ul>
      </div>';
     }
}
