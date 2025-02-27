<?php
namespace Laililmahfud\Adminportal\Http\Crud;

class Table
{
     /**
      * @var Column[]
      */
     public array $columns = [];

     public int $limit = 10;


     /**
      * @param Column[] $items
      */
     public function columns(array $columns): Table
     {
          $this->columns = $columns;
          return $this;
     }

     public function perpage(int $perPage): Table
     {
          $this->limit = $perPage;
          return $this;
     }
}