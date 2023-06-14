// 测试std::ptr::write()函数的使用
fn main() {
    let mut opr = vec![1, 2];
    let opx = &mut opr as *mut Vec<i32>;

    let ipz = vec![3, 4];

    println!("{:p} - {:?}", opx, opr);

    unsafe {
        // std::ptr::write(opx, ipz);
        opx.write(ipz);
    }

    println!("{:p} - {:?}", opx, opr);
}
