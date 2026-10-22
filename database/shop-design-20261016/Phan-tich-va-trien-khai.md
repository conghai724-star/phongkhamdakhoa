# Phân tích yêu cầu và phương án triển khai database

Ngày khảo sát: **16/10/2026**. Nguồn: `Bang-mo-ta-chuc-nang.xlsx`, sheet **Việc cần làm**, **A1:C23**. Sheet có 46 dòng định dạng, 23 dòng có nội dung, gồm tiêu đề và **22 hạng mục**. STT 3 lặp, một số STT bị nhảy; dùng số dòng Excel để đối chiếu.

## 1. Kết quả đề xuất

**11 bảng mới, bổ sung 4 bảng hiện có, không có FOREIGN KEY vật lý.** Tất cả tên bảng mới bắt đầu bằng `hicrm_`. Database đích là **phongkha697b_phongkhamcdkontum**, đang phục vụ website; không cần tạo thêm một database rời. Trong AGENTS.md có tên care_ioc nhưng URL được cấp quyền và cấu hình thực tế chỉ tới database trên; khảo sát chỉ đọc database tương ứng URL/cấu hình.

| Bảng mới | Một dòng dữ liệu đại diện cho |
|---|---|
| hicrm_shop_orders | Một đơn bán hàng online |
| hicrm_shop_order_items | Một SKU/đơn vị bán trong đơn |
| hicrm_shop_payments | Một lần thử thanh toán hoặc khoản thu xác định, chung MoMo/VNPAY/ZaloPay/bank/COD/cash |
| hicrm_shop_refunds | Một yêu cầu hủy, trả hoặc hoàn tiền |
| hicrm_stock_lots | Tồn một SKU cơ sở tại một kho, một lô |
| hicrm_stock_movements | Một biến động nhập/xuất/giữ/nhả/điều chỉnh trên lô |
| hicrm_loyalty_entries | Một lần cộng/trừ/giữ/nhả/hết hạn điểm |
| hicrm_offer_uses | Một lượt dùng voucher hoặc chương trình khuyến mãi trên đơn |
| hicrm_product_reviews | Một đánh giá/bình luận và phản hồi nhà thuốc |
| hicrm_integration_jobs | Một tác vụ gửi Zalo OA/SMS hoặc đồng bộ kho |
| hicrm_audit_logs | Một sự kiện nghiệp vụ quan trọng hoặc callback đã xác minh |

4 bảng mở rộng: `hicrm_users`, `hicrm_products`, `hicrm_vouchers`, `hicrm_promotions`. Các cột, kiểu, mặc định, NULL/NOT NULL, UNIQUE/index/CHECK đều được liệt kê đầy đủ ở **Tu-dien-du-lieu.md**; SQL có COMMENT tiếng Việt trên từng cột.

Không tạo riêng bảng phương thức thanh toán, trạng thái, hạng thành viên, địa chỉ, cấu hình, kênh gửi, phản hồi đánh giá hay báo cáo ngày. Những dữ liệu có lịch sử và tăng nhiều như dòng hàng/thu tiền/hoàn/kho/điểm vẫn tách để truy vấn, kiểm soát đồng thời và đối soát.

**Trạng thái:** đã chuẩn bị SQL khởi tạo để duyệt; **chưa chạy CREATE/ALTER/INSERT/UPDATE trên database**. AGENTS.md quy định: “Không tự ý tạo thêm table trong database… phải trình bày rõ mục đích, tên table và danh sách đầy đủ các cột”; “Chỉ được thực hiện lệnh tạo table sau khi người dùng cho phép rõ ràng.” Vì vậy cần duyệt thiết kế cụ thể này trước khi thực thi.

## 2. Hiện trạng đã xác minh từ metadata và luồng code

