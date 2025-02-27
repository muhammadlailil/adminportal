<?php
namespace Laililmahfud\Adminportal\Http\Crud;

use Closure;

class BulkAction
{
     public string $key;
     public string $label;
     public string $icon;
     public string $dialogConfirmation = "default";
     public Closure $handle;
     public ?string $variant = null;
     public static function make(string $label)
     {
          $static = app(static::class);
          $static->label = $label;
          $static->key = str()->slug($label);
          return $static;
     }

     public function icon(string $icon)
     {
          $this->icon = $icon;
          return $this;
     }
     public function dialog(string $dialogConfirmation)
     {
          $this->dialogConfirmation = $dialogConfirmation;
          return $this;
     }

     public function do(Closure $closure)
     {
          $this->handle = $closure;
          return $this;
     }

     public function danger()
     {
          $this->variant = "danger";
          return $this;
     }
}