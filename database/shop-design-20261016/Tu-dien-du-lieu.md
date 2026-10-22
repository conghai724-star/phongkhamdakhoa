# Từ điển dữ liệu chi tiết

Nguồn: Bang-mo-ta-chuc-nang.xlsx, sheet Việc cần làm, A1:C23; metadata MariaDB 10.4.21 ngày 16/10/2026.

**Chờ duyệt, chưa tạo bảng trên database.** Đọc Phan-tich-va-trien-khai.md trước SQL.

Row/dòng là một bản ghi nghiệp vụ; cột là thuộc tính của dòng. NOT NULL: bắt buộc; NULL: có thể thiếu. PRIMARY KEY: định danh dòng; UNIQUE: chống trùng; KEY: chỉ mục tăng tốc, không phải khóa ngoại. Tham chiếu logic phải được API kiểm tra tồn tại và quyền sở hữu.

Tất cả bảng mới InnoDB/utf8mb4; thời gian Việt Nam +07:00; tiền VND dùng DECIMAL, số lượng kho dùng DECIMAL(14,3). Không khai báo FOREIGN KEY vật lý. CHECK chỉ kiểm tra trong dòng, không thay thế transaction/ràng buộc liên bảng.

## 11 bảng mới

### hicrm_shop_orders

Một dòng là một đơn bán hàng online, kể cả khách chưa đăng ký.

Ví dụ: Đơn UH20261016-0001 tổng 125.000đ, pending/unpaid, nhận tại nhà thuốc.

| Cột | Kiểu và ràng buộc | Ý nghĩa |
|---|---|---|
| `id` | `BIGINT UNSIGNED NOT NULL AUTO_INCREMENT` | Khóa chính tăng tự động. |
| `order_code` | `VARCHAR(40) CHARACTER SET ascii COLLATE ascii_bin NOT NULL` | Mã đơn công khai duy nhất. |
| `checkout_key` | `CHAR(64) CHARACTER SET ascii COLLATE ascii_bin NOT NULL` | SHA-256 khóa gửi đơn, chống tạo lặp khi retry/double-click. |
| `legacy_booking_id` | `INT UNSIGNED NULL` | ID booking_internal khi chuyển dữ liệu cũ, NULL cho đơn mới. |
| `user_id` | `BIGINT NULL` | ID hicrm_users; NULL là khách vãng lai. |
| `warehouse_id` | `INT NOT NULL` | ID kho/điểm nhận hicrm_warehouses. |
| `recipient_name` | `VARCHAR(150) NOT NULL` | Tên người nhận chụp lúc đặt. |
| `recipient_phone` | `VARCHAR(20) CHARACTER SET ascii NOT NULL` | SĐT chuẩn hóa chụp lúc đặt, không đổi theo hồ sơ. |
| `recipient_email` | `VARCHAR(254) NULL` | Email nếu có. |
| `delivery_method` | `ENUM('pickup','delivery') NOT NULL` | Nhận tại nhà thuốc hoặc giao tận nơi. |
| `address_snapshot` | `JSON NULL` | address_line, province_code/name, ward_code/name; delivery bắt buộc có địa chỉ. |
| `delivery_status` | `ENUM('not_started','preparing','in_transit','delivered','failed','returned') NOT NULL DEFAULT 'not_started'` | Trạng thái giao nhận, độc lập trạng thái đơn và tiền. |
| `carrier` | `VARCHAR(80) NULL` | Đơn vị giao hàng. |
| `tracking_code` | `VARCHAR(100) NULL` | Mã vận đơn. |
| `status` | `ENUM('pending','confirmed','preparing','shipping','completed','cancelled','rejected') NOT NULL DEFAULT 'pending'` | Trạng thái xử lý đơn. |
| `payment_status` | `ENUM('unpaid','partial','paid','partial_refund','refunded') NOT NULL DEFAULT 'unpaid'` | Trạng thái tiền tổng hợp từ khoản thu/hoàn thành công. |
| `payment_method` | `ENUM('momo','vnpay','zalopay','bank','cod','cash') NOT NULL` | Lựa chọn lúc đặt, không đồng nghĩa đã thu tiền. |
| `subtotal` | `DECIMAL(18,2) NOT NULL` | Tổng line_amount sau khuyến mãi sản phẩm, trước voucher/điểm; giả định giá đã gồm VAT. |
| `shipping_fee` | `DECIMAL(18,2) NOT NULL DEFAULT 0` | Phí giao sau ưu đãi vận chuyển, không âm. |
| `voucher_id` | `BIGINT UNSIGNED NULL` | ID hicrm_vouchers. |
| `voucher_code` | `VARCHAR(50) NULL` | Mã voucher chụp lúc đặt. |
| `voucher_discount` | `DECIMAL(18,2) NOT NULL DEFAULT 0` | Tiền giảm voucher, không tính lặp vào giảm giá dòng. |
| `points_used` | `INT UNSIGNED NOT NULL DEFAULT 0` | Số điểm giữ/đổi, không phải tiền. |
| `points_discount` | `DECIMAL(18,2) NOT NULL DEFAULT 0` | Tiền quy đổi điểm theo tỷ lệ snapshot. |
| `total_amount` | `DECIMAL(18,2) NOT NULL` | subtotal + shipping_fee - voucher_discount - points_discount. |
| `paid_amount` | `DECIMAL(18,2) NOT NULL DEFAULT 0` | Tổng khách đã trả, gồm COD đã thu; không cộng lại khi hãng chuyển tiền về. |
| `refunded_amount` | `DECIMAL(18,2) NOT NULL DEFAULT 0` | Tiền đã hoàn thành công, không tính yêu cầu chưa xong. |
| `points_expected` | `INT UNSIGNED NOT NULL DEFAULT 0` | Điểm dự kiến trang cảm ơn, chưa phải điểm đã cộng. |
| `pricing_snapshot` | `JSON NOT NULL` | Quy tắc tính giá, phí giao, tỷ lệ điểm và phân bổ giảm giá lúc đặt. |
| `customer_note` | `VARCHAR(1000) NULL` | Ghi chú của khách. |
| `internal_note` | `TEXT NULL` | Ghi chú nội bộ, không trả về API khách. |
| `prescription_path` | `VARCHAR(500) NULL` | Khóa file đơn thuốc; tải qua phân quyền, không public URL. |
| `expires_at` | `DATETIME NULL` | Hạn thanh toán/giữ tài nguyên. |
| `completed_at` | `DATETIME NULL` | Ngày hoàn tất, mốc báo cáo theo chính sách cần duyệt. |
| `cancelled_at` | `DATETIME NULL` | Ngày hủy/từ chối. |
| `created_at` | `DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP` | Ngày tạo, giờ Việt Nam. |
| `updated_at` | `DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP` | Ngày cập nhật gần nhất. |

