<?php

namespace Laililmahfud\Adminportal\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_METHOD)]
class Route
{
     public function __construct(
          public string $url,
          public string $method = "GET",
          public ?string $name = null
     ) {
     }
}
