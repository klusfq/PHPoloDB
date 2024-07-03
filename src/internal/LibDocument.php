<?php

namespace Pholo\Internal;

use Pholo\Document;
use Pholo\Utils\Loger;

class LibDocument
{

    /**
     * 构造DbDocument
     */
    public static function build(Document $pdoc) {
        $rdoc = Env::GetFFI()->PLDB_mk_doc();
        Loger::info($rdoc);

        foreach($pdoc->content as $k => $v) {
            PLDB_doc_set($rdoc, $k, toPLDBValue($v));
        }
    }

    /**
     * PLDBValue
     */
    public static function toPLDBValue(mixed $v): LibValue
    {
        $val = new LibValue($v);

        return $val;
    }
}
