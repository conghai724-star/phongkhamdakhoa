-- Chạy trên database website. Không tạo table hoặc thay đổi dữ liệu tài khoản hiện có.
-- user_zalo_id: ID hồ sơ Zalo của ứng dụng, NULL cho tài khoản không dùng Zalo.
-- VARCHAR(64), UNIQUE: một Zalo ID chỉ có một tài khoản; nhiều NULL được phép.
SET @has_zalo_column = (SELECT COUNT(*) FROM information_schema.COLUMNS
  WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'hicrm_users' AND COLUMN_NAME = 'user_zalo_id');
SET @ddl = IF(@has_zalo_column = 0,
  'ALTER TABLE hicrm_users ADD COLUMN user_zalo_id VARCHAR(64) CHARACTER SET ascii COLLATE ascii_bin NULL DEFAULT NULL COMMENT ''ID Zalo Social khách hàng''', 'SELECT 1');
PREPARE zalo_migration FROM @ddl;
EXECUTE zalo_migration;
DEALLOCATE PREPARE zalo_migration;
SET @has_zalo_unique = (SELECT COUNT(*) FROM (
  SELECT INDEX_NAME FROM information_schema.STATISTICS
  WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'hicrm_users' AND NON_UNIQUE = 0
  GROUP BY INDEX_NAME HAVING COUNT(*) = 1 AND MAX(COLUMN_NAME) = 'user_zalo_id'
) AS unique_indexes);
SET @ddl = IF(@has_zalo_unique = 0,
  'ALTER TABLE hicrm_users ADD UNIQUE KEY uq_hicrm_users_zalo_id (user_zalo_id)', 'SELECT 1');
PREPARE zalo_migration FROM @ddl;
EXECUTE zalo_migration;
DEALLOCATE PREPARE zalo_migration;