Khóa/index:

- `PRIMARY KEY (id)`.
- `UNIQUE KEY uq_shop_code (order_code)`.
- `UNIQUE KEY uq_shop_checkout (checkout_key)`.
- `UNIQUE KEY uq_shop_legacy (legacy_booking_id)`.
- `KEY ix_shop_user (user_id,created_at,id)`.
- `KEY ix_shop_status (status,created_at,id)`.
- `KEY ix_shop_payment (payment_status,created_at,id)`.
- `KEY ix_shop_method (payment_method,created_at,id)`.
- `KEY ix_shop_created (created_at,id)`.
- `KEY ix_shop_completed (completed_at,id)`.
- `KEY ix_shop_expiry (status,expires_at)`.
- `KEY ix_shop_phone (recipient_phone,created_at)`.

CHECK: `subtotal>=0 AND shipping_fee>=0 AND voucher_discount>=0 AND points_discount>=0 AND total_amount=subtotal+shipping_fee-voucher_discount-points_discount AND total_amount>=0 AND paid_amount>=0 AND refunded_amount>=0 AND refunded_amount<=paid_amount`.

### hicrm_shop_order_items

Một dòng là một SKU/đơn vị bán trong một đơn; tách dòng để báo cáo không phải bóc JSON.

Ví dụ: Đơn có 2 sản phẩm tạo 2 dòng, không gộp tên/số lượng vào một chuỗi.

| Cột | Kiểu và ràng buộc | Ý nghĩa |
|---|---|---|
| `id` | `BIGINT UNSIGNED NOT NULL AUTO_INCREMENT` | Khóa chính tăng tự động. |
| `order_id` | `BIGINT UNSIGNED NOT NULL` | ID hicrm_shop_orders. |
| `line_no` | `SMALLINT UNSIGNED NOT NULL` | Số thứ tự dòng trong đơn, bắt đầu 1. |
| `product_id` | `BIGINT NOT NULL` | ID hicrm_products; biến thể độc lập có ID riêng. |
| `product_code` | `VARCHAR(50) NOT NULL` | Mã SKU chụp lúc đặt. |
| `product_name` | `VARCHAR(255) NOT NULL` | Tên chụp, không đổi theo tên sản phẩm hiện tại. |
| `unit_id` | `INT NOT NULL` | ID đơn vị bán hicrm_units. |
| `unit_name` | `VARCHAR(50) NOT NULL` | Tên đơn vị chụp: hộp, chai, viên. |
| `quantity` | `DECIMAL(14,3) NOT NULL` | Lượng bán; chỉ cho số lẻ khi sản phẩm cho phép. |
| `base_quantity` | `DECIMAL(14,3) NOT NULL` | Lượng quy về SKU cơ sở để giữ/xuất kho. |
| `unit_price` | `DECIMAL(18,2) NOT NULL` | Giá một đơn vị trước giảm, giả định đã gồm thuế. |
| `promotion_id` | `BIGINT NULL` | ID chương trình chính hicrm_promotions. |
| `promotion_discount` | `DECIMAL(18,2) NOT NULL DEFAULT 0` | Tổng giảm khuyến mãi trên dòng. |
| `line_amount` | `DECIMAL(18,2) NOT NULL` | ROUND(quantity * unit_price,2) - promotion_discount, trước voucher/điểm. |
| `allocated_discount` | `DECIMAL(18,2) NOT NULL DEFAULT 0` | Phân bổ voucher/điểm, phục vụ tính hoàn/doanh thu. |
| `tax_amount` | `DECIMAL(18,2) NOT NULL DEFAULT 0` | Thuế đã nằm trong line_amount, không cộng lại. |
| `cost_amount` | `DECIMAL(18,2) NULL` | Tổng giá vốn đã xuất; NULL khi chưa có dữ liệu. |
| `product_snapshot` | `JSON NULL` | Thông số, biến thể, quy đổi đơn vị, ảnh và các khuyến mãi đã áp dụng. |
| `created_at` | `DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP` | Ngày tạo, giờ Việt Nam. |
| `updated_at` | `DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP` | Ngày cập nhật gần nhất. |

Khóa/index:

- `PRIMARY KEY (id)`.
- `UNIQUE KEY uq_shop_line (order_id,line_no)`.
- `KEY ix_shop_item_product (product_id,order_id)`.

