#include <stdio.h>
#include <stdint.h>
#include "other.h"


void print_byte_stream(void *ptr, size_t size) {
    unsigned char *byte_ptr = (unsigned char *)ptr;
    printf("Byte: ");
    for (size_t i = 0; i < size; ++i) {
        printf(" %02x", byte_ptr[i]);
    }
    printf("\n");
}


// int main() {
//     PLDBValue s = {
//         .tag = 0x16,
//         .v = {
//             .int_value = 18,
//         },
//     };
// 
//     // 打印结构体的字节流
//     print_byte_stream(&s, sizeof(s));
// 
//     return 0;
// }
