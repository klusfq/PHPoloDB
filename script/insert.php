<?php
/**
 * 三层封装
 * 1. 上层api，专注于用户使用/实例化
 * 2. 中层封装，专注于类型变换（php类型 -> cData类型）
 * 3. 下层交互，专注于调用libc接口（动态链接库函数、cData类型 -> PLDB_*类型）
 */

require __DIR__ . '/../vendor/autoload.php';

$db = \Pholo\Database::openFile('./pholo.db');

$col = $db->collection('study');

$res = $col->insert([
    'object' => 'PHPolo',
    'user' => 'klusfq',
    'member' => 3,
    'isFinish' => false,
]);

var_dump($res);
