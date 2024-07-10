<?php

namespace Pholo\Utils;

class PoError extends \Exception
{
    public function __construct(PoErrorCode $eCode) {
        return parent::__construct($eCode->errMsg(), $eCode->value);
    }
}
