<?php

namespace Pholo;

class Document
{
    protected object $content = NULL;

    public function __construct(array|object $doc) {
        is_array($doc)
            ? $this->content = (object) $doc
            : $this->content = $doc;
    }
}
