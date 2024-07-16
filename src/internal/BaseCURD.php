<?php
namespace Pholur\Internal;

use Pholur\{Database, Collection, Document, Handle};
use Pholur\Utils\{Loger, PoError, PoErrorCode};
use FFI\Scalar\Type as Ftype;
use \FFI;

class BaseCURD
{
    public static function insert(Database $db, Collection $col, Document $doc): void {
        $effectNum = Env::GetFFI()->PLDB_insert(
            $db->asPtr(),
            $col->id->cdata,
            $col->ver->cdata,
            $doc->asPtr(),
        );

        if ($effectNum === 0) {
            Loger::warning($effectNum);
            throw new PoError(PoErrorCode::INSERT_FAILED);
        }
    }

    public static function find(Database $db, Collection $col, Document $doc): array {
        $arrHandle = Env::GetFFI()->new('DbHandle*');

        var_dump($arrHandle);

        // -- arrHandle just a pointer, the memory is malloced by rust
        $rowNum = Env::GetFFI()->PLDB_find(
            $db->asPtr(),
            $col->id->cdata,
            $col->ver->cdata,
            $doc->asPtr(),
            FFI::addr($arrHandle),
        );
        Loger::info(['data_num' => $rowNum]);

        // if ($rowNum === 0) {
        //     return [];
        // }

        var_dump($arrHandle);

        $outVal = [];

        do {
            Env::GetFFI()->PLDB_step($arrHandle);
            $state = Env::GetFFI()->PLDB_handle_state($arrHandle);
            Loger::info(["state" => $state]);

            $oVal = Env::GetFFI()->new('PLDBValue');
            Env::GetFFI()->PLDB_handle_get($arrHandle, FFI::addr($oVal));

            var_dump($oVal);

            $outVal[] = LibValue::fromCData($oVal)->into();
        } while ($state == LibHandleStatus::HasRow);

        return $outVal;
    }
}

