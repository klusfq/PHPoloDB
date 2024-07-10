<?php

namespace Pholo\Utils;

class Loger
{
    protected static $isColor = false;

    public static function info(mixed $var, string $fname = '', string $line = '') {
        $levelTrace = debug_backtrace();

        empty($fname) && $fname = $levelTrace[0]['file'];
        empty($line) && $line = $levelTrace[0]['line'];

        $level = "INFO";
        if (self::$isColor) {
            $level = "\e[1;32m{$level}\e[0m";
        }

        self::log($level, $var, $fname, $line);
    }


    public static function warning(mixed $var, string $fname = '', string $line = '') {
        $levelTrace = debug_backtrace();

        empty($fname) && $fname = $levelTrace[0]['file'];
        empty($line) && $line = $levelTrace[0]['line'];

        $level = "WARNING";
        if (self::$isColor) {
            $level = "\e[1;31m{$level}\e[0m";
        }

        self::log($level, $var, $fname, $line);
    }

    public static function setColor() {
        self::$isColor = true;
    }

    private static function log($level, $var, $fname, $line) {
        $msg = "Content=";
        if (is_array($var) || is_object($var)) {
            $msg .= json_encode($var);
        } else {
            $msg .= $var;
        }

        $hLevel = "[{$level}]";
        $hTime = date('Y-m-d H:i:s');
        $hFile = "File={$fname}:{$line}";

        $o = implode(' ', [$hLevel, $hTime, $hFile, $msg]);

        echo $o . PHP_EOL;

    }
}
