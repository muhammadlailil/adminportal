<?php
namespace Laililmahfud\Adminportal\Http\Crud;

class Action
{
     public ?string $create = null;
     public ?string $update = null;
     public ?string $delete = null;
     public bool $detail = false;
     public bool $filter = false;
     public bool $bulkAction = false;
     public bool $actionInLeft = false;
     public bool $crudPopup = false;
     /**
      * @var Export[]
      */
     public array $export = [];
     /**
      * @var Import
      */
     public ?Import $import = null;
     /**
      * @var BulkAction[]
      */
     public array $bulkActions = [];

     public function crud($create = null, $update = null, $delete = null): Action
     {
          $this->create = $create;
          $this->update = $update;
          $this->delete = $delete;
          return $this;

     }

     /**
      * @param Import $import
      */
     public function import(Import $import): Action
     {
          $this->import = $import;
          return $this;
     }

     /**
      * @param Export[] $items
      */
     public function export(array $items): Action
     {
          if (count($items)) {
               $this->export = $items;
          }
          return $this;
     }

     /**
      * @param BulkAction[] $items
      */
     public function bulkActions(array $items): Action
     {
          if (count($items)) {
               $this->bulkAction = true;
               $this->bulkActions = $items;
          }
          return $this;
     }

     public function inLeft(): Action
     {
          $this->actionInLeft = true;
          return $this;
     }

     public function filter(): Action
     {
          $this->filter = true;
          return $this;
     }

     public function usePopupForm(): Action
     {
          $this->crudPopup = true;
          return $this;
     }

     public function detail(): Action
     {
          $this->detail = true;
          return $this;
     }

}