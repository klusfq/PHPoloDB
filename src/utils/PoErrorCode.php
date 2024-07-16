<?php

namespace Pholur\Utils;

enum PoErrorCode: int
{
    case NOT_SUPPORT_TYPE = 1_001_000;
    case NOT_SUPPORT_OBJECT = 1_001_001;
    case ARRAY_IS_NOT_LIST = 1_001_002;
    case INSERT_FAILED = 1_001_003;
    case FIND_FAILED = 1_001_004;

    public function errMsg(): string {
        return match($this) {
            PoErrorCode::NOT_SUPPORT_TYPE => 'not support this type',
            PoErrorCode::NOT_SUPPORT_OBJECT => 'not support object',
            PoErrorCode::ARRAY_IS_NOT_LIST => 'array is not list',
            PoErrorCode::INSERT_FAILED => 'insert failed',
            PoErrorCode::FIND_FAILED => 'find failed',
        };
    }
}
