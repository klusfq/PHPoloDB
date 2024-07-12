<?php

namespace Pholo\Internal;

use Pholo\Collection;
use Pholo\Utils\Loger;
use \FFI;

class LibCollection
{
    public static function isExist(Collection $col): bool {
        $errNum = self::getMetaByName($col);

        return $errNum === 0;
    }

    public static function getMetaByName(Collection $col): int {
        $tmpColName = $col->getCdataName();
        $errNum = Env::GetFFI()->PLDB_get_collection_meta_by_name(
            $col->getDB()->asPtr(),
            FFI::cast('const char*', FFI::addr($tmpColName)),
            FFI::addr($col->id),
            FFI::addr($col->ver),
        );

        Loger::info("get collection meta data over");

        return $errNum;
        // TODO
    }

    public static function createByName(Collection $col): int {
        $tmpColName = $col->getCdataName();
        $errNum = Env::GetFFI()->PLDB_create_collection(
            $col->getDB()->asPtr(),
            FFI::cast('const char*', FFI::addr($tmpColName)),
            FFI::addr($col->id),
            FFI::addr($col->ver),
        );

        Loger::info("create collection over");

        return $errNum;
        // TODO
    }
}
