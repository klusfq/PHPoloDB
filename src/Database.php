<?php

namespace Pholo;

use Internal\Env;
use Collection;

class Database
{
    protected $dbCtx = NULL;

    /**
     * 打开文件
     */
    public static function openFile(string $filename): Database
    {
        return new Database($filename);
    }

    /**
     * 初始化db上下文
     */
    private function __construct(string $fname) {
        $this->dbCtx = Env::GetFFI()->PLDB_open($fname);
    }

    /**
     * 选择collection
     */
    public function collection(string $colName): Collection
    {
        if ($this->existCollection($colName)) {
        }

        $col = new Collection($colName, $this);
    }

    /**
     * 获取db套接字(指针)
     */
    public function asPtr()
    {
        return self::$dbCtx;
    }

    /**
     * 是否存在Collection
     */
    private function existCollection(string $colName): bool
    {
    }
}