- Phiên bản server **MariaDB 10.4.21**. Thiết kế dùng cú pháp tương ứng, không khẳng định SQL chạy nguyên văn trên MySQL 5.7/8.
- `hicrm_users` hiện là **MyISAM**. START TRANSACTION không bảo vệ cập nhật điểm trên bảng này; phải chuyển InnoDB trước khi cho phép giao dịch đồng thời.
- Đơn online hiện do `apiController::checkoutCart` ghi vào `booking_internal`, sản phẩm nằm trong `medicines` LONGTEXT. Bảng thiếu mã đơn duy nhất, các trạng thái đơn/tiền/giao nhận và mã giao dịch.
- Luồng checkout hiện trừ **và cộng điểm ngay khi tạo đơn**, trái yêu cầu Excel chỉ cộng khi hoàn tất và đã trả đủ. Thêm bảng không tự sửa được logic này; phải chuyển code khi triển khai.
- `hicrm_orders/order_details` là luồng CRM đang có, cấu trúc và ý nghĩa khác đơn online. Không đổi ý nghĩa bảng cũ hoặc nhập hai nguồn đơn vào nhau bằng id trùng. Bảng `hicrm_shop_orders/items` là nguồn đơn web mới sau khi chuyển ứng dụng; `legacy_booking_id` dùng mapping chống chuyển lặp.
- Đã có products, product_categories, units, warehouses, vouchers, promotions, configs và hệ phân quyền. Không tạo lại.
- Có **product_code trùng `etc-tm-02`**. Chưa ép UNIQUE mã sản phẩm; cần chuẩn hóa/duyệt mapping trước nếu muốn mã duy nhất.
- `hicrm_product_warehouses` có tổng tồn nhưng chưa có lô/hạn/giữ/lịch sử. Sau chuyển đổi, **stock_lots là nguồn tồn chuẩn**, bảng tổng tồn cũ chỉ là cache đồng bộ cho CRM cũ nếu còn dùng. Không cho hai màn hình sửa độc lập hai nguồn.
- Người đăng nhập web hiện dùng `hicrm_users`, hồ sơ `hicrm_customers` là nguồn CRM riêng. Chưa đủ mapping để gộp; không coi cùng id là cùng khách.
- Code Zalo kiểm tra `user_zalo_id`, nhưng schema khảo sát chưa có cột đó. Cần migration xác thực riêng nếu triển khai Zalo thực tế; bộ thiết kế bán hàng không tự thêm hệ thống OAuth ngoài yêu cầu.

## 3. Ánh xạ toàn bộ chức năng

| Dòng Excel | Nội dung | Thiết kế tương ứng |
|---|---|---|
| 2 | MoMo | shop_payments provider=momo; request/external ID, số tiền, kết quả, hạn; audit chống callback trùng |
| 3 | VNPAY | Cùng bảng payments, provider=vnpay; UNIQUE request và transaction; đối soát |
| 4 | ZaloPay | Cùng bảng payments, provider=zalopay; xác minh backend và cập nhật trạng thái |
| 5 | Chuyển khoản | payments bank, chứng từ/nhân viên xác nhận; QR/thông tin ngân hàng ở configs. Tự động báo có là phạm vi cần chốt |
| 6 | COD/thu tại nhà thuốc | payments cod/cash; tách khách đã trả và đơn vị vận chuyển đã chuyển tiền về |
| 7 | Trang chủ, sản phẩm mới, tự động/thủ công | products created_time, is_featured, display_order; configs homepage mode, danh mục ưu tiên, số lượng |
| 8 | Danh mục thuốc | product_categories + products, index danh mục/trạng thái |
| 9 | Giỏ hàng/đặt hàng/giao/nhận/voucher/điểm | Giỏ chưa đặt giữ session hiện có; orders/items lưu bền vững; giữ kho/điểm/lượt ưu đãi trong transaction |
| 10 | Đăng ký/đăng nhập thành viên | users hiện có; hồ sơ/địa chỉ mở rộng, điểm và voucher dùng ledger, không tạo tài khoản song song |
| 11 | Trang cảm ơn | Đọc mã đơn/tổng/trạng thái/points_expected; không cộng điểm vì người dùng mở trang |
| 12 | Thông báo Bộ Công Thương | Chưa có mô tả; dự kiến cấu hình URL/trạng thái hiển thị. Thủ tục đăng ký ngoài phạm vi database |
| 13 | Thông báo đơn mới Zalo OA | integration_jobs outbox; nội dung template/đối tượng nhận trong cấu hình. Khả năng gửi nhóm OA phải xác nhận API/quyền trước tích hợp |
| 14 | Chính sách hủy/trả/hoàn | refunds + payments + ledger kho/điểm/ưu đãi + audit; nội dung chính sách tái sử dụng CMS |
| 15 | Kho/biến thể/đơn vị/lô/hạn/giữ/đồng bộ | products mở rộng; stock_lots/movements; warehouses/units hiện có. Kết nối phần mềm ngoài tùy chọn |
| 16 | Khách hàng/địa chỉ/lịch sử/phân nhóm/chăm sóc/quyền | users + customer_profile + tier; lịch sử từ orders; audit thay đổi/xuất; phân quyền hiện có |
| 17 | Quản lý đơn/in phiếu/lịch sử | orders/items, audit; ba trạng thái độc lập cho đơn/tiền/giao nhận |
| 18 | Doanh thu/tiền thu/hoàn/COD/báo cáo/xuất | orders/items/payments/refunds, index thời gian/khách/sản phẩm/kênh; xuất tại ứng dụng theo quyền |
| 19 | Voucher/điều kiện/giới hạn/lịch sử | vouchers mở rộng + offer_uses; lượt giữ/dùng/trả, kiểm tra tổng và theo khách |
| 20 | Điểm/hạng/hạn/điều chỉnh | users cache số dư + loyalty_entries theo lô + configs quy tắc hạng |
| 21 | Khuyến mãi/ưu tiên/kết hợp/báo cáo | promotions mở rộng; offer_uses, snapshot dòng hàng |
| 22 | Đánh giá/bình luận/ảnh/đã mua/duyệt | product_reviews; cache tổng sao/số lượt ở products; audit kiểm duyệt |
| 23 | SMS Brandname | Chưa có mô tả; dự kiến integration_jobs channel=sms. Chưa bao gồm marketing hàng loạt hoặc tính phí tự động |

