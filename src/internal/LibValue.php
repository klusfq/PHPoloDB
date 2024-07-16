<?php

namespace Pholur\Internal;

use Pholur\Utils\{Loger, PoError, PoErrorCode};
use FFI\Scalar\Type as Ftype;
use \FFI\CData;

class LibValue
{
    protected static array $TypeTagMap = [
        'null' => 0x0A,
        'double' => 0x01,
        'boolean' => 0x08,
        'integer' => 0x16,
        'string' => 0x02,
        'array' => 0x17,

        // -- TODO: wait
        'ObjectId' => 0x07,
        'Document' => 0x13,
        'Binary' => 0x05,
        'UTCTime' => 0x09,
    ];

    protected ?CData $data = null;

    protected mixed $other = null;

    public function __construct() {
        $this->data = Env::GetFFI()->new('PLDBValue');
    }

    public function inner() {
        return $this->data;
    }

    public static function from(mixed $origin): LibValue {
        $valObj = new LibValue();

        $tp = gettype($origin);
        switch ($tp) {
            case 'boolean':
                $valObj->data->v->bool_value = Ftype::int((int)$origin);
                break;
            case 'integer':
                $valObj->data->v->int_value = Ftype::int64($origin);
                break;
            case 'double':
                $valObj->data->v->double_value = Ftype::double($origin);
                break;
            case 'string':
                $valObj->other = Ftype::string($origin);
                $valObj->data->v->str = \FFI::addr($valObj->other[0]);
                break;

            // TODO
            default:
                throw new PoError(PoErrorCode::NOT_SUPPORT_OBJECT);
        }

        $valObj->data->tag = Ftype::uint8($valObj->tag($tp))->cdata;

        return $valObj;
    }

    public static function fromCData(CData $data): LibValue {
        $valObj = new LibValue();
        $valObj->data = $data;

        return $valObj;
    }

    protected function tag(string $type): int {
        return self::$TypeTagMap[$type] ?? self::$TypeTagMap['null'];
    }
}
