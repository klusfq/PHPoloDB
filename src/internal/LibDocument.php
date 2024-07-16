<?php

namespace Pholur\Internal;

use Pholur\Document;
use Pholur\Utils\Loger;
use \FFI\CData;
use \FFI;

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
            $tVal = LibValue::from($v);
            // TODO: 返回值处理
            Env::GetFFI()->PLDB_doc_set($rdoc, $k, $tVal->inner());
        }

        return $rdoc;
    }

    /**
     * 遍历DbDocument
     */
    public static function iterData(LibValue $val): array {
        if (!$val->isDocument()) {
            return [];
        }

        $outVal = [];

        $docIter = Env::GetFFI()->PLDB_doc_iter($val->innerDocument());

        do {
            $initKeyLen = 32;
            $oKey = FFI::new("char[{$initKeyLen}]");
            $oValue = Env::GetFFI()->new('PLDBValue');

            $keyLen = Env::GetFFI()->PLDB_doc_iter_next(
                $docIter,
                FFI::addr($oKey[0]),
                $initKeyLen,
                FFI::addr($oValue),
            );
            if ($keyLen == 0) {
                break;
            }

            $finKey = FFI::string(FFI::addr($oKey), $keyLen);

            Loger::info(['key' => $finKey]);

            $outVal += [
                $finKey => LibValue::fromCData($oValue)->into(),
            ];

        } while ($keyLen > 0);

        return $outVal;
    }
}
