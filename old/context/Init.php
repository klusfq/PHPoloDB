<?php

namespace Fuquan\Context;

use FFI\Scalar\Type;

class Init
{
    const HEADER_FILE = 'phpolodb.h';

    protected $ffi = NULL;

    protected $dbsrc = NULL;
    protected $dbName = NULL;

    public function getFFI() {
        return $this->ffi;
    }

    public function __construct($dbName) {
        $this->ffi = \FFI::load(self::HEADER_FILE);
        $this->dbsrc = $this->ffi->PLDB_open($dbName);
    }

    public function closeDB() {
        if (!empty($this->dbsrc)) {
            $this->ffi->PLDB_close($this->dbsrc);
        }

        $this->dbsrc = NULL;
    }

    protected $collect = NULL;
    public function use($colName) {
        $pId = \FFI::new('uint32_t');
        $pVer = \FFI::new('uint32_t');

        $name = Type::string('study');

        // -- 获取collection：id / version
        $this->ffi->PLDB_get_collection_meta_by_name(
            $this->dbsrc,
            \FFI::cast('char*', \FFI::addr($name)),
            \FFI::addr($pId),
            \FFI::addr($pVer));

        $this->collect = new \stdClass;
        $this->collect->id = $pId;
        $this->collect->ver = $pVer;

        Log::trace(json_encode([
            'pId' => $pId->cdata,
            'pVersion' => $pVer->cdata,
        ]));
    }

    public function __desctruct() {
        $this->closeDB();
    }
}