## 4. Bảng hiện có tái sử dụng

| Bảng | Một dòng là gì | Cột dùng và ý nghĩa |
|---|---|---|
| hicrm_users | Tài khoản theo mô hình hiện tại | id định danh; user_username/email/phone đăng nhập/liên hệ; user_password hash; user_fullname/avatar/address hồ sơ; user_status trạng thái; user_group vai trò; loyalty_points số dư; user_register_time ngày tham gia. Các cột lương/hoa hồng giữ nguyên |
| hicrm_products | SKU/đơn vị bán | id; product_code mã; product_name/spec tên/quy cách; product_unit đơn vị; product_category danh mục; product_price giá; product_discount ưu đãi cũ; image/description; status; created_time. Không đoán discount cũ là % hay tiền khi chưa đối chiếu code |
| hicrm_product_categories | Danh mục | id; category_name; category_parent; description/icon/image; category_status |
| hicrm_units | Đơn vị bán | id; unit_code/name; unit_status |
| hicrm_warehouses | Kho/điểm nhận | id; warehouse_code/name; warehouse_branch_id; warehouse_status |
| hicrm_vouchers | Một mã giảm giá | id; code UNIQUE; discount_type fixed/percent; discount_value; max_discount; min_order_value; usage_limit; used_count; per_user_limit; start_at/end_at; is_active |
| hicrm_promotions | Một chương trình | id; promo_code/name; discount_type/value; promo_from/to; promo_status; order_min/max; products/customers. Ý nghĩa giới hạn cũ phải thống nhất trước chuyển |
| hicrm_configs | Một khóa cấu hình | id; config_key; config_value TEXT. config_key hiện chưa UNIQUE: kiểm tra và dọn khóa trùng trước migration cấu hình riêng |
| hicrm_permissions, permission_datas, user_groups | Quyền/nhóm quyền đang có | Tái sử dụng cơ chế hiện tại, chưa tạo hệ quyền mới |
| hicrm_introduce, templates | Nội dung CMS | Tái sử dụng tuyến hiện có để hiển thị chính sách, không cần bảng chính sách mới |

Cấu hình đề xuất, **chưa INSERT**:

- `shop.homepage`: mode auto/manual, danh mục ưu tiên, số lượng hiển thị.
- `shop.shipping`: phí và điều kiện miễn giao.
- `shop.loyalty`: tỷ lệ tích/đổi, hạn điểm, hạng/ngưỡng, cách làm tròn.
- `shop.discount_policy`: thứ tự và cách kết hợp ưu đãi.
- `shop.order_policy`: hạn giữ hàng/thanh toán, định nghĩa hoàn tất.
- `shop.payment_public`: ngân hàng, số tài khoản, tên nhận, mẫu nội dung chuyển khoản.
- `shop.notifications`: template/đích nhận và bật tắt SMS.
- `shop.commerce_notice`: URL/thông tin hiển thị đã được duyệt.

API secret, mật khẩu, access token lấy từ biến môi trường/kho bí mật; không đưa vào SQL hoặc JSON công khai. Bảng cũ còn charset utf8 ba byte: nếu cần emoji/tên ký tự ngoài BMP cần kế hoạch chuyển utf8mb4 riêng có sao lưu, không tự đổi toàn bộ bảng trong migration này.

