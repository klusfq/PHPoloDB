<?php
namespace Pholo\Internal;

use Pholo\{Database, Collection, Document, Handle};
use Pholo\Utils\{Loger, PoError, PoErrorCode};
use \FFI;

class BaseCURD
{
    public static function insert(Database $db, Collection $col, Document $doc): void {
        $okNum = Env::GetFFI()->PLDB_insert(
            $db->asPtr(),
            $col->id->cdata,
            $col->ver->cdata,
            $doc->asPtr(),
        );

        Loger::info($okNum);

        if ($okNum > 0) {
            throw new PoError(PoErrorCode::INSERT_FAILED);
        }
    }

    public static function find(Database $db, Collection $col, Document $doc, array $field): Handle {
        $handle = new Handle();

        $okNum = Env::GetFFI()->PLDB_find(
            $db->asPtr(),
            $col->id->cdata,
            $col->ver->cdata,
            $doc->asPtr(),
            FFI::addr($handle->asPtr()),
        );

        Loger::info($okNum);

        if ($okNum > 0) {
            throw new PoError(PoErrorCode::FIND_FAILED);
        }

        return $handle;
    }
}

