# Danh sách công việc: Nâng cấp Trang chủ (STT 6)

- [x] **Task 1: Chuẩn bị dữ liệu Backend cho Trang chủ**
  - [x] Truy vấn danh sách sản phẩm mới nhất (`hicrm_products`) kèm giá, giảm giá, ảnh, đơn vị
  - [x] Truyền dữ liệu vào `$this->view->data['new_products']` trong `indexController.php`
  - [x] *(Đã lược bỏ truy vấn danh mục sản phẩm theo yêu cầu)*

- [x] **Task 2: Tinh giản giao diện dưới Banner**
  - [x] Lược bỏ khối Section "Danh mục sản phẩm" theo yêu cầu để giao diện gọn gàng, liền mạch
  - [x] Đưa khối Slider "Sản phẩm mới nhất" lên ngay dưới banner chính

- [x] **Task 3: Xây dựng Slider Sản phẩm mới (Autoplay & Manual Navigation)**
  - [x] Tạo khung chứa Slider sản phẩm mới `#homeNewProductsSlider`
  - [x] Cấu hình Slick Carousel: Autoplay 4s, pause on hover, vuốt cảm ứng trên Mobile
  - [x] Thêm nút điều hướng Next / Prev và Dots chỉ thị đẹp mắt, hiện đại

- [x] **Task 4: Hoàn thiện Card Sản phẩm & Tích hợp Thêm giỏ hàng nhanh**
  - [x] Thiết kế thẻ sản phẩm chuẩn UI y tế (ảnh, tên, quy cách, nhãn New/Sale)
  - [x] Phân loại thuốc kê đơn (ẩn giá, hiển thị Tư vấn/Liên hệ) vs không kê đơn (hiển thị giá)
  - [x] Gắn class `js-add-to-cart` để hỗ trợ mua nhanh, hiển thị SweetAlert toast góc phải dưới màn hình

- [x] **Checkpoint nghiệm thu**
  - [x] Kiểm tra responsive trên Desktop, Tablet và Mobile
  - [x] Kiểm tra hoạt động slider tự động và chuyển thủ công
  - [x] Kiểm tra cú pháp PHP (No syntax errors)

---

# Danh sách công việc: Tối ưu hóa đặt thuốc trên Mobile (Mobile-First Pharmacy)

- [x] **Task 1: Sticky Bottom Bar trên trang Chi tiết sản phẩm (`product_detail.php`)**
  - [x] Thiết kế thanh hành động dính đáy màn hình điện thoại (Zalo Tư vấn + Thêm giỏ + Mua ngay)
  - [x] Tự động chuyển đổi thành nút "Cần đơn thuốc - Gửi đơn Dược sĩ" khi thuốc kê đơn (giá <= 0)
  - [x] Bổ sung bộ chọn số lượng (+ / -) to bản, dễ bấm bằng ngón tay
  - [x] Thêm nút "Mua ngay" (`js-quick-buy`) giúp thêm giỏ và chuyển thẳng đến trang thanh toán trong 1 chạm
  - [x] Cập nhật `cart_preview.php` đọc số lượng tùy chỉnh từ nút bấm

- [x] **Task 2: Bộ lọc danh mục dạng trượt ngang trên Mobile (`products.php`)**
  - [x] Xây dựng thanh danh mục thuốc trượt ngang (Horizontal Scrolling Chips/Pills)
  - [x] Hiển thị trạng thái active nổi bật cho danh mục đang chọn
  - [x] Tinh giản thẻ thuốc trên mobile: Ẩn nút "Xem giỏ" trùng lặp trên từng thẻ nhỏ để tối ưu chiều cao hiển thị

- [x] **Task 3: Gia cố thanh đặt hàng cố định tại trang Giỏ hàng (`cart.php`)**
  - [x] Thêm an toàn cho thanh cố định đáy: `padding-bottom: max(10px, env(safe-area-inset-bottom))` chống che cử chỉ iPhone
  - [x] Thêm `touch-action: manipulation` và hiệu ứng active tap mượt mà cho nút đặt hàng

- [x] **Task 4: Kiểm thử cú pháp toàn diện**
  - [x] Kiểm tra lỗi PHP trên tất cả các file đã chỉnh sửa (`product_detail.php`, `products.php`, `cart.php`, `cart_preview.php`)

---

# Danh sách công việc: Xây dựng Trang Cảm Ơn (STT 10)

- [x] **Task 1: Xử lý Backend & Session Đơn hàng**
  - [x] Lưu `last_order_id` và `order_token` vào Session khi đặt hàng trong `apiController.php::cartCheckout`
  - [x] Viết action `thankyou()` trong `controller/pageController.php` để lấy chi tiết đơn từ `booking_internal`
  - [x] Truy vấn số dư điểm thưởng `loyalty_points` và phân loại đơn hàng (Thanh toán Online vs COD/Tại quầy)
  - [x] Đăng ký route đẹp `/page/thankyou`, `/dat-hang-thanh-cong.html`, `/cam-on.html` trong `application/router.class.php`