CHECK: `quantity>0 AND base_quantity>0 AND unit_price>=0 AND promotion_discount>=0 AND line_amount=ROUND(quantity*unit_price,2)-promotion_discount AND line_amount>=0 AND allocated_discount>=0 AND allocated_discount<=line_amount AND tax_amount>=0`.

### hicrm_shop_payments

Một dòng là một lần thử thanh toán hoặc một khoản thu xác định; một đơn có nhiều lần thử.

Ví dụ: MoMo thất bại rồi VNPAY thành công tạo 2 dòng; callback lặp không tạo thêm khoản thu.

| Cột | Kiểu và ràng buộc | Ý nghĩa |
|---|---|---|
| `id` | `BIGINT UNSIGNED NOT NULL AUTO_INCREMENT` | Khóa chính tăng tự động. |
| `order_id` | `BIGINT UNSIGNED NOT NULL` | ID đơn liên quan. |
| `provider` | `ENUM('momo','vnpay','zalopay','bank','cod','cash') NOT NULL` | Gộp mọi kênh, không tách bảng từng cổng. |
| `request_code` | `VARCHAR(100) CHARACTER SET ascii COLLATE ascii_bin NOT NULL` | Mã yêu cầu hệ thống sinh, duy nhất theo provider. |
| `provider_transaction_id` | `VARCHAR(128) CHARACTER SET ascii COLLATE ascii_bin NULL` | Mã giao dịch ngoài, NULL trước khi có; bank dùng mã khoản nhận thực, không dùng nội dung chuyển khoản làm định danh duy nhất. |
| `idempotency_key` | `CHAR(64) CHARACTER SET ascii COLLATE ascii_bin NOT NULL` | Chống tạo lặp lần thử/khoản thu. |
| `amount` | `DECIMAL(18,2) NOT NULL` | Số tiền VND; adapter đổi đơn vị theo từng giao thức cổng, không dùng float. |
| `currency` | `CHAR(3) CHARACTER SET ascii NOT NULL DEFAULT 'VND'` | Đơn vị tiền. |
| `status` | `ENUM('pending','succeeded','failed','cancelled','expired') NOT NULL DEFAULT 'pending'` | Chỉ succeeded sau backend xác minh, không tin redirect. |
| `payment_url` | `TEXT NULL` | URL thanh toán/QR có hạn; không lưu secret/token lâu dài. |
| `provider_result_code` | `VARCHAR(50) NULL` | Mã kết quả từ nhà cung cấp. |
| `settlement_status` | `ENUM('not_applicable','pending','partial','settled','disputed') NOT NULL DEFAULT 'not_applicable'` | Tách khách đã trả và nhà thuốc đã nhận tiền từ hãng/cổng. |
| `settled_amount` | `DECIMAL(18,2) NOT NULL DEFAULT 0` | Tiền gộp đã đối soát về trước phí; tiền ròng + phí = phần gộp đã chuyển. |
| `fee_amount` | `DECIMAL(18,2) NOT NULL DEFAULT 0` | Phí dịch vụ thực tế. |
| `settled_at` | `DATETIME NULL` | Ngày đối soát đủ. |
| `confirmed_by` | `BIGINT NULL` | Nhân viên xác nhận bank/COD/cash, NULL khi tự động. |
| `verified_at` | `DATETIME NULL` | Ngày xác minh kết quả. |
| `paid_at` | `DATETIME NULL` | Ngày khoản thu thành công. |
| `expires_at` | `DATETIME NULL` | Hạn thanh toán. |
| `provider_data` | `JSON NULL` | Mã ngân hàng/chứng từ/dữ liệu đối soát đã lọc; không secret/token/thẻ đầy đủ. |
| `created_at` | `DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP` | Ngày tạo, giờ Việt Nam. |
| `updated_at` | `DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP` | Ngày cập nhật gần nhất. |

Khóa/index:

- `PRIMARY KEY (id)`.
- `UNIQUE KEY uq_payment_request (provider,request_code)`.
- `UNIQUE KEY uq_payment_external (provider,provider_transaction_id)`.
- `UNIQUE KEY uq_payment_once (idempotency_key)`.
- `KEY ix_payment_order (order_id,status)`.
- `KEY ix_payment_paid (status,paid_at,id)`.
- `KEY ix_payment_settlement (settlement_status,paid_at,id)`.
- `KEY ix_payment_expiry (status,expires_at)`.

CHECK: `amount>0 AND settled_amount>=0 AND settled_amount<=amount AND fee_amount>=0`.

### hicrm_shop_refunds

Một dòng là yêu cầu hủy/trả/hoàn; tổng giữ hạn mức và đã hoàn không vượt tiền/số lượng còn được hoàn.

Ví dụ: Đã thu 500.000đ, hoàn 100.000đ tạo 1 dòng hoàn, không sửa âm khoản thu gốc.

