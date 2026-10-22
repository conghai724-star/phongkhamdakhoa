** QUY ƯỚC
Trước khi thực hiện code chức năng nào cần:
- Đọc lại luồng code và thực hiện code theo.
- Không code lan man; không tạo quá nhiều function. Không bị lỗi font chữ.
- Khởi tạo database cần thiết; chính xác và có ghi chú rõ ràng.
## Giao diện

- Thiết kế responsive cho điện thoại, máy tính bảng và máy tính; ưu tiên luồng thao tác rõ ràng, ít bước và dễ sử dụng.
- Form phải kiểm tra dữ liệu cả phía trình duyệt lẫn máy chủ: trường bắt buộc, định dạng, miền giá trị và dữ liệu tham chiếu trước khi lưu.
- Sau mọi tác vụ (thêm, sửa, xóa, import, gọi API), hiển thị thông báo nhỏ, dễ đọc ở góc phải phía dưới màn hình về thành công hoặc thất bại. Dùng SweetAlert (`Swal.fire`) theo dạng toast với vị trí `bottom-end`; không sử dụng hộp thoại `alert()` cho thông báo nghiệp vụ thông thường.
- Thông báo lỗi phải nêu nguyên nhân có thể xử lý; không trả về lỗi kỹ thuật hoặc thông tin nhạy cảm cho người dùng.

## Luồng frontend và backend

- Điều hướng trang, lấy dữ liệu hiển thị ban đầu và xử lý logic trang admin đặt tại `adminController`.
- Điều hướng trang, lấy dữ liệu hiển thị ban đầu và xử lý logic trang giao diện người dùng đặt tại `pageController`.
- Toàn bộ frontend quản trị chỉ được khởi tạo và chỉnh sửa trong thư mục `template/page/backend`; không tạo hoặc sửa giao diện quản trị tại thư mục template khác.
- Mỗi action hiển thị trang quản trị tại `adminController` gọi `$this->view->show("backend/ten-file");`.
- Tác vụ thay đổi dữ liệu từ frontend sử dụng AJAX bằng jQuery gửi đến `apiController`; API phản hồi JSON nhất quán, tối thiểu gồm `success`, `message` và `data` khi cần.
- Frontend chịu trách nhiệm hiển thị, bắt sự kiện và khai báo jQuery AJAX; `apiController` chịu trách nhiệm xác thực, query database và xử lý nghiệp vụ rồi trả kết quả JSON cho frontend.
- API phải xác thực yêu cầu, kiểm tra CSRF/quyền truy cập theo cơ chế hiện có, validate lại toàn bộ dữ liệu ở máy chủ và chỉ trả về dữ liệu cần thiết.
- Frontend cập nhật bảng/danh sách sau phản hồi AJAX, đồng thời dùng SweetAlert (`Swal.fire`) để hiển thị thông báo thành công/thất bại; không dùng `alert()` cho thông báo nghiệp vụ.
- Ưu tiên code sạch, trực tiếp và dễ đọc; chỉ tách hàm khi có trách nhiệm rõ ràng, tránh gọi hoặc tạo quá nhiều hàm làm rối luồng xử lý.

## Dữ liệu và tích hợp

- Được phép truy cập ở chế độ đọc để xem cấu trúc và dữ liệu các bảng trong database `care_ioc` tại phpMyAdmin: `http://localhost/phpmyadmin/index.php?route=/database/structure&server=1&db=phongkha697b_phongkhamcdkontum`.
- Không tự ý tạo thêm table trong database. Khi thấy cần table mới, phải trình bày rõ mục đích, tên table và danh sách đầy đủ các cột (tên cột, kiểu dữ liệu, ràng buộc/khóa và ý nghĩa) để người dùng xem xét.
- Chỉ được thực hiện lệnh tạo table sau khi người dùng cho phép rõ ràng. Việc được phép đọc database không đồng nghĩa với quyền thay đổi cấu trúc hoặc dữ liệu.
