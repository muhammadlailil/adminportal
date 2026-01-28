<?php
namespace Laililmahfud\Adminportal\Http\Crud;
use Closure;

class Import
{
     public string $sample;
     public string $format;
     public string $mimeType;
     public string $validation;
     public string|Closure $action;

     public static function make(string|Closure $class): Import
     {
          $static = app(static::class);
          $static->action = $class;
          return $static;
     }
     public function xls(string $sample): Import
     {
          $this->format = 'XLS or XLSX';
          $this->mimeType = '.xls,.xlsx';
          $this->validation = 'xls,xlsx';
          $this->sample = $sample;
          return $this;
     }

     public function csv(string $sample): Import
     {
          $this->format = 'CSV';
          $this->mimeType = '.csv';
          $this->validation = 'csv,txt';
          $this->sample = $sample;
          return $this;
     }
}