| Cột | Kiểu và ràng buộc | Ý nghĩa |
|---|---|---|
| `id` | `BIGINT UNSIGNED NOT NULL AUTO_INCREMENT` | Khóa chính tăng tự động. |
| `refund_code` | `VARCHAR(40) CHARACTER SET ascii COLLATE ascii_bin NOT NULL` | Mã yêu cầu duy nhất. |
| `idempotency_key` | `CHAR(64) CHARACTER SET ascii COLLATE ascii_bin NOT NULL` | Chống yêu cầu/hoàn trùng. |
| `order_id` | `BIGINT UNSIGNED NOT NULL` | Đơn gốc. |
| `payment_id` | `BIGINT UNSIGNED NULL` | Khoản thu gốc; NULL khi hủy chưa thu. Hoàn từ nhiều khoản thu thì tách yêu cầu. |
| `request_type` | `ENUM('cancel','return','refund') NOT NULL` | Hủy đơn, trả hàng, hoặc chỉ hoàn tiền. |
| `status` | `ENUM('requested','approved','processing','succeeded','rejected','cancelled','failed') NOT NULL DEFAULT 'requested'` | approved/processing giữ hạn mức; succeeded mới tính đã hoàn. |
| `amount` | `DECIMAL(18,2) NOT NULL DEFAULT 0` | Tiền hoàn; 0 nếu chỉ hủy chưa thu. |
| `reason` | `VARCHAR(1000) NOT NULL` | Lý do khách/nhân viên. |
| `items_snapshot` | `JSON NULL` | Danh sách order_item_id, quantity, base_quantity, goods_amount, shipping_amount; API kiểm tra không hoàn trùng/quá số lượng và tổng khớp amount. |
| `evidence_files` | `JSON NULL` | Khóa file bằng chứng, tải có phân quyền. |
| `return_status` | `ENUM('not_required','awaiting','received','inspected','rejected') NOT NULL DEFAULT 'not_required'` | Nhận/kiểm tra hàng, độc lập tiền hoàn. |
| `provider_refund_id` | `VARCHAR(128) CHARACTER SET ascii COLLATE ascii_bin NULL` | Mã hoàn bên cung cấp. |
| `reviewed_by` | `BIGINT NULL` | Nhân viên duyệt/từ chối. |
| `reviewed_at` | `DATETIME NULL` | Ngày duyệt. |
| `resolution_note` | `TEXT NULL` | Kết quả xử lý/lý do từ chối. |
| `restocked_at` | `DATETIME NULL` | Đã xử lý nhập kho đúng một lần sau kiểm tra. |
| `completed_at` | `DATETIME NULL` | Ngày hoàn tiền thực tế thành công. |
| `created_at` | `DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP` | Ngày tạo, giờ Việt Nam. |
| `updated_at` | `DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP` | Ngày cập nhật gần nhất. |

Khóa/index:

- `PRIMARY KEY (id)`.
- `UNIQUE KEY uq_refund_code (refund_code)`.
- `UNIQUE KEY uq_refund_once (idempotency_key)`.
- `KEY ix_refund_order (order_id,status)`.
- `KEY ix_refund_payment (payment_id,status)`.
- `KEY ix_refund_queue (status,created_at,id)`.
- `KEY ix_refund_completed (completed_at,id)`.

CHECK: `amount>=0 AND (amount=0 OR payment_id IS NOT NULL)`.

### hicrm_stock_lots

Một dòng là tồn một SKU cơ sở tại một kho và một lô; hàng không theo lô dùng mã DEFAULT.

Ví dụ: SKU A có lô L01/L02 ở kho 1 tạo 2 dòng; tồn bán = tồn vật lý - giữ trên các lô đủ điều kiện.

| Cột | Kiểu và ràng buộc | Ý nghĩa |
|---|---|---|
| `id` | `BIGINT UNSIGNED NOT NULL AUTO_INCREMENT` | Khóa chính tăng tự động. |
| `product_id` | `BIGINT NOT NULL` | SKU cơ sở hicrm_products.id. |
| `warehouse_id` | `INT NOT NULL` | Kho hicrm_warehouses.id. |
| `lot_code` | `VARCHAR(80) NOT NULL` | Mã lô; cùng SKU/kho/lô chỉ có một hạn dùng. |
| `expires_on` | `DATE NULL` | Hạn dùng; NULL chỉ khi hàng không bắt buộc theo hạn. |
| `quantity_on_hand` | `DECIMAL(14,3) NOT NULL DEFAULT 0` | Tồn vật lý theo đơn vị cơ sở. |
| `quantity_reserved` | `DECIMAL(14,3) NOT NULL DEFAULT 0` | Tồn giữ chưa xuất. |
| `unit_cost` | `DECIMAL(18,2) NULL` | Giá vốn một đơn vị cơ sở, NULL nếu chưa biết. |
| `status` | `ENUM('active','quarantine','blocked') NOT NULL DEFAULT 'active'` | Chỉ active còn hạn mới bán; hàng trả có thể quarantine. |
| `source_ref` | `VARCHAR(100) NULL` | Định danh lô phần mềm kho ngoài nếu có. |
| `created_at` | `DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP` | Ngày tạo, giờ Việt Nam. |
| `updated_at` | `DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP` | Ngày cập nhật gần nhất. |

Khóa/index:

- `PRIMARY KEY (id)`.
- `UNIQUE KEY uq_stock_lot (product_id,warehouse_id,lot_code)`.
- `KEY ix_stock_fefo (product_id,warehouse_id,status,expires_on,id)`.
- `KEY ix_stock_expiry (status,expires_on,id)`.

CHECK: `quantity_on_hand>=0 AND quantity_reserved>=0 AND quantity_reserved<=quantity_on_hand AND (unit_cost IS NULL OR unit_cost>=0)`.

### hicrm_stock_movements

Một dòng là biến động tồn/giữ trên một lô; chung nhập, xuất, điều chỉnh, giữ và nhả.

Ví dụ: Giữ 2: tồn 0/giữ +2; xuất: -2/-2; hủy trước xuất: 0/-2.

