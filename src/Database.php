<?php

namespace Pholur;

use Pholur\Internal\{Env, LibCollection};
use Pholur\Collection;
use Pholur\Utils\Loger;

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

    public function __destruct() {
        Env::GetFFI()->PLDB_close($this->dbCtx);
    }

    /**
     * 选择collection
     */
    public function collection(string $colName): Collection
    {
        $col = new Collection($colName, $this);

        $col->init();

        return $col;
    }

    /**
     * 获取db套接字(指针)
     */
    public function asPtr()
    {
        return $this->dbCtx;
    }

    /**
     * 是否存在Collection
     */
    private function existCollection(string $colName): bool
    {
    }
}
