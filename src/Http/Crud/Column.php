<?php
namespace Laililmahfud\Adminportal\Http\Crud;

class Column
{
     public string $name;
     public string $label;
     public bool $sortable = false;
     public static function make($name) : Column
     {
          $static = app(static::class);
          $static->name = $name;
          $static->label = ucwords(str_replace('_',' ',$name));
          return $static;
     }

     public function label($label) : Column
     {
          $this->label = $label;
          return $this;

     }

     public function sortable(): Column
     {
          $this->sortable = true;
          return $this;
     }

}