| Cột | Kiểu và ràng buộc | Ý nghĩa |
|---|---|---|
| `id` | `BIGINT UNSIGNED NOT NULL AUTO_INCREMENT` | Khóa chính tăng tự động. |
| `lot_id` | `BIGINT UNSIGNED NOT NULL` | Lô hicrm_stock_lots. |
| `order_id` | `BIGINT UNSIGNED NULL` | Đơn nguồn. |
| `order_item_id` | `BIGINT UNSIGNED NULL` | Dòng hàng nguồn; một dòng hàng có thể lấy nhiều lô. |
| `refund_id` | `BIGINT UNSIGNED NULL` | Yêu cầu trả hàng nguồn. |
| `parent_movement_id` | `BIGINT UNSIGNED NULL` | Dòng reserve gốc khi xuất/nhả hoặc thao tác gốc khi đảo. |
| `event_type` | `ENUM('opening','receipt','reserve','release','issue','return','adjust','sync') NOT NULL` | Loại biến động. |
| `quantity_delta` | `DECIMAL(14,3) NOT NULL DEFAULT 0` | Tăng/giảm tồn vật lý có dấu. |
| `reserved_delta` | `DECIMAL(14,3) NOT NULL DEFAULT 0` | Tăng/giảm lượng giữ có dấu. |
| `on_hand_after` | `DECIMAL(14,3) NOT NULL` | Tồn vật lý sau thao tác để đối chiếu. |
| `reserved_after` | `DECIMAL(14,3) NOT NULL` | Tồn giữ sau thao tác. |
| `hold_expires_at` | `DATETIME NULL` | Hạn giữ trên dòng reserve. |
| `hold_status` | `ENUM('not_applicable','active','consumed','released') NOT NULL DEFAULT 'not_applicable'` | Trạng thái dòng giữ; xuất một phần phải tính tổng dòng con trước khi đóng. |
| `idempotency_key` | `CHAR(64) CHARACTER SET ascii COLLATE ascii_bin NOT NULL` | Khóa nghiệp vụ + lô + hành động; chống xuất/nhả/đồng bộ lặp. |
| `reason` | `VARCHAR(500) NOT NULL` | Lý do bắt buộc. |
| `actor_id` | `BIGINT NULL` | Nhân viên, NULL khi tự động. |
| `created_at` | `DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP` | Ngày tạo, giờ Việt Nam. |
| `updated_at` | `DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP` | Ngày cập nhật gần nhất. |

Khóa/index:

- `PRIMARY KEY (id)`.
- `UNIQUE KEY uq_stock_event (idempotency_key)`.
- `KEY ix_stock_history (lot_id,created_at,id)`.
- `KEY ix_stock_order (order_id,event_type)`.
- `KEY ix_stock_item (order_item_id,event_type)`.
- `KEY ix_stock_parent (parent_movement_id)`.
- `KEY ix_stock_release (hold_status,hold_expires_at,id)`.

CHECK: `(quantity_delta<>0 OR reserved_delta<>0) AND on_hand_after>=0 AND reserved_after>=0 AND reserved_after<=on_hand_after`.

### hicrm_loyalty_entries

Một dòng là lần cộng/trừ/giữ/nhả/hết hạn điểm; không xóa lịch sử để sửa số dư.

Ví dụ: Giữ 5 điểm: khả dụng -5/giữ +5; tiêu: giữ -5, không trừ khả dụng lần hai.

| Cột | Kiểu và ràng buộc | Ý nghĩa |
|---|---|---|
| `id` | `BIGINT UNSIGNED NOT NULL AUTO_INCREMENT` | Khóa chính tăng tự động. |
| `user_id` | `BIGINT NOT NULL` | Tài khoản hicrm_users. |
| `order_id` | `BIGINT UNSIGNED NULL` | Đơn nguồn. |
| `refund_id` | `BIGINT UNSIGNED NULL` | Hoàn tiền nguồn. |
| `event_type` | `ENUM('opening','earn','hold','redeem','release','refund','expire','adjust') NOT NULL` | opening là số dư đầu; earn chỉ sau hoàn tất và thanh toán đủ. |
| `points_delta` | `BIGINT NOT NULL DEFAULT 0` | Đổi số dư khả dụng có dấu, có thể âm khi thu hồi điểm đã tiêu. |
| `reserved_delta` | `BIGINT NOT NULL DEFAULT 0` | Đổi điểm giữ; hold +, redeem/release -. |
| `balance_after` | `BIGINT NOT NULL` | Điểm khả dụng sau thao tác; âm là nợ điểm, không cho tiêu tiếp. |
| `reserved_after` | `BIGINT UNSIGNED NOT NULL` | Điểm giữ sau thao tác. |
| `remaining_points` | `BIGINT UNSIGNED NOT NULL DEFAULT 0` | Phần còn lại của lô earn/opening/adjust dương, dùng quản lý hạn. |
| `expires_at` | `DATETIME NULL` | Hạn lô điểm được cộng; NULL nếu không hết hạn. |
| `allocations` | `JSON NULL` | Danh sách entry_id/points chỉ rõ lô giữ/tiêu/nhả/hoàn; không đọc JSON để tính số dư mỗi request. |
| `idempotency_key` | `CHAR(64) CHARACTER SET ascii COLLATE ascii_bin NOT NULL` | Khóa nghiệp vụ duy nhất, ví dụ earn + order_id, chống cộng lặp. |
| `reason` | `VARCHAR(500) NOT NULL` | Lý do cộng/trừ/điều chỉnh. |
| `actor_id` | `BIGINT NULL` | Nhân viên điều chỉnh, NULL khi tự động. |
| `created_at` | `DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP` | Ngày tạo, giờ Việt Nam. |
| `updated_at` | `DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP` | Ngày cập nhật gần nhất. |

Khóa/index:

