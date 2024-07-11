#define FFI_SCOPE "PHPOLODB"

#define FFI_LIB "/home/klus/app/PoloDB/target/debug/libpolodb_clib.so"

struct Database;
struct DbHandle;
struct DbDocument;
struct DbDocumentIter;
struct DbArray;
struct DbObjectId;

typedef struct DbDocument DbDocument;
typedef struct DbDocumentIter DbDocumentIter;
typedef struct DbArray DbArray;
typedef struct Database Database;
typedef struct DbHandle DbHandle;
typedef struct DbObjectId DbObjectId;

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
    // PLDB_VALUE_TYPE tag: 8;
    uint8_t tag;
    union {
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

Database* PLDB_open(const char* path);

int PLDB_error_code();

int PLDB_start_transaction(Database*db, int flags);

int PLDB_commit(Database* db);

int PLDB_rollback(Database* db);

int PLDB_create_collection(Database* db, const char* name, uint32_t* col_id, uint32_t* meta_verison);

int PLDB_get_collection_meta_by_name(Database* db, const char* name, uint32_t* id, uint32_t* version);

int64_t PLDB_count(Database* db, uint32_t col_id, uint32_t meta_version);

int PLDB_insert(Database* db, uint32_t col_id, uint32_t meta_version, DbDocument* doc);

int PLDB_find(Database* db, uint32_t col_id, uint32_t meta_version, const DbDocument* query, DbHandle** out_handle);

int64_t PLDB_update(Database* db, uint32_t col_id, uint32_t meta_version, const DbDocument* query, const DbDocument* update);

int64_t PLDB_delete(Database* db, uint32_t col_id, uint32_t meta_version, const DbDocument* query);

int64_t PLDB_delete_all(Database* db, uint32_t col_id, uint32_t meta_version);

int PLDB_drop(Database* db, uint32_t col_id, uint32_t meta_version);

const char* PLDB_error_msg();

int PLDB_version(char* buffer, unsigned int buffer_size);

void PLDB_close(Database* db);

// int PLDB_step(DbHandle* handle);

// int PLDB_handle_state(DbHandle* handle);

// void PLDB_handle_get(DbHandle* handle, PLDBValue* out_val);
// 
// int PLDB_handle_to_str(DbHandle* handle, char* buffer, unsigned int buffer_size);
// 
// void PLDB_close_and_free_handle(DbHandle* handle);
// 
// void PLDB_free_handle(DbHandle* handle);

// DbArray* PLDB_mk_arr();
// 
// DbArray* PLDB_mk_arr_with_size(unsigned int size);
// 
// void PLDB_free_arr(DbArray* arr);
// 
// unsigned int PLDB_arr_len(DbArray* arr);
// 
// void PLDB_arr_push(DbArray* arr, PLDBValue value);
// 
// int PLDB_arr_set(DbArray* doc, uint32_t index, PLDBValue val);
// 
// int PLDB_arr_get(DbArray* arr, unsigned int index, PLDBValue* out_val);

DbDocument* PLDB_mk_doc();

void PLDB_free_doc(DbDocument* doc);

int PLDB_doc_set(DbDocument* doc, const char* key, PLDBValue val);

int PLDB_doc_get(DbDocument* doc, const char* key, PLDBValue* out_val);

int PLDB_doc_len(DbDocument* doc);
// 
// DbDocumentIter* PLDB_doc_iter(DbDocument* doc);
// 
// int PLDB_doc_iter_next(DbDocumentIter* iter,
//   char* key_buffer, unsigned int key_buffer_size, PLDBValue* out_val);
// 
// void PLDB_free_doc_iter(DbDocumentIter* iter);
// 
// 
// PLDBValue PLDB_mk_binary_value(const char* bytes, uint32_t size);
// PLDBValue PLDB_dup_value(PLDBValue val);
// void PLDB_free_value(PLDBValue val);
// 
// DbObjectId* PLDB_mk_object_id(Database* db);
// 
// DbObjectId* PLDB_dup_object_id(const DbObjectId* that);
// 
// DbObjectId* PLDB_mk_object_id_from_bytes(const char* bytes);
// 
// void PLDB_object_id_to_bytes(const DbObjectId* oid, char* bytes);
// 
// void PLDB_free_object_id(DbObjectId*);
// 
// int PLDB_object_id_to_hex(const DbObjectId* oid, char* buffer, unsigned int size);
// 
// uint64_t  PLDB_mk_UTCDateTime();