## 5. Luồng xử lý nhất quán khi không dùng khóa ngoại

### Đặt hàng và tài nguyên

Backend kiểm tra CSRF/quyền, dữ liệu nhận hàng, SKU/đơn vị còn bán và điều kiện ưu đãi. Đọc giá tại server. Khóa SKU cơ sở, lô FEFO, tài khoản và ưu đãi theo một thứ tự nhất quán giữa các luồng. Trong cùng transaction: tạo order/items; giữ tồn/điểm/lượt ưu đãi; ghi ledger và job thông báo; COMMIT rồi mới phản hồi thành công. Request trùng checkout_key trả lại đơn gốc, không giữ tài nguyên lần hai. Hạn giữ tồn/điểm/voucher cùng expires_at. Deadlock retry có giới hạn và cùng khóa idempotency.

Sau COMMIT mới gọi API cổng thanh toán để tránh giữ khóa khi chờ mạng. Mỗi request_code/idempotency_key chỉ tạo một lần thử. Timeout phải tra cứu yêu cầu cũ trước tạo yêu cầu mới.

### Xác nhận tiền và COD

Callback phải xác minh chữ ký, môi trường, mã yêu cầu, đơn, currency/số tiền. Khóa đơn → payment theo thứ tự cố định, ghi event_key duy nhất và cập nhật tiền trong cùng transaction. Callback lặp đã xử lý trả ACK, không cộng tiền/điểm lại. pending/failed đến trễ không được ghi đè succeeded. Redirect từ trình duyệt không phải bằng chứng thanh toán.

Tiền tới sau khi đơn đã hủy/hết hạn chuyển đối soát xử lý, không tự mở lại đơn và chiếm tồn đã nhả. COD khách trả tiền làm khoản thu succeeded nhưng settlement có thể pending; lúc hãng chuyển tiền về chỉ cập nhật đối soát, không cộng paid_amount lần hai. COD chênh lệch chuyển disputed, lưu bằng chứng vào audit.

### Kho và điểm

Xuất kho ghi issue, giảm đồng thời tồn vật lý và lượng giữ. Hủy trước xuất ghi release chỉ giảm giữ. Hàng trả kiểm tra rồi mới nhập lô bán được, hoặc quarantine/blocked. Không tự tăng tồn chỉ vì đã hoàn tiền.

Chỉ khi đơn completed và đã trả đủ mới earn điểm thưởng với khóa duy nhất theo đơn. users.loyalty_points và ledger cùng transaction. Giữ 5 điểm: available -5/reserved +5; tiêu: reserved -5; nhả: reserved -5/available +5 nếu lô gốc còn hạn. Không trừ available hai lần.

Worker hết hạn điểm khóa user và lô remaining_points, ghi expire phần chưa dùng. Giữ/nhả phải ghi allocations, không hồi sinh điểm hết hạn hoặc vừa expire vừa tiêu cùng điểm. Thu hồi điểm thưởng đã tiêu có thể gây nợ điểm; không cho đổi tiếp khi âm. Quy tắc bù nợ khi earn mới phải được thống nhất.

### Voucher, hoàn tiền và lịch sử

Lượt reserved chiếm hạn mức tổng/theo khách ngay khi đặt. Lock ưu đãi trước kiểm tra used + reserved, tính giới hạn theo khách qua offer_uses trong cùng transaction. released không tính lượt. Hủy/hoàn trả lượt theo chính sách và cập nhật cache đúng một lần. Người chưa xác thực có thể đổi SĐT, database không thể tự bảo đảm chống lạm dụng.

Duyệt hoàn phải lock order/payment và tính tổng refund approved/processing/succeeded; không vượt tiền còn hoàn của cả đơn và payment. Giữ hạn mức ngay lúc duyệt, không chờ callback. Timeout hoàn tiền phải tra cứu trước retry. Chỉ succeeded tăng refunded_amount. Kiểm tra số lượng trả và tiền phân bổ theo dòng, không cho nhiều yêu cầu cùng hoàn một mặt hàng quá số mua. Mỗi cập nhật điểm/tồn/voucher có khóa đảo riêng, không xóa lịch sử.

Không có FK vẫn phải kiểm tra ID tồn tại, quyền sở hữu và trạng thái trước lưu. Không xóa cứng bản ghi có lịch sử. Chạy kiểm tra dòng mồ côi và đối chiếu cache định kỳ. CHECK trong DDL không thay được ràng buộc liên bảng.