- `PRIMARY KEY (id)`.
- `UNIQUE KEY uq_loyalty_event (idempotency_key)`.
- `KEY ix_loyalty_user (user_id,created_at,id)`.
- `KEY ix_loyalty_order (order_id,event_type)`.
- `KEY ix_loyalty_expire (event_type,expires_at,id)`.
- `KEY ix_loyalty_lots (user_id,event_type,expires_at,id)`.

### hicrm_offer_uses

Một dòng là lượt dùng voucher hoặc khuyến mãi trên một đơn; gộp để giảm số bảng.

Ví dụ: Một voucher dùng trên một đơn tạo 1 dòng; hủy đủ điều kiện chuyển released thay vì xóa.

| Cột | Kiểu và ràng buộc | Ý nghĩa |
|---|---|---|
| `id` | `BIGINT UNSIGNED NOT NULL AUTO_INCREMENT` | Khóa chính tăng tự động. |
| `offer_type` | `ENUM('voucher','promotion') NOT NULL` | offer_id thuộc hicrm_vouchers hoặc hicrm_promotions. |
| `offer_id` | `BIGINT UNSIGNED NOT NULL` | ID ưu đãi, API kiểm tra tồn tại/điều kiện. |
| `order_id` | `BIGINT UNSIGNED NOT NULL` | Đơn dùng ưu đãi. |
| `user_id` | `BIGINT NULL` | Khách đăng nhập, NULL nếu vãng lai. |
| `customer_key` | `CHAR(64) CHARACTER SET ascii COLLATE ascii_bin NOT NULL` | HMAC của user_id hoặc SĐT chuẩn hóa; không hash SĐT thuần vì dễ dò. Khách chưa xác thực có thể đổi SĐT. |
| `status` | `ENUM('reserved','used','released') NOT NULL DEFAULT 'reserved'` | reserved chiếm hạn mức; used đã dùng; released trả lượt. |
| `discount_amount` | `DECIMAL(18,2) NOT NULL` | Tiền giảm của lượt, gộp nhiều dòng cùng promotion. |
| `expires_at` | `DATETIME NULL` | Hạn giữ lượt. |
| `released_at` | `DATETIME NULL` | Ngày trả lượt. |
| `release_reason` | `VARCHAR(500) NULL` | Lý do trả lượt theo chính sách. |
| `created_at` | `DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP` | Ngày tạo, giờ Việt Nam. |
| `updated_at` | `DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP` | Ngày cập nhật gần nhất. |

Khóa/index:

- `PRIMARY KEY (id)`.
- `UNIQUE KEY uq_offer_order (offer_type,offer_id,order_id)`.
- `KEY ix_offer_customer (offer_type,offer_id,customer_key,status)`.
- `KEY ix_offer_limit (offer_type,offer_id,status)`.
- `KEY ix_offer_order (order_id)`.
- `KEY ix_offer_expiry (status,expires_at)`.

CHECK: `discount_amount>=0`.

### hicrm_product_reviews

Một dòng là đánh giá hoặc bình luận; phản hồi nhân viên ngay trên dòng, không cần bảng riêng.

Ví dụ: Chấm 5 sao cho dòng hàng đã mua; nhãn đã mua suy từ đơn thật, không nhận cờ từ trình duyệt.

| Cột | Kiểu và ràng buộc | Ý nghĩa |
|---|---|---|
| `id` | `BIGINT UNSIGNED NOT NULL AUTO_INCREMENT` | Khóa chính tăng tự động. |
| `product_id` | `BIGINT NOT NULL` | Sản phẩm. |
| `user_id` | `BIGINT NOT NULL` | Tài khoản gửi, phải đăng nhập. |
| `order_item_id` | `BIGINT UNSIGNED NULL` | Dòng hàng API xác minh thuộc khách/đơn hoàn tất; NULL với bình luận chưa mua. |
| `rating` | `TINYINT UNSIGNED NULL` | 1–5 sao; NULL nếu chỉ bình luận. |
| `content` | `TEXT NOT NULL` | Nội dung, API giới hạn độ dài/chống XSS. |
| `image_paths` | `JSON NULL` | Tối đa 5 khóa file ảnh nếu hỗ trợ. |
| `status` | `ENUM('pending','approved','hidden','rejected') NOT NULL DEFAULT 'pending'` | Chỉ approved được công khai. |
| `content_hash` | `CHAR(64) CHARACTER SET ascii COLLATE ascii_bin NOT NULL` | SHA-256 nội dung chuẩn hóa chống gửi trùng cùng khách/sản phẩm. |
| `reply` | `TEXT NULL` | Phản hồi chính thức của nhà thuốc. |
| `replied_by` | `BIGINT NULL` | Nhân viên trả lời. |
| `replied_at` | `DATETIME NULL` | Ngày trả lời. |
| `moderated_by` | `BIGINT NULL` | Nhân viên duyệt/ẩn. |
| `moderated_at` | `DATETIME NULL` | Ngày kiểm duyệt. |
| `created_at` | `DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP` | Ngày tạo, giờ Việt Nam. |
| `updated_at` | `DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP` | Ngày cập nhật gần nhất. |

Khóa/index:

- `PRIMARY KEY (id)`.
- `UNIQUE KEY uq_review_duplicate (user_id,product_id,content_hash)`.
- `UNIQUE KEY uq_review_purchase (order_item_id)`.
- `KEY ix_review_public (product_id,status,created_at,id)`.
- `KEY ix_review_moderation (status,created_at,id)`.

CHECK: `rating IS NULL OR rating BETWEEN 1 AND 5`.

### hicrm_integration_jobs

Một dòng là tác vụ gửi Zalo OA/SMS/đồng bộ kho; ghi cùng transaction đơn theo mẫu outbox.

Ví dụ: Tạo đơn ghi 1 job Zalo; lỗi mạng retry riêng, không chặn khách nhận mã đơn.

