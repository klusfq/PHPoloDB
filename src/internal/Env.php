<?php

namespace Pholur\Internal;

class Env
{
    const HEADER_FILE = PRO_INIT_PATH . '/pholodb.h';

    protected static $ffi = NULL;

    private function __construct() {}

    public static function GetFFI() {
        if (is_null(self::$ffi)) {
            self::$ffi = \FFI::load(self::HEADER_FILE);
        }

        return self::$ffi;
    }
}
