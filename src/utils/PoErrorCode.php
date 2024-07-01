<?php

namespace Pholo\Utils;

enum PoErrorCode: int
{
    case NOT_SUPPORT_OBJECT = 1_001_001;
    case ARRAY_IS_NOT_LIST = 1_001_002;

    public function errMsg(): string {
        return match($this) {
            PoErrorCode::NOT_SUPPORT_OBJECT => 'not support object',
            PoErrorCode::ARRAY_IS_NOT_LIST => 'array is not list',
        };
    }
}
