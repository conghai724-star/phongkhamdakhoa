# Kế hoạch triển khai: Nâng cấp Trang chủ (STT 6 - congviec.txt)

## 1. Tổng quan (Overview)
- **Hạng mục**: STT 6 trong [congviec.txt](file:///d:/xampp/htdocs/phongkhamcdkontum.com.vn/congviec.txt) - Giao cho Hải (Mức độ ưu tiên: Cao).
- **Yêu cầu cốt lõi**:
  1. Bổ sung cụm **Danh mục sản phẩm** nổi bật tại trang chủ, đặt ngay phía dưới khu vực banner đơn vị.
  2. Hiển thị danh sách **Sản phẩm mới** (thuốc, dược mỹ phẩm, thiết bị y tế gia đình...).
  3. Xây dựng khối **Slider sản phẩm mới** cho phép chuyển tự động (autoplay) và thủ công (next/prev, dots, swipe) mượt mà trên mọi thiết bị.
  4. Tuân thủ nghiêm ngặt quy định y tế: Thuốc kê đơn không hiển thị giá (hiển thị "Liên hệ / Tư vấn dược sĩ"), thuốc không kê đơn có giá rõ ràng và nút "Thêm vào giỏ" tích hợp AJAX giỏ hàng.

---

## 2. Quyết định kiến trúc & Kỹ thuật (Architecture Decisions)
1. **Tuân thủ AGENTS.md**:
   - Không can thiệp file core (`config.php`, `index.php`, thư mục `application/`).
   - Lấy dữ liệu sản phẩm và danh mục trang chủ tại `controller/indexController.php` (chuẩn bị dữ liệu hiển thị ban đầu).
   - Giao diện đặt tại `template/page/index.php`.
   - Các tương tác dữ liệu (như thêm giỏ hàng) sử dụng AJAX jQuery tới `apiController.php` và hiển thị SweetAlert toast (`position: 'bottom-end'`).
2. **Tận dụng thư viện hiện có (Ponytail principle)**:
   - Sử dụng thư viện **Slick Carousel** đã được nạp sẵn trong `footer_new.php` và phong cách icon FontAwesome 6 có sẵn.
   - Không cài thêm bất kỳ thư viện JS/CSS nặng nề nào khác.
3. **Phối hợp dữ liệu Database**:
   - Danh mục: Lấy từ bảng `hicrm_product_categories` (lọc trạng thái `category_status NOT IN (99)`).
   - Sản phẩm mới: Lấy từ bảng `hicrm_products` kết hợp `hicrm_units` và `hicrm_product_categories` (sắp xếp `product_created_time DESC` hoặc `id DESC`, trạng thái `product_status NOT IN (99)`).

---

## 3. Danh sách công việc chi tiết (Tasks Breakdown)

### Task 1: Chuẩn bị dữ liệu Backend cho Trang chủ
- **Mô tả**: Mở rộng hàm `index()` trong `controller/indexController.php` để truy vấn danh mục sản phẩm nổi bật và danh sách sản phẩm mới nhất (giới hạn 10 - 15 sản phẩm).
- **Tiêu chí chấp nhận (Acceptance Criteria)**:
  - `product_categories`: Lấy id, tên danh mục, icon, ảnh, số lượng sản phẩm (nếu có).
  - `new_products`: Lấy thông tin chi tiết (pid, product_name, product_price, product_discount, product_image, category_name, unit_name, product_type/is_prescription).
  - Không gây lỗi cú pháp, câu query tối ưu indexed, không làm chậm tốc độ tải trang chủ.
- **Xác minh (Verification)**: Chạy thử trang chủ, `var_dump` hoặc in thử dữ liệu trong view thấy đầy đủ danh sách.
- **Files liên quan**: `controller/indexController.php`
- **Khối lượng**: S (1 file, ~25 dòng code)

### Task 2: Thiết kế Section Danh mục sản phẩm dưới Banner
- **Mô tả**: Thêm khối danh mục sản phẩm (Product Categories Grid) vào ngay dưới banner slider trong `template/page/index.php`.
- **Tiêu chí chấp nhận (Acceptance Criteria)**:
  - Hiển thị danh mục dạng icon/thẻ hiện đại (màu sắc hài hòa với tone y tế xanh dương #155191 và cam #e36928).
  - Nhấp vào danh mục sẽ chuyển hướng chính xác đến trang lọc sản phẩm: `/nha-thuoc/category/{id}-{slug}.html`.
  - Responsive: Trên Mobile hiển thị lưới 4 cột (hoặc thanh cuộn ngang mượt mà), trên PC hiển thị 6-8 danh mục tiện lợi.
- **Xác minh (Verification)**: Kiểm tra trực quan trên màn hình PC và Responsive Mobile (< 768px).
- **Files liên quan**: `template/page/index.php`
- **Khối lượng**: S (1 file HTML/CSS)

### Task 3: Xây dựng Slider Sản phẩm mới (Chuyển tự động & Thủ công)
- **Mô tả**: Thiết kế khối "Sản phẩm mới về" với bố cục dạng Slider / Carousel đa sản phẩm.
- **Tiêu chí chấp nhận (Acceptance Criteria)**:
  - Khởi tạo Slick Carousel: `autoplay: true` (khoảng 4 giây/lần), tự dừng khi hover (`pauseOnHover: true`), cho phép vuốt cảm ứng trên điện thoại.
  - Có đầy đủ nút điều hướng thủ công (Nút Prev `<` và Next `>` hai bên) và thanh chấm chỉ báo (Dots).
  - Responsive breakpoints:
    - Desktop rộng (> 1200px): Hiển thị 5 sản phẩm/lượt.
    - Tablet (768px - 1199px): Hiển thị 3 - 4 sản phẩm/lượt.
    - Mobile (< 768px): Hiển thị 2 sản phẩm/lượt (tối ưu hiển thị màn hình dọc).
- **Xác minh (Verification)**: Slider tự chạy sau khi tải trang, ấn nút Next/Prev hoạt động trơn tru không bị giật lag layout.
- **Files liên quan**: `template/page/index.php`
- **Khối lượng**: M (1 file HTML/CSS/JS)

### Task 4: Hoàn thiện Card Sản phẩm & Tích hợp Mua hàng nhanh
- **Mô tả**: Tinh chỉnh thiết kế thẻ sản phẩm (Product Card) trong slider và gắn trigger thêm giỏ hàng.
- **Tiêu chí chấp nhận (Acceptance Criteria)**:
  - Ảnh sản phẩm tỉ lệ vuông chuẩn, nhãn "Mới" (New Badge) và nhãn giảm giá `-X%` (nếu có).
  - Kiểm tra điều kiện thuốc kê đơn: Không hiển thị giá, hiển thị nhãn "Thuốc kê đơn - Liên hệ dược sĩ".
  - Thuốc không kê đơn: Hiển thị giá niêm yết, giá khuyến mãi; Nút "Thêm vào giỏ" kích hoạt class `js-add-to-cart` để gọi AJAX giỏ hàng.
  - Khi thêm thành công: Hiển thị Toast SweetAlert góc phải dưới (`position: 'bottom-end'`), cập nhật số lượng trên giỏ hàng nổi/header ngay lập tức.
- **Xác minh (Verification)**: Nhấn nút "Thêm vào giỏ" trên slider trang chủ, kiểm tra giỏ hàng nhảy số và Toast xuất hiện.
- **Files liên quan**: `template/page/index.php`
- **Khối lượng**: S (1 file)

---

## 4. Điểm chốt kiểm tra (Checkpoints)
- **Checkpoint 1 (Dữ liệu & Cấu trúc)**: Kiểm tra dữ liệu backend đổ về view `index.php` chính xác và không bị lỗi SQL/PHP warning.
- **Checkpoint 2 (Trải nghiệm Slider & Responsive)**: Kiểm tra hiệu năng slider trên cả trình duyệt Chrome PC và Device Mode Mobile (iPhone / Android), đảm bảo không vỡ khung hình banner phía trên.
- **Checkpoint 3 (Hoạt động Giỏ hàng & Tuân thủ quy ước)**: Kiểm tra tính năng thêm giỏ hàng từ trang chủ, thông báo SweetAlert toast chuẩn vị trí, kiểm tra mã nguồn không vi phạm các điều cấm trong `AGENTS.md`.

---

## 5. Rủi ro & Giải pháp (Risks & Mitigations)
| Rủi ro | Mức độ | Biện pháp xử lý |
|---|---|---|
| Xung đột script Slick giữa banner top và slider sản phẩm | Trung bình | Đặt selector riêng biệt (vd: `#homeNewProductsSlider`), khởi tạo sau khi DOM sẵn sàng. |
| Một số sản phẩm chưa có ảnh hoặc tên quá dài | Thấp | Dùng ảnh logo mặc định dự phòng (`logo.png`), CSS `text-overflow: ellipsis` 2 dòng cho tên thuốc. |
| Tốc độ tải trang bị ảnh hưởng do nhiều ảnh sản phẩm | Thấp | Sử dụng thuộc tính `loading="lazy"` cho ảnh sản phẩm trong slider. |
