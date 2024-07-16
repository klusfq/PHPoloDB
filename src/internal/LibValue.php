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
        'LibValue' => 0x13,
        'Binary' => 0x05,
        'UTCTime' => 0x09,
    ];

    protected ?CData $data = null;

    protected mixed $other = null;

    public function __construct(mixed $origin) {
        $this->data = Env::GetFFI()->new('PLDBValue');

        $this->from($origin);
    }

    public function inner() {
        return $this->data;
    }

    protected function from(mixed $origin): void {
        $tp = gettype($origin);
        switch ($tp) {
            case 'boolean':
                $this->data->v->bool_value = Ftype::int((int)$origin);
                break;
            case 'integer':
                $this->data->v->int_value = Ftype::int64($origin);
                break;
            case 'double':
                $this->data->v->double_value = Ftype::double($origin);
                break;
            case 'string':
                $this->other = Ftype::string($origin);
                $this->data->v->str = \FFI::addr($this->other[0]);
                break;

            // TODO
            default:
                throw new PoError(PoErrorCode::NOT_SUPPORT_OBJECT);
        }

        $this->data->tag = Ftype::uint8($this->tag($tp))->cdata;
    }

    protected function tag(string $type): int {
        return self::$TypeTagMap[$type] ?? self::$TypeTagMap['null'];
    }
}
