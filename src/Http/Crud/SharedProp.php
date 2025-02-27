<?php
namespace Laililmahfud\Adminportal\Http\Crud;

use Closure;

class SharedProp
{
     public Closure $all;
     public Closure $index;
     public Closure $create;
     public Closure $update;
     public Closure $detail;

     public function init()
     {
          $this->all = fn() => [];
          $this->index = fn() => [];
          $this->create = fn() => [];
          $this->update = fn() => [];
          $this->detail = fn() => [];
     }
     public function all(Closure $all)
     {
          $this->all = $all;
          return $this;
     }

     public function index(Closure $index)
     {
          $this->index = $index;
          return $this;
     }

     public function create(Closure $create)
     {
          $this->create = $create;
          return $this;
     }

     public function update(Closure $update)
     {
          $this->update = $update;
          return $this;
     }

     public function detail(Closure $detail)
     {
          $this->detail = $detail;
          return $this;
     }
}