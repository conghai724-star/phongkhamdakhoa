-- Giỏ hàng, voucher và điểm thành viên.
-- Quy đổi: 1 điểm = 1.000đ; mỗi 10.000đ thực trả được cộng 1 điểm.

CREATE TABLE IF NOT EXISTS `hicrm_vouchers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(50) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `discount_type` enum('fixed','percent') NOT NULL DEFAULT 'fixed',
  `discount_value` decimal(15,2) NOT NULL DEFAULT 0.00,
  `max_discount` decimal(15,2) DEFAULT NULL,
  `min_order_value` decimal(15,2) NOT NULL DEFAULT 0.00,
  `usage_limit` int unsigned DEFAULT NULL,
  `used_count` int unsigned NOT NULL DEFAULT 0,
  `per_user_limit` int unsigned NOT NULL DEFAULT 1,
  `start_at` datetime DEFAULT NULL,
  `end_at` datetime DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_hicrm_vouchers_code` (`code`),
  KEY `idx_hicrm_vouchers_active_time` (`is_active`,`start_at`,`end_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE `hicrm_users`
  ADD COLUMN IF NOT EXISTS `loyalty_points` int unsigned NOT NULL DEFAULT 0 AFTER `user_basic_salary`;

ALTER TABLE `booking_internal`
  ADD COLUMN IF NOT EXISTS `user_id` bigint DEFAULT NULL AFTER `id`,
  ADD COLUMN IF NOT EXISTS `subtotal` decimal(15,2) NOT NULL DEFAULT 0.00 AFTER `extra_note`,
  ADD COLUMN IF NOT EXISTS `shipping_fee` decimal(15,2) NOT NULL DEFAULT 0.00 AFTER `subtotal`,
  ADD COLUMN IF NOT EXISTS `voucher_code` varchar(50) DEFAULT NULL AFTER `shipping_fee`,
  ADD COLUMN IF NOT EXISTS `voucher_discount` decimal(15,2) NOT NULL DEFAULT 0.00 AFTER `voucher_code`,
  ADD COLUMN IF NOT EXISTS `points_used` int unsigned NOT NULL DEFAULT 0 AFTER `voucher_discount`,
  ADD COLUMN IF NOT EXISTS `points_discount` decimal(15,2) NOT NULL DEFAULT 0.00 AFTER `points_used`,
  ADD COLUMN IF NOT EXISTS `total_amount` decimal(15,2) NOT NULL DEFAULT 0.00 AFTER `points_discount`,
  ADD COLUMN IF NOT EXISTS `points_earned` int unsigned NOT NULL DEFAULT 0 AFTER `total_amount`,
  ADD INDEX IF NOT EXISTS `idx_booking_internal_user_id` (`user_id`),
  ADD INDEX IF NOT EXISTS `idx_booking_internal_voucher_code` (`voucher_code`);

INSERT INTO `hicrm_vouchers`
  (`code`, `name`, `description`, `discount_type`, `discount_value`, `max_discount`, `min_order_value`, `usage_limit`, `per_user_limit`, `is_active`)
VALUES
  ('BANMOI15', 'Ưu đãi thành viên mới', 'Giảm 15.000đ cho đơn hàng bất kỳ từ 100.000đ', 'fixed', 15000, NULL, 100000, NULL, 1, 1),
  ('KT30K', 'Tri ân sức khỏe cộng đồng', 'Giảm ngay 30.000đ cho đơn hàng từ 300.000đ', 'fixed', 30000, NULL, 300000, NULL, 3, 1),
  ('FREESHIP20', 'Hỗ trợ phí vận chuyển', 'Giảm 20.000đ cho đơn từ 200.000đ', 'fixed', 20000, NULL, 200000, NULL, 3, 1),
  ('VIP50K', 'Voucher khách hàng thân thiết', 'Giảm ngay 50.000đ cho đơn hàng từ 500.000đ', 'fixed', 50000, NULL, 500000, NULL, 2, 1),
  ('DAIDON100K', 'Ưu đãi tủ thuốc gia đình', 'Giảm 100.000đ cho đơn hàng từ 800.000đ', 'fixed', 100000, NULL, 800000, NULL, 1, 1)
ON DUPLICATE KEY UPDATE
  `name` = VALUES(`name`),
  `description` = VALUES(`description`),
  `discount_type` = VALUES(`discount_type`),
  `discount_value` = VALUES(`discount_value`),
  `max_discount` = VALUES(`max_discount`),
  `min_order_value` = VALUES(`min_order_value`),
  `per_user_limit` = VALUES(`per_user_limit`);
