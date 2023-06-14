<?php
namespace Fuquan\Context;

class Log
{
    public static function trace(string $log) {
        $type = strtoupper(__FUNCTION__);
        $ntime = date("Y-m-d H:i:s");

        echo "\033[1;32m{$type}\033[0m [{$ntime}] log: {$log}" . PHP_EOL;
    }
}
