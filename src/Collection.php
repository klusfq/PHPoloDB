<?php

namespace Pholo;

use Document;
use \FFI::CData;

class Collection
{
    protected string $name = '';
    protected Database $db = NULL;

    protected CData $ver = NULL;
    protected CData $id = NULL;

    public function __construct(string $colName, Database $db) {
        $this->db = &$db;
        $this->name = $colName;

        $this->ver = \FFI::new('uint32_t');
        $this->id = \FFI::new('uint32_t');
    }

    /**
     * 插入一条记录
     *
     * @return  bool     插入成功或失败
     */
    public function insert(array $row) bool
    {
        try {
            $doc = new Document($row);

            Loger::info($doc);

            BaseCURD::insert($this->db, $this, $doc);
        } catch (\Exception $e) {
        }
    }

    /**
     * 插入一条记录
     * @param   []Docmument     $rows   插入文档列表
     *
     * @return  int             影响文档数
     */
    public function insertBatch(array $rows) int
    {
    }

    /**
     * 查询数据
     * @param   array           $fields     元数据
     * @param   array           $conds      查询条件
     *
     * @return  []Document      文档列表
     */
    public function find(array $fields, array $conds = []) array
    {
    }

    /**
     * 更新数据
     * @param   array           $row        更新文档
     * @param   array           $conds      查询条件
     *
     * @return  int             影响文档数
     */
    public function update(array $row, array $conds) int
    {
    }

    /**
     * 删除数据
     * @param   array           $conds      查询条件
     *
     * @return  []Document      文档列表
     */
    public function delete(array $conds) array
	{
	}
}