| Cột | Kiểu và ràng buộc | Ý nghĩa |
|---|---|---|
| `id` | `BIGINT UNSIGNED NOT NULL AUTO_INCREMENT` | Khóa chính tăng tự động. |
| `channel` | `ENUM('zalo_oa','sms','inventory_sync') NOT NULL` | Gộp các kênh tích hợp. |
| `event_name` | `VARCHAR(80) CHARACTER SET ascii NOT NULL` | Ví dụ order.created, order.completed, stock.changed. |
| `entity_type` | `VARCHAR(40) CHARACTER SET ascii NOT NULL` | Loại nguồn: order, stock. |
| `entity_id` | `BIGINT UNSIGNED NOT NULL` | ID nguồn. |
| `recipient` | `VARCHAR(255) NOT NULL` | Định danh nhận theo API đã xác nhận hoặc SĐT chuẩn hóa. |
| `payload` | `JSON NOT NULL` | Tham số template đã lọc, không secret/token. |
| `dedupe_key` | `CHAR(64) CHARACTER SET ascii COLLATE ascii_bin NOT NULL` | Khóa sự kiện + đối tượng + người nhận, chống xếp job trùng. |
| `status` | `ENUM('pending','processing','sent','failed','cancelled') NOT NULL DEFAULT 'pending'` | failed sau hết lượt; retry dùng pending với thời gian mới. |
| `attempt_count` | `SMALLINT UNSIGNED NOT NULL DEFAULT 0` | Số lần đã thử. |
| `max_attempts` | `SMALLINT UNSIGNED NOT NULL DEFAULT 5` | Giới hạn retry đề xuất. |
| `next_attempt_at` | `DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP` | Ngày được thử tiếp. |
| `locked_until` | `DATETIME NULL` | Hạn lease để phục hồi job treo. |
| `worker_token` | `CHAR(36) CHARACTER SET ascii NULL` | Worker giữ job, ngăn worker cũ ghi đè worker mới. |
| `provider_message_id` | `VARCHAR(128) NULL` | Mã nhà cung cấp, tra cứu khi timeout. |
| `last_error` | `VARCHAR(1000) NULL` | Lỗi đã lọc, chỉ quản trị xem. |
| `sent_at` | `DATETIME NULL` | Ngày gửi thành công. |
| `created_at` | `DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP` | Ngày tạo, giờ Việt Nam. |
| `updated_at` | `DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP` | Ngày cập nhật gần nhất. |

Khóa/index:

- `PRIMARY KEY (id)`.
- `UNIQUE KEY uq_job_once (dedupe_key)`.
- `KEY ix_job_queue (status,next_attempt_at,id)`.
- `KEY ix_job_lease (status,locked_until)`.
- `KEY ix_job_entity (entity_type,entity_id,channel)`.

### hicrm_audit_logs

Một dòng là sự kiện nghiệp vụ quan trọng hoặc callback đã xác minh; không chứa toàn bộ HTTP log.

Ví dụ: Nhân viên xác nhận bank lưu trước/sau/người làm; callback lặp event_key không cộng tiền lại.

| Cột | Kiểu và ràng buộc | Ý nghĩa |
|---|---|---|
| `id` | `BIGINT UNSIGNED NOT NULL AUTO_INCREMENT` | Khóa chính tăng tự động. |
| `entity_type` | `VARCHAR(40) CHARACTER SET ascii NOT NULL` | order/payment/refund/customer/config/stock... |
| `entity_id` | `BIGINT UNSIGNED NOT NULL` | ID đối tượng. |
| `event_name` | `VARCHAR(80) CHARACTER SET ascii NOT NULL` | Ví dụ order.confirmed, payment.callback, customer.updated. |
| `event_key` | `CHAR(64) CHARACTER SET ascii COLLATE ascii_bin NULL` | Chống xử lý lặp webhook đã xác minh; NULL nếu không cần duy nhất. |
| `actor_id` | `BIGINT NULL` | Người thao tác, NULL khi tự động. |
| `actor_type` | `ENUM('staff','customer','system','provider') NOT NULL` | Nguồn thực hiện. |
| `before_data` | `JSON NULL` | Trường quan trọng trước thay đổi, không mật khẩu/token. |
| `after_data` | `JSON NULL` | Trường sau thay đổi hoặc callback đã lọc nhạy cảm. |
| `reason` | `VARCHAR(1000) NULL` | Lý do đổi trạng thái/điều chỉnh/xuất dữ liệu. |
| `request_id` | `CHAR(36) CHARACTER SET ascii NULL` | Mã lần xử lý để tra cứu. |
| `created_at` | `DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP` | Ngày tạo, giờ Việt Nam. |
| `updated_at` | `DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP` | Ngày cập nhật gần nhất. |

Khóa/index:

- `PRIMARY KEY (id)`.
- `UNIQUE KEY uq_audit_event (event_key)`.
- `KEY ix_audit_entity (entity_type,entity_id,created_at,id)`.
- `KEY ix_audit_time (created_at,id)`.
- `KEY ix_audit_actor (actor_id,created_at)`.

## 4 bảng bổ sung

Dưới đây là toàn bộ cột bổ sung, không thay các cột hiện có. Thay engine/loyalty_points của users được nêu riêng.

### hicrm_users

Bắt buộc đổi MyISAM sang InnoDB; MODIFY loyalty_points từ INT UNSIGNED thành BIGINT signed để thể hiện nợ điểm khi hoàn sau khi điểm thưởng đã tiêu. Không ép UNIQUE email/SĐT khi chưa dọn tài khoản cũ/nhân viên.

