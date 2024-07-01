<?php

namespace Pholo\Internal;

use Pholo\Collection;

class LibCollection
{
    public static function isExist(Collection $col): bool {
    }


    public static function getMetaByName(Collection $col) {
        $errNum = Env::GetFFI()->PLDB_get_collection_meta_by_name(
            $col->db->asPtr(),
            FFI::cast('const char*', FFI::addr($col->name)),
            FFI::addr($col->id),
            FFI::addr($col->ver),
        );
        // TODO
    }

    public static function createByName(Collection $col) {
        $errNum = Env::GetFFI()->PLDB_create_collection(
            $col->db->asPtr(),
            FFI::cast('const char*', FFI::addr($col->name)),
            FFI::addr($col->id),
            FFI::addr($col->ver),
        );
        // TODO
    }
}
