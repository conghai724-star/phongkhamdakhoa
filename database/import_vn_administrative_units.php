<?php
/**
 * Import danh mục hành chính Việt Nam theo mô hình 2 cấp.
 * Chạy: C:\xampp\php\php.exe database\import_vn_administrative_units.php
 * Nguồn dữ liệu: https://github.com/ThangLeQuoc/vietnamese-provinces-database
 */

if(PHP_SAPI !== 'cli'){
	http_response_code(404);
	exit;
}

ini_set('session.save_path', sys_get_temp_dir());
require dirname(__DIR__).'/config.php';

$sourceFile = dirname(__DIR__).'/vn_administrative_units.json';
if(!is_file($sourceFile)){
	fwrite(STDERR, "Không tìm thấy file dữ liệu vn_administrative_units.json.\n");
	exit(1);
}

$provinces = json_decode(file_get_contents($sourceFile), true);
if(!is_array($provinces)){
	fwrite(STDERR, "File dữ liệu hành chính không đúng định dạng JSON.\n");
	exit(1);
}

$wardCount = 0;
foreach($provinces as $province){
	$wardCount += isset($province['Wards']) && is_array($province['Wards']) ? count($province['Wards']) : 0;
}
if(count($provinces) !== 34 || $wardCount !== 3321){
	fwrite(STDERR, "Dữ liệu không đầy đủ: cần 34 tỉnh/thành và 3.321 xã/phường.\n");
	exit(1);
}

$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if($mysqli->connect_errno){
	fwrite(STDERR, "Không thể kết nối database.\n");
	exit(1);
}
$mysqli->set_charset('utf8mb4');

$createSql = "CREATE TABLE IF NOT EXISTS hicrm_administrative_units (
	id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	province_code CHAR(2) CHARACTER SET ascii COLLATE ascii_bin NOT NULL COMMENT 'Mã tỉnh/thành chính thức',
	province_name VARCHAR(100) NOT NULL COMMENT 'Tên tỉnh/thành không gồm loại đơn vị',
	province_full_name VARCHAR(150) NOT NULL COMMENT 'Tên đầy đủ Tỉnh/Thành phố',
	ward_code CHAR(5) CHARACTER SET ascii COLLATE ascii_bin NOT NULL COMMENT 'Mã xã/phường chính thức',
	ward_name VARCHAR(150) NOT NULL COMMENT 'Tên xã/phường không gồm loại đơn vị',
	ward_full_name VARCHAR(180) NOT NULL COMMENT 'Tên đầy đủ Xã/Phường/Đặc khu',
	ward_type VARCHAR(20) NOT NULL COMMENT 'phuong, xa hoặc dac_khu',
	postal_code CHAR(5) CHARACTER SET ascii COLLATE ascii_bin DEFAULT NULL COMMENT 'Mã bưu chính',
	created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (id),
	UNIQUE KEY uk_administrative_ward_code (ward_code),
	KEY idx_administrative_province (province_code),
	KEY idx_administrative_province_ward (province_code, ward_name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Danh mục hành chính Việt Nam 2 cấp'";

if(!$mysqli->query($createSql)){
	fwrite(STDERR, "Không thể tạo bảng dữ liệu hành chính.\n");
	exit(1);
}

$stmt = $mysqli->prepare("INSERT INTO hicrm_administrative_units
	(province_code, province_name, province_full_name, ward_code, ward_name, ward_full_name, ward_type, postal_code)
	VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
if(!$stmt){
	fwrite(STDERR, "Không thể chuẩn bị câu lệnh import.\n");
	exit(1);
}

$mysqli->begin_transaction();
try {
	if(!$mysqli->query("DELETE FROM hicrm_administrative_units")){
		throw new Exception('Không thể làm sạch dữ liệu hành chính cũ.');
	}

	$inserted = 0;
	foreach($provinces as $province){
		$provinceCode = str_pad((string)$province['Code'], 2, '0', STR_PAD_LEFT);
		$provinceFullName = trim((string)$province['FullName']);
		$provinceName = preg_replace('/^(Tỉnh|Thành phố)\s+/u', '', $provinceFullName);

		foreach($province['Wards'] as $ward){
			$wardCode = str_pad((string)$ward['Code'], 5, '0', STR_PAD_LEFT);
			$wardFullName = trim((string)$ward['FullName']);
			$wardName = preg_replace('/^(Phường|Xã|Đặc khu)\s+/u', '', $wardFullName);
			$wardType = preg_match('/^Phường\s/u', $wardFullName) ? 'phuong'
				: (preg_match('/^Đặc khu\s/u', $wardFullName) ? 'dac_khu' : 'xa');
			$postalCode = !empty($ward['PostalCode']) ? str_pad((string)$ward['PostalCode'], 5, '0', STR_PAD_LEFT) : null;

			$stmt->bind_param('ssssssss', $provinceCode, $provinceName, $provinceFullName, $wardCode, $wardName, $wardFullName, $wardType, $postalCode);
			if(!$stmt->execute()){
				throw new Exception('Không thể import đơn vị mã '.$wardCode.'.');
			}
			$inserted++;
		}
	}

	$mysqli->commit();
	echo "Đã import ".count($provinces)." tỉnh/thành và ".$inserted." xã/phường.\n";
} catch(Throwable $exception) {
	$mysqli->rollback();
	fwrite(STDERR, $exception->getMessage()."\n");
	exit(1);
}

$stmt->close();
$mysqli->close();
