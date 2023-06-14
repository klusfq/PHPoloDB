<?php

require __DIR__ . '/vendor/autoload.php';

use \Fuquan\Context\Log;
use \FFI\Scalar\Type;

$init = new \Fuquan\Context\Init('./tmp.db');
$init->use('study');
$init->closeDB();

$ffi = $init->getFFI();

$doc_src = $ffi->PLDB_mk_doc();

$docValue = $ffi->new("PLDBValue");
$docValue->tag = Type::uint8(0x16)->cdata;
$docValue->v = $ffi->cast('union tv', $ffi->cast('int64_t', 96));

Log::trace(var_export($docValue, true));

$ffi->PLDB_doc_set(
    $doc_src,
    FFI::cast('const char*', FFI::addr(Type::string('_id'))),
    FFI::addr($docValue));

// -- 以上是生成doc部分

$getDoc = $ffi->new("PLDBValue");
$addr = FFI::addr($getDoc);

// var_dump(FFI::sizeof($getDoc));
// var_dump($addr);

$ffi->PLDB_doc_get(
    $doc_src,
    FFI::cast('const char*', FFI::addr(Type::string('_id'))),
    FFI::addr($getDoc));

echo 'finish doc get' . PHP_EOL;

Log::trace(var_export($getDoc->v->int_value, true));

$ffi->PLDB_free_doc($doc_src);
