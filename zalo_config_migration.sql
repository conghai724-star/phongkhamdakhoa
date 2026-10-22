-- Cấu hình Zalo trong bảng key/value có sẵn. Không thêm table hoặc column.
-- Giữ nguyên các giá trị đã cấu hình. App Secret chỉ dùng phía máy chủ.
INSERT INTO hicrm_configs (config_key, config_value)
SELECT 'zalo_app_id', '' WHERE NOT EXISTS (SELECT 1 FROM hicrm_configs WHERE config_key = 'zalo_app_id');
INSERT INTO hicrm_configs (config_key, config_value)
SELECT 'zalo_app_secret', '' WHERE NOT EXISTS (SELECT 1 FROM hicrm_configs WHERE config_key = 'zalo_app_secret');
INSERT INTO hicrm_configs (config_key, config_value)
SELECT 'zalo_callback_url', '' WHERE NOT EXISTS (SELECT 1 FROM hicrm_configs WHERE config_key = 'zalo_callback_url');
