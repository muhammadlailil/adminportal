<?php
namespace Laililmahfud\Adminportal\Http\Crud;

class Rules
{
     public array $all = [];
     public array $create = [];
     public array $update = [];
     /**
      *
      * @param array<string, string|array> $rules 
      */
     public function make(array $rules): Rules
     {
          $this->all = $rules;
          return $this;
     }
     /**
      *
      * @param array<string, string|array> $rules 
      */
     public function create(array $rules): Rules
     {
          $this->create = $rules;
          return $this;
     }

     /**
      *
      * @param array<string, string|array> $rules 
      */
     public function update(array $rules): Rules
     {
          $this->update = $rules;
          return $this;
     }
}