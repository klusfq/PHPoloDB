<?php

namespace Pholur\Utils;

use FFI\CData;
use FFI\Scalar\Type as Ftype;

class Type
{
    public static function trans2Cdata(mixed $val): CData | Throwable {
        switch (gettype($val)) {
            case 'boolean':
                return Ftype::bool($val);
            case 'integer':
                return Ftype::int32($val);
            case 'double':
                return Ftype::double($val);
            case 'string':
                return Ftype::string($val);
            case 'array':
                if (!Type::isListArray($val))
                    throw new PoError(PoErrorCode::ARRAY_IS_NOT_LIST);

                return Type::transArray($val);

            // TODO: object
            default:
                throw new PoError(PoErrorCode::NOT_SUPPORT_OBJECT);
        }
    }

    public static function isListArray(array $val): bool {
        return array_keys($val) === range(0, count($val) - 1);
    }

    private static function transArray(array $val): CData {
        switch (gettype($val[0])) {
            case 'boolean':
                return Ftype::boolArray($val);
            case 'integer':
                return Ftype::int32Array($val);
            case 'double':
                return Ftype::doubleArray($val);
            case 'string':
                return Ftype::stringArray($val);
            default:
                throw new PoError(PoErrorCode::NOT_SUPPORT_OBJECT);
        }
    }
}