### Outbox và quyền

Worker nhận lease bằng transaction ngắn/cập nhật có điều kiện tương thích MariaDB 10.4, không dựa vào SKIP LOCKED phiên bản mới. Chỉ worker_token hiện tại được đánh dấu sent. Retry giãn thời gian, hết lượt chuyển failed. dedupe_key chống xếp job trùng, **không bảo đảm gửi đúng một lần qua mạng** nếu nhà cung cấp thiếu idempotency/tra cứu sau timeout.

Phân quyền xem/sửa/xuất hồ sơ, ghi chú nội bộ, đối soát/hoàn tiền ở API theo cơ chế hiện hữu. Nhật ký không chứa password/token hoặc toàn bộ payload cá nhân. Xem đơn phải xác minh chủ đơn; khách vãng lai cần token truy cập ký có hạn hoặc xác thực, không chỉ nhập mã đơn rồi xem toàn bộ SĐT/địa chỉ.

## 6. Tối ưu tốc độ có căn cứ

- Mã đơn/request/giao dịch ngoài/idempotency dùng UNIQUE. Index mới bám danh sách đơn theo status/payment/time, lịch sử khách, báo cáo SKU, lô FEFO và hàng đợi job.
- Phân trang con trỏ theo `(created_at,id)` thay OFFSET sâu. Chỉ SELECT cột cần, tránh đọc JSON/TEXT trên danh sách.
- Thời gian lọc `>= :from AND < :to`, không bọc DATE(column) trong WHERE. Không tạo mọi tổ hợp index bộ lọc; khi dữ liệu thật cho thấy tổ hợp truy vấn chậm mới thêm composite sau EXPLAIN.
- Báo cáo SKU dùng order_items có product_id/order_id; số dư/tổng đơn/điểm đánh giá dùng cache cột thường và đối chiếu ledger. JSON chỉ dành cho snapshot, điều kiện nhỏ, địa chỉ ít thay đổi. MariaDB JSON không mặc nhiên nhanh hoặc có index như cột thường.
- SĐT chuẩn hóa tra equality/prefix; tìm tên `%keyword%` không được B-tree tối ưu. Chỉ bổ sung FULLTEXT/dịch vụ tìm kiếm sau khi đo nhu cầu.
- Cache báo cáo 1–5 phút tùy nghiệp vụ, chưa tạo bảng doanh thu theo ngày vì chưa chốt quy tắc ghi nhận và tải. Dữ liệu tiền thực thu/hoàn vẫn đọc từ giao dịch, không lấy cache đơn thay sổ tiền.
- stock_lots là nguồn tồn chuẩn; bảng tồn cũ nếu cần chỉ là cache một chiều. Điều kiện còn hạn + active + lượng khả dụng phải được kiểm tra lại dưới lock khi giữ.
- Không gửi OA/SMS trong transaction đặt hàng. Hạn chế worker/retry, archive dữ liệu tích hợp/audit theo chính sách được duyệt; không tùy tiện xóa chứng từ tiền.
- JSON scope nếu tăng tới hàng chục nghìn ID hoặc cần tìm nhóm/địa chỉ toàn hệ thống thường xuyên thì cần cột/bảng liên kết phù hợp. Không cố giữ ít bảng làm chậm truy vấn thực tế.

**Chưa benchmark/EXPLAIN trên bảng mới** do chưa tạo và chưa có dữ liệu đại diện. Ít FK không tự động làm mọi truy vấn nhanh; index, dung lượng, cách truy vấn và khóa đồng thời mới là các yếu tố cần đo.

## 7. Báo cáo và giả định cần duyệt

| Chỉ tiêu | Nguồn và cách hiểu |
|---|---|
| Giá trị đơn | orders.total_amount; không cộng cả subtotal và line_amount gây trùng |
| Giá trị hàng sau giảm | subtotal - voucher_discount - points_discount; tách shipping_fee |
| Doanh thu đề xuất | Giá trị hàng đơn completed, ghi theo completed_at; trừ goods_amount hoàn thành công theo completed_at của refund. Cần kế toán duyệt, chưa coi là quy tắc kế toán chính thức |
| Tiền khách đã trả | SUM(payment.amount) với succeeded theo paid_at; không gồm pending/chuyển khoản chưa xác nhận |
| Tiền ròng đã về | Tiền gộp đã settled trừ fee_amount và khoản hoàn đã thực chi. Cash/bank trực tiếp phải ghi settled cùng lúc xác nhận; cổng/COD chờ đối soát ghi riêng |
| COD chờ đối soát | amount - settled_amount của COD succeeded chưa đối soát đủ |
| Hoàn tiền | Chỉ refund succeeded, không tính requested/approved như tiền đã chi |

