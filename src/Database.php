<?php

namespace Fuquan\Pholo;

use Collection;

class Database
{
    const HEADER_FILE = PRO_INIT_PATH . '/phpolodb.h';

    protected static $ffi = NULl;
    protected static $dbCtx = NULL;

    /**
     * 打开文件
     */
    public static function openFile(string $filename): Database
    {
        /**
         * 静态变量
         * 1. 初始化ffi
         * 2. 初始化db上下文
         */
        self::$ffi = \FFI::load(self::HEADER_FILE);
        self::$dbCtx = self::$ffi->PLDB_open($filename);

        return new Database();
    }

    /**
     * 选择collection
     */
    public function collection(string $colName): Collection
    {
        $col = new Collection();
    }
}
