<?php
/**
 * 三层封装
 * 1. 上层api，专注于用户使用/实例化
 * 2. 中层封装，专注于类型变换（php类型 -> cData类型）
 * 3. 下层交互，专注于调用libc接口（动态链接库函数、cData类型 -> PLDB_*类型）
 */
use \Pholur\Utils\Loger;

require __DIR__ . '/../vendor/autoload.php';

const PRO_INIT_PATH = __DIR__ . '/../include';

Loger::info(PRO_INIT_PATH);


// $db = \Pholur\Database::openFile('./pholo.db');
$res = \Pholur\Internal\LibDocument::toPLDBValue(18);
var_dump($res);

$res = \Pholur\Internal\LibDocument::toPLDBValue('hello');
var_dump($res);

$res = \Pholur\Internal\LibDocument::toPLDBValue(false);
var_dump($res);

// -- 为了验证内存布局
// $pffi = \FFI::load(__DIR__ . "/cpby/other.h");
// $pffi->print_byte_stream(\FFI::addr($res->inner()), \FFI::sizeof($res->inner()));