| Cột thêm | Kiểu và ràng buộc | Ý nghĩa |
|---|---|---|
| `loyalty_reserved` | `BIGINT UNSIGNED NOT NULL DEFAULT 0` | Điểm giữ cho đơn chưa chốt, cập nhật cùng số dư/ledger. |
| `customer_profile` | `JSON NULL` | Tối đa 10 addresses có UUID, recipient, phone, address_line, province/ward, is_default; tags và care_note. API phân quyền xem/sửa. |
| `lifetime_net_spend` | `DECIMAL(18,2) NOT NULL DEFAULT 0` | Cache giá trị mua hoàn tất sau hoàn trả để phân hạng; đối chiếu định kỳ. |
| `loyalty_tier_code` | `VARCHAR(30) NOT NULL DEFAULT 'standard'` | Mã hạng để lọc nhanh, quy tắc hạng trong configs. |
| `profile_updated_at` | `DATETIME NULL` | Mốc cập nhật hồ sơ. |

- `KEY ix_users_phone (user_phone)`.
- `KEY ix_users_email (user_email(191))`.
- `KEY ix_users_username (user_username(191))`.
- `KEY ix_users_tier (loyalty_tier_code,id)`.

### hicrm_products

Mã product_code=etc-tm-02 hiện trùng: chỉ index thường, chưa ép UNIQUE. Không tự tạo lô/hạn hoặc quy đổi số tồn/giá cũ.

| Cột thêm | Kiểu và ràng buộc | Ý nghĩa |
|---|---|---|
| `parent_product_id` | `BIGINT NULL` | Sản phẩm cha, mỗi biến thể độc lập là SKU riêng. |
| `base_product_id` | `BIGINT NULL` | SKU cơ sở quản lý tồn; NULL nghĩa chính SKU này. |
| `base_unit_factor` | `DECIMAL(14,3) NOT NULL DEFAULT 1` | Số đơn vị cơ sở của 1 đơn vị bán; API bắt buộc >0, không quy đổi vòng. |
| `variant_label` | `VARCHAR(150) NULL` | Tên biến thể/đóng gói. |
| `stock_alert_qty` | `DECIMAL(14,3) NOT NULL DEFAULT 0` | Ngưỡng cảnh báo theo đơn vị cơ sở, cấu hình trên SKU cơ sở. |
| `requires_lot` | `TINYINT(1) NOT NULL DEFAULT 0` | 1 là bắt buộc lô/hạn, cần chốt danh sách áp dụng. |
| `is_featured` | `TINYINT(1) NOT NULL DEFAULT 0` | Chọn thủ công trang chủ. |
| `display_order` | `INT NOT NULL DEFAULT 0` | Thứ tự ưu tiên trang chủ. |
| `rating_sum` | `INT UNSIGNED NOT NULL DEFAULT 0` | Cache tổng sao approved, không tính bình luận rating NULL. |
| `rating_count` | `INT UNSIGNED NOT NULL DEFAULT 0` | Cache số lượt approved có sao; trung bình = sum/count. |

- `KEY ix_products_category (product_category,product_status,id)`.
- `KEY ix_products_new (product_status,product_created_time,id)`.
- `KEY ix_products_featured (is_featured,product_status,display_order,id)`.
- `KEY ix_products_code (product_code)`.
- `KEY ix_products_parent (parent_product_id)`.
- `KEY ix_products_base (base_product_id)`.

### hicrm_vouchers

Giữ cột hiện có; API cũ phải chuyển sang offer_uses/cơ chế giữ lượt trước khi bật luồng mới.

| Cột thêm | Kiểu và ràng buộc | Ý nghĩa |
|---|---|---|
| `scope_rules` | `JSON NULL` | product_ids, category_ids, user_ids, customer_groups; NULL không hạn chế ngoài điều kiện sẵn có. |
| `reserved_count` | `INT UNSIGNED NOT NULL DEFAULT 0` | Lượt giữ; kiểm tra used_count + reserved_count dưới usage_limit trong transaction. |
| `stack_policy` | `ENUM('exclusive','with_promotion','with_points','all') NOT NULL DEFAULT 'exclusive'` | Quy tắc kết hợp cần duyệt. |
| `restore_on_cancel` | `TINYINT(1) NOT NULL DEFAULT 1` | Đề xuất trả lượt khi hủy trước hoàn tất, không tự trả khi hoàn một phần. |


### hicrm_promotions

Chuyển promo_products/promo_customers sang scope_rules có kiểm tra; không mặc định text cũ hợp lệ JSON. Cần chốt promo_qty/promo_max_apply là giới hạn tổng/theo khách.

| Cột thêm | Kiểu và ràng buộc | Ý nghĩa |
|---|---|---|
| `scope_rules` | `JSON NULL` | Điều kiện danh mục/sản phẩm/nhóm khách/mức đơn chuẩn hóa mới; không dùng 2 nguồn điều kiện sau chuyển đổi. |
| `priority` | `INT NOT NULL DEFAULT 100` | Số nhỏ áp dụng trước. |
| `stack_policy` | `ENUM('exclusive','with_voucher','with_points','all') NOT NULL DEFAULT 'exclusive'` | Kết hợp voucher/điểm. |
| `reserved_count` | `INT UNSIGNED NOT NULL DEFAULT 0` | Lượt giữ phối hợp promo_used/offer_uses. |
| `max_discount_amount` | `DECIMAL(18,2) NULL` | Trần tiền giảm theo phần trăm; NULL nếu không đặt trần riêng. |

- `KEY ix_promo_active (promo_status,promo_from,promo_to)`.
