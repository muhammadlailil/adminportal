<?php
namespace Laililmahfud\Adminportal\Enums;

use Illuminate\Support\Facades\Blade;

enum UserStatus: int
{
     case InActive = 0;
     case Active = 1;

     public function label(): string
     {
          return match ($this->value) {
               0 => 'In Active',
               1 => 'Active',
               default => 'Unknown'
          };
     }

     public function badge(): string
     {
          return Blade::render('<x-portal::badge :color="$type">{{ $label }}</x-portal::badge>', [
               'type' => $this->value == 0 ? 'red' : 'green',
               'label' => $this->label(), 
           ]);
     }

}