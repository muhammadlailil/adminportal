<?php
namespace Laililmahfud\Adminportal\Http\Crud;
use Closure;

class Export
{
     public string $type;
     public string $label;
     public string $icon;
     public string $handle;


     public static function pdf(string|Closure $handle)
     {
          $static = app(static::class);
          $static->type = "pdf";
          $static->label = "Export to pdf";
          $static->icon = "file-type-pdf";
          $static->handle = $handle;
          return $static;
     }

     public static function xls(string|Closure $handle)
     {
          $static = app(static::class);
          $static->type = "xls";
          $static->label = "Export to xls";
          $static->icon = "file-type-xls";
          $static->handle = $handle;
          return $static;
     }

     public static function csv(string|Closure $handle)
     {
          $static = app(static::class);
          $static->type = "csv";
          $static->label = "Export to csv";
          $static->icon = "file-type-csv";
          $static->handle = $handle;
          return $static;
     }

     public static function make($label, $type = null)
     {
          $static = app(static::class);
          $static->tyoe = $type ?: str()->slug($label);
          $static->label = $label;
          return $static;
     }

     public static function icon($icon)
     {
          $static = app(static::class);
          $static->label = $icon;
          return $static;
     }

     public static function action($handle)
     {
          $static = app(static::class);
          $static->handle = $handle;
          return $static;
     }
}