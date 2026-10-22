-- ========================================================
-- Migration: Bổ sung định danh Social Login cho hicrm_users và cấu hình hicrm_configs
-- Không tạo bảng mới. Không làm thay đổi dữ liệu hiện có.
-- Hỗ trợ Zalo, Google, Facebook.
-- ========================================================

-- 1. Cột user_zalo_id
SET @has_zalo = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'hicrm_users' AND COLUMN_NAME = 'user_zalo_id');
SET @ddl_zalo = IF(@has_zalo = 0, 'ALTER TABLE hicrm_users ADD COLUMN user_zalo_id VARCHAR(64) CHARACTER SET ascii COLLATE ascii_bin NULL DEFAULT NULL COMMENT \'ID Zalo Social khách hàng\'', 'SELECT 1');
PREPARE stmt_zalo FROM @ddl_zalo;
EXECUTE stmt_zalo;
DEALLOCATE PREPARE stmt_zalo;

SET @has_zalo_idx = (SELECT COUNT(*) FROM information_schema.STATISTICS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'hicrm_users' AND INDEX_NAME = 'uq_hicrm_users_zalo_id');
SET @ddl_zalo_idx = IF(@has_zalo_idx = 0, 'ALTER TABLE hicrm_users ADD UNIQUE KEY uq_hicrm_users_zalo_id (user_zalo_id)', 'SELECT 1');
PREPARE stmt_zalo_idx FROM @ddl_zalo_idx;
EXECUTE stmt_zalo_idx;
DEALLOCATE PREPARE stmt_zalo_idx;

-- 2. Cột user_google_id
SET @has_google = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'hicrm_users' AND COLUMN_NAME = 'user_google_id');
SET @ddl_google = IF(@has_google = 0, 'ALTER TABLE hicrm_users ADD COLUMN user_google_id VARCHAR(64) CHARACTER SET ascii COLLATE ascii_bin NULL DEFAULT NULL COMMENT \'ID Google Sub khách hàng\'', 'SELECT 1');
PREPARE stmt_google FROM @ddl_google;
EXECUTE stmt_google;
DEALLOCATE PREPARE stmt_google;

SET @has_google_idx = (SELECT COUNT(*) FROM information_schema.STATISTICS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'hicrm_users' AND INDEX_NAME = 'uq_hicrm_users_google_id');
SET @ddl_google_idx = IF(@has_google_idx = 0, 'ALTER TABLE hicrm_users ADD UNIQUE KEY uq_hicrm_users_google_id (user_google_id)', 'SELECT 1');
PREPARE stmt_google_idx FROM @ddl_google_idx;
EXECUTE stmt_google_idx;
DEALLOCATE PREPARE stmt_google_idx;

-- 3. Cột user_facebook_id
SET @has_fb = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'hicrm_users' AND COLUMN_NAME = 'user_facebook_id');
SET @ddl_fb = IF(@has_fb = 0, 'ALTER TABLE hicrm_users ADD COLUMN user_facebook_id VARCHAR(64) CHARACTER SET ascii COLLATE ascii_bin NULL DEFAULT NULL COMMENT \'ID Facebook User khách hàng\'', 'SELECT 1');
PREPARE stmt_fb FROM @ddl_fb;
EXECUTE stmt_fb;
DEALLOCATE PREPARE stmt_fb;

SET @has_fb_idx = (SELECT COUNT(*) FROM information_schema.STATISTICS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'hicrm_users' AND INDEX_NAME = 'uq_hicrm_users_facebook_id');
SET @ddl_fb_idx = IF(@has_fb_idx = 0, 'ALTER TABLE hicrm_users ADD UNIQUE KEY uq_hicrm_users_facebook_id (user_facebook_id)', 'SELECT 1');
PREPARE stmt_fb_idx FROM @ddl_fb_idx;
EXECUTE stmt_fb_idx;
DEALLOCATE PREPARE stmt_fb_idx;

-- 4. Cấu hình mặc định trong hicrm_configs (nếu chưa có)
INSERT INTO hicrm_configs (config_key, config_value)
SELECT 'google_client_id', '' WHERE NOT EXISTS (SELECT 1 FROM hicrm_configs WHERE config_key = 'google_client_id');
INSERT INTO hicrm_configs (config_key, config_value)
SELECT 'google_client_secret', '' WHERE NOT EXISTS (SELECT 1 FROM hicrm_configs WHERE config_key = 'google_client_secret');
INSERT INTO hicrm_configs (config_key, config_value)
SELECT 'google_redirect_uri', '' WHERE NOT EXISTS (SELECT 1 FROM hicrm_configs WHERE config_key = 'google_redirect_uri');

INSERT INTO hicrm_configs (config_key, config_value)
SELECT 'facebook_app_id', '' WHERE NOT EXISTS (SELECT 1 FROM hicrm_configs WHERE config_key = 'facebook_app_id');
INSERT INTO hicrm_configs (config_key, config_value)
SELECT 'facebook_app_secret', '' WHERE NOT EXISTS (SELECT 1 FROM hicrm_configs WHERE config_key = 'facebook_app_secret');
INSERT INTO hicrm_configs (config_key, config_value)
SELECT 'facebook_redirect_uri', '' WHERE NOT EXISTS (SELECT 1 FROM hicrm_configs WHERE config_key = 'facebook_redirect_uri');
