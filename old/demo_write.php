<?php

require __DIR__ . '/vendor/autoload.php';

use FFI\Scalar\Type;

// -- 创建环境实例
$polodb = FFI::load("./phpolodb.h");

// -- 创建数据库句柄
$dbsrc = $polodb->PLDB_open("./tmp.db");

$pId = FFI::new('uint32_t');
$pVer = FFI::new('uint32_t');

// -- collection名字
$name = Type::string('study');

// -- 获取collection：id / version
$polodb->PLDB_get_collection_meta_by_name(
    $dbsrc,
    FFI::cast('char*', FFI::addr($name)),
    FFI::addr($pId),
    FFI::addr($pVer));

var_dump($pId->cdata);
var_dump($pVer->cdata);

// $polodb->PLDB_close($dbsrc);
// echo 'Collection Meta: ' . var_export(compact('pId', 'pVer'), true) . PHP_EOL;


// -- 调用插入方法
# echo 'PLDBValue: ' . var_export($vl, true) . PHP_EOL;


$docSrc = $polodb->PLDB_mk_doc();

$vlid = $polodb->new("PLDBValue");
$vlid->tag = Type::uint8(0x16)->cdata;

$tp = $polodb->cast('int64_t', 2);

$vlid->v = $polodb->cast('union tv', $tp);

var_dump($vlid);
$polodb->PLDB_doc_set(
    $docSrc,
    FFI::cast('const char*', FFI::addr(Type::string('_id'))),
    FFI::addr($vlid));

echo '--------------------' . PHP_EOL;

$vlname = Type::string('fuquan klus');
$vl = $polodb->new("PLDBValue");
$vl->tag = Type::uint8(0x02)->cdata;
$vl->v = $polodb->cast('union tv', FFI::addr($vlname));

$ky = Type::string('name');
$polodb->PLDB_doc_set(
    $docSrc,
    FFI::cast('const char*', FFI::addr($ky)),
    FFI::addr($vl));

var_dump($docSrc);
echo '--------------------' . PHP_EOL;
// 
$insertRes = $polodb->PLDB_insert(
    $dbsrc,
    $pId->cdata,
    $pVer->cdata,
    $docSrc);

var_dump($insertRes);

$polodb->PLDB_close($dbsrc);