Cần chốt trước vận hành:

1. Giá đã gồm VAT, một tiền tệ VND; nếu giá chưa thuế/hóa đơn nhiều mức thuế cần chỉnh công thức và snapshot trước triển khai.
2. Thứ tự giảm: khuyến mãi sản phẩm → voucher → điểm là đề xuất, không phải yêu cầu đã được xác nhận. Phân bổ giảm theo dòng, làm tròn bù ở dòng cuối, hoàn không vượt tiền thực trả của phần hàng.
3. Code cũ đang dùng 1 điểm = 1.000đ, 10.000đ thực trả = 1 điểm; chưa coi là quy tắc mới. Chốt tỷ lệ, hạn, hạng, earn trên tiền hàng hay gồm phí giao, hoàn/điểm hết hạn/nợ điểm.
4. Thời gian giữ hàng/thanh toán, thời điểm xuất kho, tiêu điểm và trả lượt; COD được earn khi khách đã trả nhưng hãng chưa chuyển về hay đợi đối soát đủ.
5. Biến thể/đóng gói: mỗi SKU là một dòng products, base_product_id/factor quy về SKU cơ sở. Không quy đổi vòng. Danh sách bắt buộc lô/hạn, quy trình duyệt đơn thuốc và kho ngoài cần mô tả thêm.
6. Bộ Công Thương và SMS thiếu mô tả; Zalo OA gửi vào nhóm phải kiểm tra API/quyền. Bộ schema chỉ dự phòng cấu hình/outbox, không cam kết khả năng dịch vụ.
7. Chưa yêu cầu giỏ hàng dùng lại giữa thiết bị, nên tiếp tục session, không tạo carts/cart_items. Không có bảng OAuth mới trong phạm vi này.

## 8. Triển khai sau khi duyệt

1. Sao lưu schema/dữ liệu; chốt nguồn đơn/tồn/điểm và bảo trì thao tác ghi khi đổi engine. Kiểm tra giá trị số dư/đếm dòng trước sau.
2. Đối chiếu schema, chạy `01_create_shop_tables.sql` rồi `02_extend_existing_tables.sql`. File 01 không IF NOT EXISTS để tránh bỏ qua bảng khác cấu trúc; file 02 có IF NOT EXISTS chỉ là hỗ trợ chạy lại, không thay kiểm tra metadata. DDL tự COMMIT, không trông chờ rollback bằng START TRANSACTION.
3. Cập nhật checkout, callback, admin, job theo mô hình mới. **SQL chưa tự thay luồng code đang chạy.** Không bật tiền/kho/điểm khi logic vẫn dùng hai nguồn độc lập.
4. Chuyển đơn cũ riêng theo legacy_booking_id duy nhất. medicines hiện không có product_id đáng tin cậy: ánh xạ thủ công/có kiểm tra, không đoán tên trùng. Không tự đánh dấu đơn cũ paid/completed.
5. Điểm cũ chỉ có số dư, không khôi phục được lịch sử chính xác. Đối chiếu rồi tạo opening entries, không tự thưởng lại theo đơn cũ. Kho chỉ tạo opening sau kiểm kê, không tự gán lô/hạn hay số tồn giả.
6. Kiểm tra đặt trùng, mua đồng thời sát hết tồn, voucher sát hạn mức; callback lặp/đảo thứ tự/sai tiền/đến sau hết hạn; hủy giải phóng; hoàn đồng thời/partial; điểm hết hạn/đã tiêu; hàng trả không đủ điều kiện; job timeout/retry.
7. EXPLAIN dữ liệu đại diện, đo trang danh sách/báo cáo và lock timeout/deadlock. Đối soát tổng dòng đơn, khoản thu, hoàn, cache điểm, tổng giữ và tồn vật lý.

Không chạy CREATE/ALTER để thử cú pháp trên database đang dùng khi chưa duyệt. Các kiểm tra ở giai đoạn này chỉ là kiểm tra tĩnh cấu trúc file, tên/cột/index và đối chiếu metadata/code thực tế.