- [x] **Task 2: Thiết kế Giao diện Trang Cảm Ơn / Xác nhận đơn hàng (`template/page/thankyou.php`)**
  - [x] Tinh chỉnh phong cách chuẩn UI Y tế thực tế, loại bỏ triệt để các hiệu ứng dạng AI slop (loại bỏ gradient 3 màu sặc sỡ, bỏ animation giật nảy, bỏ thẻ bo tròn 999px quá đà, bỏ đổ bóng dày).
  - [x] Thanh trạng thái (Status bar): Gọn gàng, trang nhã với viền xanh lá chuẩn xác nhận, mã đơn `#DH0000x`, lời dặn dò ngắn gọn.
  - [x] Bảng đơn thuốc chi tiết (Order Receipt): Bố cục rõ ràng, bảng thuốc thẳng hàng, tóm tắt chi phí (Tạm tính, Giảm giá voucher, Trừ điểm, Tổng thanh toán) dễ kiểm tra.
  - [x] Khối điểm tích lũy (khi thanh toán online): Banner thông báo xanh nhã nhặn, hiển thị điểm tích từ đơn này (`+X điểm`) và tổng điểm tích lũy hiện có.
  - [x] Cột thông tin Nhà thuốc: Địa chỉ cơ sở, Giờ mở cửa, Hotline Dược sĩ và nút Zalo Dược sĩ tiện lợi.
  - [x] Nút điều hướng phẳng, bo góc 6px chuyên nghiệp: "Tiếp tục mua thuốc", "Về trang chủ", link "Xem lịch sử đơn".

- [x] **Task 3: Kết nối chuyển hướng từ Giỏ hàng (`cart.php`)**
  - [x] Cập nhật JavaScript xử lý đặt hàng: Hiển thị SweetAlert toast thành công và tự động chuyển hướng sang `/dat-hang-thanh-cong.html?id=` sau 800ms

- [x] **Task 4: Kiểm thử & Nghiệm thu**
  - [x] Kiểm tra bảo mật Session / User ID tránh lộ thông tin đơn hàng người khác
  - [x] Kiểm tra phân loại thanh toán online vs offline
  - [x] Tối ưu CSS Responsive 100% cho điện thoại di động, máy tính bảng và máy tính
  - [x] Kiểm tra cú pháp PHP toàn bộ các file liên quan (không có lỗi cú pháp)


---

# Danh sách công việc: Kiểm tra & Tối ưu Đăng ký tài khoản (STT 9)

- [x] **Task 1: Kiểm tra Route & Điều hướng đăng ký**
  - [x] Phát hiện thiếu route `/dang-ky.html`, `/dang-ky`, `/register` dẫn tới màn hình trắng 404 khi người dùng bấm "Đăng ký tài khoản" từ Popup modal hoặc trang Đăng nhập.
  - [x] Đã cấu hình bổ sung các route trên vào `application/router.class.php` điều hướng về `memberController::register()`.
  - [x] Xóa bỏ UTF-8 BOM ở đầu file `router.class.php`, `apiController.php`, `pageController.php` để ngăn lỗi gửi header sớm (`headers already sent`).

- [x] **Task 2: Kiểm tra Quy trình Xác thực & API Đăng ký (`apiController::register`)**
  - [x] Kiểm tra CSRF token bảo vệ form đăng ký.
  - [x] Kiểm tra validation: Họ tên (>=2 ký tự), SĐT Việt Nam hợp lệ (10 chữ số đầu 03, 05, 07, 08, 09), Email hợp lệ, Mật khẩu (>= 6 ký tự).
  - [x] Khắc phục điều kiện xác nhận mật khẩu (bắt buộc nhập và phải khớp với mật khẩu).
  - [x] Kiểm tra chống trùng lặp SĐT và Email trong bảng `hicrm_users`.
  - [x] Khởi tạo tài khoản với phân quyền khách hàng (`user_group = 0`, `user_status = 1`, `loyalty_points = 0`).
  - [x] Tự động đăng nhập vào session `$_SESSION['customer']` và thông báo SweetAlert toast `bottom-end`.

- [x] **Task 3: Kiểm tra Quyền Truy cập Hồ sơ Khách hàng (`customerprofile`)**
  - [x] Khắc phục ràng buộc cứng `empty($_SESSION['customer']['zalo'])` trong `pageController::customerprofile()` khiến khách hàng đăng ký thông thường hoặc qua Google/Facebook bị đẩy ngược về trang đăng nhập.
  - [x] Bổ sung truy vấn và hiển thị Điểm tích lũy (`loyalty_points`) ngay trên trang Hồ sơ cá nhân (`customer-profile.php`).

- [x] **Task 4: Kiểm thử Toàn diện**
  - [x] Kiểm thử luồng tạo tài khoản và tự động đăng nhập.
  - [x] Kiểm thử truy cập các URL: `/dang-ky.html`, `/dang-ky`, `/dang-nhap.html`.
  - [x] Kiểm tra PHP lint (No syntax errors).
