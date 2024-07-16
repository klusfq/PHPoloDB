<?php

namespace Pholur;

use \FFI\CData;
use \FFI\Scalar\Type as Ftype;
use Pholur\Utils\Loger;

class Handle
{
    protected ?CData $handle = NULL;

    // TODO:
    public function out(): array {
        return [];
    }

    // TODO:
    public function asPtr() {
        return $this->handle;
    }
}
