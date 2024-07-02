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
        $errNum = Env::GetFFI()->PLDB_get_collection_meta_by_name(
            $col->getDB()->asPtr(),
            FFI::cast('const char*', FFI::addr($col->getCdataName())),
            FFI::addr($col->id),
            FFI::addr($col->ver),
        );

        Loger::info($errNum);

        return $errNum;

        // TODO
    }

    public static function createByName(Collection $col): int {
        $errNum = Env::GetFFI()->PLDB_create_collection(
            $col->getDB()->asPtr(),
            FFI::cast('const char*', FFI::addr($col->getCdataName())),
            FFI::addr($col->id),
            FFI::addr($col->ver),
        );

        Loger::info($errNum);

        return $errNum;
        // TODO
    }
}
