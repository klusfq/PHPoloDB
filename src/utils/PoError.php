<?php

namespace Pholo\Utils;

class PoError extends \Exception
{
	public function __construct(PoErrorCode $eCode) {
		return match($eCode){
			PoErrorCode::NOT_SUPPORT_OBJECT => parent::__construct('not support object', 1_001_001),
			PoErrorCode::ARRAY_IS_NOT_LIST => parent::__construct('array is not list', 1_001_002),
		};
	}
}
