<?php
/**
 * 三层封装
 * 1. 上层api，专注于用户使用/实例化
 * 2. 中层封装，专注于类型变换（php类型 -> cData类型）
 * 3. 下层交互，专注于调用libc接口（动态链接库函数、cData类型 -> PLDB_*类型）
 */
use \Pholo\Utils\Loger;

require __DIR__ . '/../vendor/autoload.php';

const PRO_INIT_PATH = __DIR__ . '/../include';

Loger::info(PRO_INIT_PATH);

// $db = \Pholo\Database::openFile('./pholo.db');

$res = \Pholo\Internal\LibDocument::toPLDBValue(18);
var_dump($res->inner());
// var_dump(\FFI::typeof(\FFI::addr($res->inner()->tag))->getName());
var_dump(\FFI::sizeof($res->inner()));

$ffi = \Pholo\Internal\Env::GetFFI();
$rdoc = $ffi->PLDB_mk_doc();
Loger::info($rdoc);

$errNo = $ffi->PLDB_doc_set($rdoc, 'name', $res->inner());
Loger::info($errNo);

Loger::info($rdoc);
