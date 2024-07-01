<?php

namespace Pholo\Utils;

class Loger
{
    // TODO: 临时实现
    public static function info(mixed $var, string $fname = '', string $line = '') {
        $levelTrace = debug_backtrace();

        empty($fname) && $fname = $levelTrace[0]['file'];
        empty($line) && $line = $levelTrace[0]['line'];

        $msg = "Content=";
        if (is_array($var) || is_object($var)) {
            $msg .= json_encode($var);
        } else {
            $msg .= $var;
        }

        $hLevel = "[INFO]";
        $hTime = date('Y-m-d H:i:s');
        $hFile = "File={$fname}:{$line}";

        $o = implode(' ', [$hLevel, $hTime, $hFile, $msg]);

        echo $o . PHP_EOL;
    }
}
