<?php
namespace Pholo\Internal;

use \Pholo\{Database, Collection, Document};
use \Pholo\Utils\Loger;

class BaseCURD
{
    public static function insert(Database $db, Collection $col, Document $doc)
    {
        $pId = FFI::new('uint32_t');
        $pVer = FFI::new('uint32_t');

        $errNum = Env::GetFFI()->PLDB_get_collection_meta_by_name(
            $db->asPtr(),
            FFI::cast('const char*', FFI::addr($col->name)),
            FFI::addr($pId),
            FFI::addr($pVer),
        );

        $okNum = Env::GetFFI()->PLDB_insert(
            $db->asPtr(),
            $pId->cdata,
            $pVer->cdata,
            $doc->asPtr(),
        );

        Loger::info($okNum);

        if ($okNum > 0) {
            throw new PoError(PoErrorCode::);
        }
    }
}

