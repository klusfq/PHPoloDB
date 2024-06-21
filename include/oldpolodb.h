#define FFI_SCOPE "PHPOLODB"

#if defined(__linux__)
    #define FFI_LIB "../target/debug/libpolodb_clib.so"
#elif defined(__APPLE__)
    #define FFI_LIB "../target/debug/libpolodb_clib.dylib"
#elif defined(_WIN32)
    #define FFI_LIB "../target/debug/libpolodb_clib.dll"
#endif


struct Database;
struct DbHandle;
struct Document;
struct DocumentIter;
struct Array;
struct ObjectId;

typedef struct Document* DbDocument;
typedef struct DocumentIter* DbDocumentIter;
typedef struct Array DbArray;
typedef struct Database Database;
typedef struct DbHandle DbHandle;
typedef struct ObjectId DbObjectId;

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
    union tv {
        int64_t     int_value;
        double      double_value;
        int         bool_value;
        const char* str;
        DbObjectId* oid;
        DbArray*    arr;
        DbDocument* doc;
        uint64_t    utc;
    } v;
} PLDBValue;

// Database {
Database* PLDB_open(const char* path);

int PLDB_error_code();

int PLDB_start_transaction(Database*db, int flags);

int PLDB_commit(Database* db);

int PLDB_rollback(Database* db);

int PLDB_create_collection(Database* db, const char* name, uint32_t* col_id, uint32_t* meta_verison);

int PLDB_get_collection_meta_by_name(Database* db, const char* name, uint32_t* id, uint32_t* version);

int64_t PLDB_count(Database* db, uint32_t col_id, uint32_t meta_version);

int PLDB_insert(Database* db, uint32_t col_id, uint32_t meta_version, DbDocument* doc);

// <query> is nullable
int PLDB_find(Database* db, uint32_t col_id, uint32_t meta_version, const DbDocument* query, DbHandle** out_handle);

// <query> is nullable
int64_t PLDB_update(Database* db, uint32_t col_id, uint32_t meta_version, const DbDocument* query, const DbDocument* update);

int64_t PLDB_delete(Database* db, uint32_t col_id, uint32_t meta_version, const DbDocument* query);

int64_t PLDB_delete_all(Database* db, uint32_t col_id, uint32_t meta_version);

int PLDB_drop(Database* db, uint32_t col_id, uint32_t meta_version);

const char* PLDB_error_msg();

int PLDB_version(char* buffer, unsigned int buffer_size);

void PLDB_close(Database* db);
// }

// DbDocument {
DbDocument* PLDB_mk_doc();

void PLDB_free_doc(DbDocument* doc);

int PLDB_doc_set(DbDocument* doc, const char* key, const PLDBValue* val);

int PLDB_doc_get(DbDocument* doc, const char* key, PLDBValue* out_val);

// }
