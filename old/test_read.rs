/**
 * 从tmp库中读取数据
 */
extern crate polodb_core;
extern crate polodb_bson;

// use std::rc::Rc;
use polodb_core::Database;
// use polodb_bson::doc;

fn main() {
    let mut db = Database::open_file("./tmp.db").unwrap();
    let mut col = db.collection("study").unwrap();

    let result = col.find_all().unwrap();
    println!("{:?}", result);

    // col.insert(doc! {
    //     "_id": 0,
    //     "name": "Vincent Chan",
    //     "score": 99.99,
    // }.as_mut()).unwrap();
}
