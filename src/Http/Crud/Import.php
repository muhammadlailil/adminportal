<?php
namespace Laililmahfud\Adminportal\Http\Crud;

class Import
{
     public string $sample;
     public string $format;
     public string $mimeType;
     public string $validation;
     public string $action;

     public static function make(string $class): Import
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
          $this->validation = 'txt';
          $this->sample = $sample;
          return $this;
     }
}