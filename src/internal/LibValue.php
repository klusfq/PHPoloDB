<?php

namespace Pholo\Internal;

class LibValue
{
    protected \FFI\CData $data = null;

    public function __construct(mixed $origin) {
        $this->data = Env::GetFFI()->new('PLDBValue');
    }
}
