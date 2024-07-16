<?php

namespace Pholur\Internal;

use Pholur\Utils\{Loger, PoError, PoErrorCode};
use FFI\Scalar\Type as Ftype;
use \FFI\CData;

class LibValue
{
    protected static array $TypeTagMap = [
        'null' => 0x0A,
        'boolean' => 0x08,
        'double' => 0x01,
        'integer' => 0x16,
        'string' => 0x02,
        'Document' => 0x13,

        // -- TODO: wait
        'ObjectId' => 0x07,
        'Array' => 0x17,
        'Binary' => 0x05,
        'UTCTime' => 0x09,
    ];

    protected ?CData $data = null;

    protected mixed $other = null;

    public function __construct(?CData $data = null) {
        if (is_null($data)) {
            $this->data = Env::GetFFI()->new('PLDBValue');
        } else {
            $this->data = $data;
        }
    }

    /**
     * 获取内部data值
     */
    public function inner(): ?CData {
        return $this->data;
    }

    /**
     * 获取内部Document值
     */
    public function innerDocument(): ?CData {
        return $this->data->v->doc;
    }

    /**
     * 当前Value是否为DbDocument
     */
    public function isDocument(): bool {
        return $this->data->tag == self::getTag('Document');
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

        $valObj->data->tag = Ftype::uint8(self::getTag($tp))->cdata;

        return $valObj;
    }

    public static function fromCData(CData $data): LibValue {
        $valObj = new LibValue($data);

        return $valObj;
    }

    /**
     * LibValue -> mixed<boolean, integer, double, string>
     */
    public function into(): mixed {
        var_dump($this->data);

        switch($this->data->tag) {
            case self::getTag('null'):
                return null;
            case self::getTag('boolean'):
                return (bool)$this->data->v->bool_value;
            case self::getTag('double'):
                return $this->data->v->double_value;
            case self::getTag('integer'):
                return $this->data->v->int_value;
            case self::getTag('string'):
                return \FFI::string($this->data->v->str);
            case self::getTag('Document'):
                return LibDocument::iterData($this);
            case self::getTag('UTCTime'):
                return $this->data->v->utc;

                // TODO
            case self::getTag('ObjectId'):
                return 'this is object id';
            case self::getTag('Binary'):
                return 'this is binary';
            case self::getTag('Array'):
                return 'this is array';
            default:
                throw new PoError(PoErrorCode::NOT_SUPPORT_TYPE, [
                    'tag is' => $this->data->tag,
                ]);
        }
    }

    protected static function getTag(string $type): int {
        return self::$TypeTagMap[$type] ?? self::$TypeTagMap['null'];
    }

    protected static function getTagName(int $typeVal): string {
        return array_search($typeVal, self::$TypeTagMap);
    }
}
