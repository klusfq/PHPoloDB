#define FFI_SCOPE "CPBY"

#define FFI_LIB "/home/klus/app/PHPoloDB/script/cpby/libother.so"

typedef enum PLDB_VALUE_TYPE {
  PLDB_VAL_NULL = 0x0A,
  PLDB_VAL_DOUBL = 0x01,
  PLDB_VAL_BOOLEAN = 0x08,
  PLDB_VAL_INT = 0x16,
  PLDB_VAL_STRING = 0x02,
  PLDB_VAL_OBJECT_ID = 0x07,
  PLDB_VAL_ARRAY = 0x17,
  PLDB_VAL_DOCUMENT = 0x13,
  PLDB_VAL_BINARY = 0x05,
  PLDB_VAL_UTC_DATETIME = 0x09,
} PLDB_VALUE_TYPE;

typedef struct PLDBValue {
    PLDB_VALUE_TYPE tag: 8;
    union {
        int64_t     int_value;
        double      double_value;
        int         bool_value;
        const char* str;
        uint64_t    utc;
    } v;
} PLDBValue;


void print_byte_stream(void *ptr, size_t size);
