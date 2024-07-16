<?php

namespace Pholur\Internal;

use Pholur\Document;
use Pholur\Utils\Loger;
use \FFI\CData;

class LibDocument
{
    /**
     * 解析DbDocument
     */
    public static function parse(Document $doc): array {
        $outValue = [];
        foreach($doc->getContent() as $k => $v) {
            $tValue = Env::GetFFI()->new('PLDBValue');
            // TODO: 返回值处理
            Env::GetFFI()->PLDB_doc_get($doc->asPtr(), $k, \FFI::addr($tValue));
            $outValue[] = $tValue;
        }
        return $outValue;
    }

    /**
     * 构造DbDocument
     */
    public static function build(Document $doc): CData {
        $rdoc = Env::GetFFI()->PLDB_mk_doc();
        Loger::info($doc);

        foreach($doc->getContent() as $k => $v) {
            $tVal = self::toPLDBValue($v);
            // TODO: 返回值处理
            Env::GetFFI()->PLDB_doc_set($rdoc, $k, $tVal->inner());
        }

        return $rdoc;
    }

    /**
     * PLDBValue
     */
    public static function toPLDBValue(mixed $v): LibValue
    {
        $val = LibValue::from($v);

        return $val;
    }
}
