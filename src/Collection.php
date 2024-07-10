<?php

namespace Pholo;

use \FFI\CData;
use \FFI\Scalar\Type as Ftype;
use Pholo\Utils\Loger;
use Pholo\Internal\{LibCollection, BaseCURD};

class Collection
{
    protected string $name = '';
    protected ?Database $db = NULL;

    public ?CData $ver = NULL;
    public ?CData $id = NULL;

    public function __construct(string $colName, Database $db) {
        $this->db = $db;
        $this->name = $colName;

        $this->ver = \FFI::new('uint32_t');
        $this->id = \FFI::new('uint32_t');
    }

    /**
     * 初始化
     */
    public function init() {
        if (LibCollection::isExist($this))
            return;

        Loger::info("collection <{$this->name}> is not exist, create it!");
        LibCollection::createByName($this);
    }

    /**
     * 插入一条记录
     *
     * @return  bool     插入成功或失败
     */
    public function insert(array $row): bool
    {
        try {
            $doc = new Document($row);

            Loger::info($doc);

            BaseCURD::insert($this->db, $this, $doc);
        } catch (\Exception $e) {
            Loger::warning($e->getMessage(), $e->getFile(), $e->getLine());
        }

        return false;
    }

    /**
     * 查询数据
     * @param   array           $fields     元数据
     * @param   array           $conds      查询条件
     *
     * @return  []Document      文档列表
     */
    public function find(array $fields, array $conds = []): array
    {
    }

    /**
     * 插入一条记录
     * @param   []Docmument     $rows   插入文档列表
     *
     * @return  int             影响文档数
     */
    public function insertBatch(array $rows): int
    {
    }

    /**
     * 更新数据
     * @param   array           $row        更新文档
     * @param   array           $conds      查询条件
     *
     * @return  int             影响文档数
     */
    public function update(array $row, array $conds): int
    {
    }

    /**
     * 删除数据
     * @param   array           $conds      查询条件
     *
     * @return  []Document      文档列表
     */
    public function delete(array $conds): array
	{
	}

    public function getDB(): Database {
        return $this->db;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getCdataName(): CData {
        return Ftype::string($this->name);
    }

}
