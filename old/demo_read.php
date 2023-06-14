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

$result = $polodb->new('DbHandle*');

var_dump($result);

try {
    $polodb->PLDB_find($dbsrc, $pId->cdata, $pVer->cdata, NULL, FFI::addr($result));

    var_dump($result);

} catch (\Exception $e) {
    echo $e->getMessage();
} finally {
    $polodb->PLDB_close($dbsrc);
}
