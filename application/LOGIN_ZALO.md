# Đăng nhập khách hàng bằng Zalo

Core kết nối API: `application/login_zalo.class.php`. API xử lý database: `apiController::zalologin`.

## Cấu hình trong database
Đăng nhập quản trị viên (user_group = 1), mở `/admin/zalosetting` hoặc Thiết lập → Đăng nhập Zalo.
Nhập App ID, App Secret và Callback URL HTTPS rồi lưu. API lưu vào hicrm_configs với các khóa:
- `zalo_app_id`: App ID.
- `zalo_app_secret`: App Secret (không trả về giao diện).
- `zalo_callback_url`: Callback URL, ví dụ `https://phongkhamcdkontum.com.vn/page/zalocallback`.

Không thêm cột vì bảng dùng config_key/config_value. Trang cấu hình tự tạo dòng còn thiếu khi lưu. File `zalo_config_migration.sql` cũng có thể dùng để khởi tạo ba dòng rỗng; không ghi đè cấu hình đã có. Không cần SetEnv ZALO_APP_ID/ZALO_APP_SECRET/ZALO_CALLBACK_URL hoặc ZALO_USER_MAP nữa.

Để trống Secret khi lưu giữ khóa cũ; lần đầu hoặc đổi App ID phải nhập Secret. Chỉ quản trị viên còn hoạt động được lưu, có kiểm tra CSRF. Secret lưu trong database nên chỉ cấp quyền đọc bảng cho máy chủ và người quản trị cần thiết.

Callback phải khớp Zalo Developers. Website dùng cùng domain HTTPS để giữ session. PHP cần cURL, mysqli/mysqlnd, mbstring và CA certificates hợp lệ. App ID/Secret chỉ đọc phía máy chủ.

## Database
Chạy `zalo_customer_migration.sql` trên database website trước khi dùng. Migration kiểm tra trước khi thêm `user_zalo_id VARCHAR(64) NULL` và UNIQUE index. Không tạo table mới, không đổi dữ liệu user hiện có. Nếu Zalo ID đã có dữ liệu trùng, cần xử lý riêng trước khi thêm UNIQUE; không tự xóa tài khoản. Database local hiện chưa kết nối được nên migration chưa được áp dụng.

Luồng: lấy hồ sơ Zalo -> tìm theo Zalo ID -> chưa có thì INSERT vào hicrm_users -> đã có thì giữ ID, số điện thoại và điểm -> cập nhật tên/ảnh hồ sơ. UNIQUE index chống insert trùng khi nhiều request đồng thời. Tài khoản khóa không được đăng nhập.

User khách hàng có group 0 (không phải nhóm nhân viên). Mật khẩu là hash ngẫu nhiên không được cung cấp; Zalo là cách đăng nhập của tài khoản này. Không giả định có email hoặc số điện thoại từ Social API.

Session khách hàng là `customer`, không sử dụng `user`, `staff` hoặc `LoggedIn` của quản trị. Trang /admin/login chỉ đăng nhập nhân viên bằng mật khẩu. Tài khoản Zalo không được tự ghép với tài khoản nhân viên hay tài khoản cũ theo tên/số điện thoại.

Sau đăng nhập, thiếu số điện thoại di động hợp lệ sẽ chuyển tới `/page/customerprofile`. Frontend và server validate, kiểm tra trùng số với tài khoản đang hoạt động. Số nhập vào chưa xác minh OTP, không dùng số đó để tự gộp tài khoản hoặc khôi phục tài khoản.

Giỏ hàng nhận ID khách hàng trong `customer`, điền thông tin và dùng cơ chế điểm có sẵn. API đặt hàng từ chối khách hàng Zalo chưa bổ sung số điện thoại. Các bảng/cột giỏ hàng và điểm trong `cart_voucher_points.sql` phải đã được triển khai theo luồng mua hàng hiện tại; không tự chạy file đó trong tác vụ này.

## Kiểm thử
- Zalo mới tạo đúng một tài khoản; đăng nhập lại giữ ID, số điện thoại, điểm.
- Callback sai state/hết hạn/tái sử dụng bị từ chối.
- Thiếu cột/UNIQUE index báo lỗi cấu hình thân thiện, không tự chạy DDL trong API.
- Khách hàng không có session quản trị; không vào được trang yêu cầu user/staff.
- Số điện thoại thiếu/sai/trùng và CSRF sai bị từ chối; số đúng cho tiếp tục giỏ hàng.
- Khách chưa cập nhật số không thể vượt kiểm tra bằng cách gọi API đặt hàng trực tiếp.
- Kiểm thử tích hợp thực cần database hoạt động, App ID/Secret và HTTPS callback.

Tài liệu OAuth: https://docs.zaloplatforms.com/docs/Social/social-api/tham-khao/user-access-token-v4
