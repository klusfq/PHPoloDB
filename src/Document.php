<?php

namespace Pholo;

use \FFI\CData;
use Pholo\Internal\LibDocument;

class Document
{
    protected array $content = [];
    protected ?CData $pdoc = NULL;

    public function __construct(array|object $doc) {
        is_array($doc)
            ? $this->content = $doc
            : $this->content = (array) $doc;
    }

    public function asPtr(): CData {
        if (empty($pdoc)) {
            $this->pdoc = LibDocument::build($this);
        }

        return $this->pdoc;
    }

    public function print() {
        var_dump(LibDocument::parse($this));
    }

    public function getContent() {
        return $this->content;
    }
}
