<?php
namespace Laililmahfud\Adminportal\Http\Crud;

class Export
{
     public string $type;
     public string $label;
     public string $icon;
     public string $handle;


     public static function pdf(string $handle)
     {
          $static = app(static::class);
          $static->type = "pdf";
          $static->label = "pdf";
          $static->icon = "file-type-pdf";
          $static->handle = $handle;
          return $static;
     }

     public static function xls(string $handle)
     {
          $static = app(static::class);
          $static->type = "xls";
          $static->label = "xls";
          $static->icon = "file-type-xls";
          $static->handle = $handle;
          return $static;
     }

     public static function csv(string $handle)
     {
          $static = app(static::class);
          $static->type = "csv";
          $static->label = "csv";
          $static->icon = "file-type-csv";
          $static->handle = $handle;
          return $static;
     }
}