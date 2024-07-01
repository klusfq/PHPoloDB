<?php

require __DIR__ . '/../vendor/autoload.php';

$xop = [
	'name' => 'klusfq',
	'age' => 28,
	'grade' => 99.9,
	'isMan' => true,
	'xpp' => [1, 20, 39],
];

foreach ($xop as $k => $v) {
	var_dump(\Pholo\Utils\Type::trans($v));
}
