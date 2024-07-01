<?php

namespace Pholo\Internal;

use Pholo\Document;

class LibDocument
{

    /**
     * 构造
     */
    public static function build(Document $pdoc) {
        $rdoc = PLDB_mk_doc();
        foreach($pdoc->content as $k => $v) {
            PLDB_doc_set($rdoc, $k, toPLDBValue($v));
        }
    }

    public static function toPLDBValue(mixed $v) LibValue {
        $originData = Type::trans($v);
    }
}
