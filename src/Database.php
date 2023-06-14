<?php

namespace \Fuquan\Pholo;

use Collection;

class Database
{
    const HEADER_FILE = PRO_INIT_PATH . '/phpolodb.h';

    protected static $ffi;
    protected static $dbCtx;

    /**
     * 打开文件
     */
    public static function openFile(string $filename) Database
    {
        /**
         * 静态变量
         * 1. 初始化ffi
         * 2. 初始化db上下文
         */
        self::$ffi = \FFI::load(self::HEADER_FILE);
        self::$dbCtx = self::$ffi->PLDB_open($filename);
    }

    /**
     * 选择collection
     */
    public function collection(string $colName) Collection
    {
        $col = new Collection();
    }
}
