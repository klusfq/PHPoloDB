<?php
namespace Pholo\Internal;

use Pholo\{Database, Collection, Document};
use Pholo\Utils\{Loger, PoError, PoErrorCode};
use FFI\Scalar\Type as Ftype;
use \FFI;

class BaseCURD
{
    public static function insert(Database $db, Collection $col, Document $doc)
    {
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

    public static function find(Database $db, Collection $col, Document $doc)
    {
    }
}

