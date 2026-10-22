-- CHỜ DUYỆT. Sao lưu và đối chiếu metadata trước khi chạy.
-- MariaDB 10.4, không khẳng định tương thích nguyên văn MySQL.
-- Chạy sau file 01. Có thể khóa bảng; lên lịch bảo trì. DDL tự COMMIT.
SET NAMES utf8mb4;
SET time_zone = '+07:00';
ALTER TABLE hicrm_users ENGINE=InnoDB;
ALTER TABLE hicrm_users MODIFY COLUMN loyalty_points BIGINT NOT NULL DEFAULT 0 COMMENT 'Số dư điểm khả dụng có dấu; âm là nợ điểm sau thu hồi';

-- Bắt buộc đổi MyISAM sang InnoDB; MODIFY loyalty_points từ INT UNSIGNED thành BIGINT signed để thể hiện nợ điểm khi hoàn sau khi điểm thưởng đã tiêu. Không ép UNIQUE email/SĐT khi chưa dọn tài khoản cũ/nhân viên.
ALTER TABLE `hicrm_users`
  ADD COLUMN IF NOT EXISTS `loyalty_reserved` BIGINT UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Điểm giữ cho đơn chưa chốt, cập nhật cùng số dư/ledger.',
  ADD COLUMN IF NOT EXISTS `customer_profile` JSON NULL COMMENT 'Tối đa 10 addresses có UUID, recipient, phone, address_line, province/ward, is_default; tags và care_note. API phân quyền xem/sửa.',
  ADD COLUMN IF NOT EXISTS `lifetime_net_spend` DECIMAL(18,2) NOT NULL DEFAULT 0 COMMENT 'Cache giá trị mua hoàn tất sau hoàn trả để phân hạng; đối chiếu định kỳ.',
  ADD COLUMN IF NOT EXISTS `loyalty_tier_code` VARCHAR(30) NOT NULL DEFAULT 'standard' COMMENT 'Mã hạng để lọc nhanh, quy tắc hạng trong configs.',
  ADD COLUMN IF NOT EXISTS `profile_updated_at` DATETIME NULL COMMENT 'Mốc cập nhật hồ sơ.',
  ADD INDEX IF NOT EXISTS ix_users_phone (user_phone),
  ADD INDEX IF NOT EXISTS ix_users_email (user_email(191)),
  ADD INDEX IF NOT EXISTS ix_users_username (user_username(191)),
  ADD INDEX IF NOT EXISTS ix_users_tier (loyalty_tier_code,id);

-- Mã product_code=etc-tm-02 hiện trùng: chỉ index thường, chưa ép UNIQUE. Không tự tạo lô/hạn hoặc quy đổi số tồn/giá cũ.
ALTER TABLE `hicrm_products`
  ADD COLUMN IF NOT EXISTS `parent_product_id` BIGINT NULL COMMENT 'Sản phẩm cha, mỗi biến thể độc lập là SKU riêng.',
  ADD COLUMN IF NOT EXISTS `base_product_id` BIGINT NULL COMMENT 'SKU cơ sở quản lý tồn; NULL nghĩa chính SKU này.',
  ADD COLUMN IF NOT EXISTS `base_unit_factor` DECIMAL(14,3) NOT NULL DEFAULT 1 COMMENT 'Số đơn vị cơ sở của 1 đơn vị bán; API bắt buộc >0, không quy đổi vòng.',
  ADD COLUMN IF NOT EXISTS `variant_label` VARCHAR(150) NULL COMMENT 'Tên biến thể/đóng gói.',
  ADD COLUMN IF NOT EXISTS `stock_alert_qty` DECIMAL(14,3) NOT NULL DEFAULT 0 COMMENT 'Ngưỡng cảnh báo theo đơn vị cơ sở, cấu hình trên SKU cơ sở.',
  ADD COLUMN IF NOT EXISTS `requires_lot` TINYINT(1) NOT NULL DEFAULT 0 COMMENT '1 là bắt buộc lô/hạn, cần chốt danh sách áp dụng.',
  ADD COLUMN IF NOT EXISTS `is_featured` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'Chọn thủ công trang chủ.',
  ADD COLUMN IF NOT EXISTS `display_order` INT NOT NULL DEFAULT 0 COMMENT 'Thứ tự ưu tiên trang chủ.',
  ADD COLUMN IF NOT EXISTS `rating_sum` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Cache tổng sao approved, không tính bình luận rating NULL.',
  ADD COLUMN IF NOT EXISTS `rating_count` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Cache số lượt approved có sao; trung bình = sum/count.',
  ADD INDEX IF NOT EXISTS ix_products_category (product_category,product_status,id),
  ADD INDEX IF NOT EXISTS ix_products_new (product_status,product_created_time,id),
  ADD INDEX IF NOT EXISTS ix_products_featured (is_featured,product_status,display_order,id),
  ADD INDEX IF NOT EXISTS ix_products_code (product_code),
  ADD INDEX IF NOT EXISTS ix_products_parent (parent_product_id),
  ADD INDEX IF NOT EXISTS ix_products_base (base_product_id);

-- Giữ cột hiện có; API cũ phải chuyển sang offer_uses/cơ chế giữ lượt trước khi bật luồng mới.
ALTER TABLE `hicrm_vouchers`
  ADD COLUMN IF NOT EXISTS `scope_rules` JSON NULL COMMENT 'product_ids, category_ids, user_ids, customer_groups; NULL không hạn chế ngoài điều kiện sẵn có.',
  ADD COLUMN IF NOT EXISTS `reserved_count` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Lượt giữ; kiểm tra used_count + reserved_count dưới usage_limit trong transaction.',
  ADD COLUMN IF NOT EXISTS `stack_policy` ENUM('exclusive','with_promotion','with_points','all') NOT NULL DEFAULT 'exclusive' COMMENT 'Quy tắc kết hợp cần duyệt.',
  ADD COLUMN IF NOT EXISTS `restore_on_cancel` TINYINT(1) NOT NULL DEFAULT 1 COMMENT 'Đề xuất trả lượt khi hủy trước hoàn tất, không tự trả khi hoàn một phần.';

-- Chuyển promo_products/promo_customers sang scope_rules có kiểm tra; không mặc định text cũ hợp lệ JSON. Cần chốt promo_qty/promo_max_apply là giới hạn tổng/theo khách.
ALTER TABLE `hicrm_promotions`
  ADD COLUMN IF NOT EXISTS `scope_rules` JSON NULL COMMENT 'Điều kiện danh mục/sản phẩm/nhóm khách/mức đơn chuẩn hóa mới; không dùng 2 nguồn điều kiện sau chuyển đổi.',
  ADD COLUMN IF NOT EXISTS `priority` INT NOT NULL DEFAULT 100 COMMENT 'Số nhỏ áp dụng trước.',
  ADD COLUMN IF NOT EXISTS `stack_policy` ENUM('exclusive','with_voucher','with_points','all') NOT NULL DEFAULT 'exclusive' COMMENT 'Kết hợp voucher/điểm.',
  ADD COLUMN IF NOT EXISTS `reserved_count` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Lượt giữ phối hợp promo_used/offer_uses.',
  ADD COLUMN IF NOT EXISTS `max_discount_amount` DECIMAL(18,2) NULL COMMENT 'Trần tiền giảm theo phần trăm; NULL nếu không đặt trần riêng.',
  ADD INDEX IF NOT EXISTS ix_promo_active (promo_status,promo_from,promo_to);
