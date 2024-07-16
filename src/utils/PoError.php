<?php

namespace Pholur\Utils;

class PoError extends \Exception
{
    public function __construct(PoErrorCode $eCode, mixed $append = '') {
        empty($append) || Loger::warning($append);
        return parent::__construct($eCode->errMsg(), $eCode->value);
    }
}
