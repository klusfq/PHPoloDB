<?php
/**
 * 三层封装
 * 1. 上层api，专注于用户使用/实例化
 * 2. 中层封装，专注于类型变换（php类型 -> cData类型）
 * 3. 下层交互，专注于调用libc接口（动态链接库函数、cData类型 -> PLDB_*类型）
 */
use \Pholo\Utils\Loger;
use FFI\Scalar\Type as Ftype;

require __DIR__ . '/../vendor/autoload.php';

const PRO_INIT_PATH = __DIR__ . '/../include';

// Loger::info(PRO_INIT_PATH);

// $db = \Pholo\Database::openFile('./pholo.db');

// -- 为了验证内存布局
// $pffi = \FFI::load(__DIR__ . "/cpby/other.h");

$ffi = \Pholo\Internal\Env::GetFFI();
$rdoc = $ffi->PLDB_mk_doc();
Loger::info($rdoc);

$res = \Pholo\Internal\LibDocument::toPLDBValue('klusfq');
var_dump($res->inner());

var_dump(
    FFI::sizeof($res->inner())
);

var_dump(
    FFI::string($res->inner()->v->str)
);

$errNo = $ffi->PLDB_doc_set($rdoc, 'name', $res->inner());
Loger::info($errNo);

$res = \Pholo\Internal\LibDocument::toPLDBValue(18);
$errNo = $ffi->PLDB_doc_set($rdoc, 'age', $res->inner());
Loger::info($errNo);


// var_dump(\FFI::typeof(\FFI::addr($res->inner()->tag))->getName());
// var_dump(\FFI::sizeof($res->inner()));

// $pffi->print_byte_stream(\FFI::addr($res->inner()), \FFI::sizeof($res->inner()));

echo PHP_EOL;

// $data = \FFI::new('uint8_t[16]');
// FFI::memcpy($data, $res->inner(), 16);
// foreach ($data as $val) {
//         echo " 0x$val";
// }
// echo "\n";

$oval = $ffi->new('PLDBValue');
$ffi->PLDB_doc_get($rdoc, 'name', \FFI::addr($oval));
Loger::info($oval->v->str);

$oval = $ffi->new('PLDBValue');
$ffi->PLDB_doc_get($rdoc, 'age', \FFI::addr($oval));
Loger::info($oval->v->int_value);
