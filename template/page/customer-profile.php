<?php include 'header_new.php'; ?>
</section>

<style>
/* CSS cho Modal chọn địa chỉ hành chính 2 cấp */
.lc-modal {
  position: fixed;
  inset: 0;
  background: rgba(15, 23, 42, 0.55);
  backdrop-filter: blur(4px);
  -webkit-backdrop-filter: blur(4px);
  z-index: 100000;
  display: none;
  align-items: center;
  justify-content: center;
  padding: 14px;
}
.lc-modal.active { display: flex !important; }
.lc-modal-content {
  background: #ffffff;
  border-radius: 16px;
  width: 100%;
  max-width: 480px;
  max-height: 85vh;
  display: flex;
  flex-direction: column;
  overflow: hidden;
  box-shadow: 0 20px 45px -10px rgba(15, 23, 42, 0.25);
  animation: pkModalSlideIn 0.25s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}
@keyframes pkModalSlideIn {
  from { opacity: 0; transform: scale(0.95) translateY(10px); }
  to { opacity: 1; transform: scale(1) translateY(0); }
}

/* Nút chọn địa chỉ */
.addr-select-btn {
  width: 100%;
  box-sizing: border-box;
  padding: 12px 14px;
  border: 1.5px solid #cbd5e1;
  background: #f8fafc;
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  cursor: pointer;
  font-size: 14.5px;
  color: #1e293b;
  transition: all 0.2s ease;
  user-select: none;
}
.addr-select-btn:hover {
  border-color: #13467d;
  background: #ffffff;
}
.gps-quick-btn {
  height: 45px;
  border: 1.5px solid #bfdbfe;
  background: #eff6ff;
  color: #13467d;
  border-radius: 10px;
  padding: 0 14px;
  display: inline-flex;
  align-items: center;
  gap: 6px;
  font-size: 13.5px;
  font-weight: 700;
  cursor: pointer;
  white-space: nowrap;
  transition: all 0.2s ease;
  flex-shrink: 0;
}
.gps-quick-btn:hover {
  background: #dbeafe;
  border-color: #93c5fd;
}
.addr-item-row {
  padding: 11px 12px;
  border-bottom: 1px solid #f1f5f9;
  cursor: pointer;
  font-size: 13.5px;
  color: #1e293b;
  transition: all 0.15s ease;
}
.addr-item-row:hover {
  background: #f0fdf4;
  color: #13467d;
  font-weight: 600;
  padding-left: 16px;
}
</style>

<div id="breadcrumbs">
   <div class="ctn">
      <div id="crumbs">
         <a href="<?php echo XC_URL; ?>"><i class="fa-solid fa-house"></i> Trang chủ</a> 
         <span>/</span> 
         <a class="current">Thông tin tài khoản</a>
      </div>
   </div>
</div>

<div class="ctn" style="margin-top: 24px; margin-bottom: 50px;">
   <div style="max-width: 580px; margin: 0 auto; background: #ffffff; border-radius: 16px; box-shadow: 0 10px 30px rgba(19, 70, 125, 0.08); border: 1px solid #e2e8f0; overflow: hidden;">
      
      <!-- Card Header -->
      <div style="background: linear-gradient(135deg, #13467d 0%, #1e5ba0 100%); padding: 28px 24px; text-align: center; color: #ffffff;">
         <div style="width: 76px; height: 76px; border-radius: 50%; background: #ffffff; margin: 0 auto 14px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(0,0,0,0.15); overflow: hidden; border: 3px solid rgba(255,255,255,0.85);">
            <?php if (!empty($_SESSION['customer']['avatar'])): ?>
               <img src="<?php echo htmlspecialchars($_SESSION['customer']['avatar'], ENT_QUOTES, 'UTF-8'); ?>" alt="Avatar" style="width: 100%; height: 100%; object-fit: cover;">
            <?php else: ?>
               <i class="fa-solid fa-user" style="font-size: 34px; color: #13467d;"></i>
            <?php endif; ?>
         </div>
         <h1 style="font-size: 20px; font-weight: 700; margin: 0 0 6px 0; color: #ffffff;">
            <?php echo htmlspecialchars($customer->user_fullname ?: ($_SESSION['customer']['fullname'] ?? 'Khách hàng'), ENT_QUOTES, 'UTF-8'); ?>
         </h1>
         <div style="display: inline-flex; align-items: center; gap: 6px; background: rgba(255,255,255,0.18); padding: 4px 12px; border-radius: 20px; font-size: 13px; font-weight: 500;">
            <?php 
               $provider = !empty($_SESSION['customer']['provider']) ? $_SESSION['customer']['provider'] : 'local';
               if ($provider === 'zalo'): ?>
                  <i class="fa-solid fa-comment-dots"></i> Đăng nhập qua Zalo
               <?php elseif ($provider === 'google'): ?>
                  <i class="fa-brands fa-google"></i> Đăng nhập qua Google
               <?php elseif ($provider === 'facebook'): ?>
                  <i class="fa-brands fa-facebook"></i> Đăng nhập qua Facebook
               <?php else: ?>
                  <i class="fa-solid fa-shield-check"></i> Tài khoản đã xác thực
               <?php endif; ?>
         </div>
         <div style="margin-top: 10px;">
            <span style="display: inline-flex; align-items: center; gap: 6px; background: rgba(255,255,255,0.92); color: #13467d; padding: 5px 14px; border-radius: 20px; font-size: 13.5px; font-weight: 700; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">
               <i class="fa-solid fa-coins" style="color: #f59e0b;"></i>
               Điểm tích lũy: <?php echo number_format((int)($customer->loyalty_points ?? 0), 0, ',', '.'); ?> điểm
            </span>
         </div>
      </div>

      <!-- Card Body -->
      <div style="padding: 28px 24px;">
         <div style="background: #f8fafc; border-left: 4px solid #13467d; padding: 12px 16px; border-radius: 6px; margin-bottom: 22px;">
            <p style="margin: 0; font-size: 13.5px; line-height: 1.5; color: #475569;">
               Quý khách vui lòng kiểm tra và cập nhật <strong>số điện thoại di động</strong> và <strong>địa chỉ nhận hàng</strong> để phòng khám liên hệ tư vấn kết quả khám và xác nhận đơn hàng khi cần.
            </p>
         </div>

         <form id="customer-profile-form" action="javascript:void(0);" method="post" style="display: flex; flex-direction: column; gap: 18px;">
            <!-- 1. Số điện thoại di động -->
            <div>
               <label for="customer-phone" style="display: block; font-weight: 600; font-size: 14px; margin-bottom: 6px; color: #1e293b;">
                  Số điện thoại di động <span style="color: #ef4444;">*</span>
               </label>
               <div style="position: relative;">
                  <span style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 15px;">
                     <i class="fa-solid fa-phone"></i>
                  </span>
                  <input id="customer-phone" name="phone" type="tel" required maxlength="20" autocomplete="tel" inputmode="tel" 
                     value="<?php echo htmlspecialchars((string)($customer->user_phone ?: ($_SESSION['customer']['phone'] ?? '')), ENT_QUOTES, 'UTF-8'); ?>" 
                     placeholder="Ví dụ: 0912345678"
                     style="width: 100%; box-sizing: border-box; padding: 11px 14px 11px 40px; border: 1.5px solid #cbd5e1; border-radius: 10px; font-size: 15px; font-weight: 600; color: #0f172a; outline: none; transition: all 0.2s ease;">
               </div>
               <span style="display: block; font-size: 12.5px; color: #64748b; margin-top: 5px;">
                  Nhập số điện thoại 10 chữ số (đầu số 03, 05, 07, 08, 09).
               </span>
            </div>

            <!-- 2. Khu vực Tỉnh / Xã nhận hàng -->
            <?php
               $savedAddr = !empty($customer->user_address) ? trim((string)$customer->user_address) : '';
               $savedProvince = '';
               $savedWard = '';
               $savedSpecific = '';
               if ($savedAddr !== '') {
                  $addrParts = array_values(array_filter(array_map('trim', explode(',', $savedAddr)), function ($p) {
                     return $p !== '';
                  }));
                  $partCount = count($addrParts);
                  if ($partCount >= 3) {
                     $savedProvince = array_pop($addrParts);
                     $savedWard = array_pop($addrParts);
                     $savedSpecific = implode(', ', $addrParts);
                  } elseif ($partCount === 2) {
                     if (preg_match('/^(Phường|Xã|Thị trấn|Đặc khu)\b/iu', $addrParts[0])) {
                        $savedWard = $addrParts[0];
                        $savedProvince = $addrParts[1];
                     } else {
                        $savedSpecific = $addrParts[0];
                        $savedProvince = $addrParts[1];
                     }
                  } elseif ($partCount === 1) {
                     if (preg_match('/^(Tỉnh|Thành phố|TP\.?|Phường|Xã|Thị trấn)\b/iu', $addrParts[0])) {
                        $savedProvince = $addrParts[0];
                     } else {
                        $savedSpecific = $addrParts[0];
                     }
                  }
               }
               $savedArea = implode(', ', array_filter(array($savedWard, $savedProvince), function ($v) {
                  return $v !== '';
               }));
            ?>
            <div>
               <label style="display: block; font-weight: 600; font-size: 14px; margin-bottom: 6px; color: #1e293b;">
                  Khu vực Tỉnh / Xã nhận hàng <span style="color: #ef4444;">*</span>
               </label>
               <div class="addr-select-btn" id="btnOpenAddressModal">
                  <div style="display: flex; align-items: center; gap: 10px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; flex: 1;">
                     <i class="fa-solid fa-location-dot" style="color: #13467d; font-size: 16px; flex-shrink: 0;"></i>
                     <span id="selectedAddressText" style="font-weight: 600; color: #0f172a; overflow: hidden; text-overflow: ellipsis;">
                        <?php echo $savedArea !== '' ? htmlspecialchars($savedArea, ENT_QUOTES, 'UTF-8') : 'Chọn Tỉnh/Thành phố, Xã/Phường'; ?>
                     </span>
                  </div>
                  <span style="color: #13467d; font-weight: 700; font-size: 12.5px; background: #e0f2fe; padding: 5px 12px; border-radius: 8px; flex-shrink: 0; margin-left: 8px;">
                     <i class="fa-solid fa-pen-to-square"></i> Đổi
                  </span>
               </div>
               <span style="display: block; font-size: 12.5px; color: #64748b; margin-top: 5px;">
                  Bấm vào khung trên để chọn Tỉnh/Thành phố và Xã/Phường theo danh mục hành chính.
               </span>
               <input type="hidden" id="provinceCode" name="province_code">
               <input type="hidden" id="provinceName" name="province_name" value="<?php echo htmlspecialchars($savedProvince, ENT_QUOTES, 'UTF-8'); ?>">
               <input type="hidden" id="wardCode" name="ward_code">
               <input type="hidden" id="wardName" name="ward_name" value="<?php echo htmlspecialchars($savedWard, ENT_QUOTES, 'UTF-8'); ?>">
            </div>

            <!-- 3. Địa chỉ chi tiết -->
            <div>
               <label for="specificAddress" style="display: block; font-weight: 600; font-size: 14px; margin-bottom: 6px; color: #1e293b;">
                  Địa chỉ chi tiết (Số nhà, tên đường, thôn/xóm)
               </label>
               <div style="display: flex; gap: 8px;">
                  <div style="position: relative; flex: 1;">
                     <span style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 15px;">
                        <i class="fa-solid fa-house-chimney"></i>
                     </span>
                     <input type="text" id="specificAddress" name="specific_address" 
                        value="<?php echo htmlspecialchars($savedSpecific, ENT_QUOTES, 'UTF-8'); ?>"
                        placeholder="Số nhà, ngõ, tên đường, thôn/xóm..." 
                        style="width: 100%; box-sizing: border-box; padding: 11px 14px 11px 40px; border: 1.5px solid #cbd5e1; border-radius: 10px; font-size: 14.5px; color: #0f172a; outline: none; transition: all 0.2s ease;">
                  </div>
                  <button type="button" class="gps-quick-btn" id="btnGetGps" title="Lấy vị trí hiện tại qua GPS">
                     <i id="gpsIcon" class="fa-solid fa-crosshairs"></i>
                     <span id="gpsBtnText">GPS</span>
                  </button>
               </div>
               <span style="display: block; font-size: 12.5px; color: #64748b; margin-top: 5px;">
                  Nhập số nhà, ngõ, thôn/xóm hoặc bấm nút GPS để tự động điền vị trí.
               </span>
            </div>

            <button id="save-customer-profile" type="submit" 
               style="background: #13467d; color: #ffffff; border: none; border-radius: 10px; padding: 13px 18px; font-size: 15px; font-weight: 600; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; box-shadow: 0 4px 12px rgba(19,70,125,0.25); transition: all 0.2s ease; margin-top: 6px;">
               <i class="fa-solid fa-floppy-disk"></i>
               <span>Lưu thông tin</span>
            </button>
         </form>

         <!-- Action Links -->
         <div style="margin-top: 24px; padding-top: 20px; border-top: 1px solid #f1f5f9; display: flex; flex-wrap: wrap; gap: 10px; justify-content: space-between; align-items: center;">
            <a href="<?php echo XC_URL; ?>" 
               style="color: #13467d; text-decoration: none; font-size: 14px; font-weight: 600; display: inline-flex; align-items: center; gap: 6px;">
               <i class="fa-solid fa-arrow-left"></i> Quay lại trang chủ
            </a>

            <div style="display: flex; gap: 14px; align-items: center;">
               <a href="<?php echo XC_URL; ?>/gio-hang.html" 
                  style="color: #475569; text-decoration: none; font-size: 14px; font-weight: 500; display: inline-flex; align-items: center; gap: 6px;">
                  <i class="fa-solid fa-cart-shopping"></i> Giỏ hàng
               </a>

               <button id="customer-logout" type="button" 
                  style="background: none; border: none; color: #ef4444; font-size: 14px; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; padding: 0;">
                  <i class="fa-solid fa-right-from-bracket"></i> Đăng xuất
               </button>
            </div>
         </div>
      </div>
   </div>
</div>

<!-- ================= MODAL CHỌN ĐỊA CHỈ NHẬN HÀNG (HÀNH CHÍNH 2 CẤP) ================= -->
<div id="addressModal" class="lc-modal">
  <div class="lc-modal-content">
    <div style="padding: 14px 18px; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; background: #ffffff;">
      <strong style="font-size: 15px; color: #13467d;">Chọn địa chỉ nhận hàng</strong>
      <button type="button" id="btnCloseAddressModal" style="border: none; background: transparent; font-size: 24px; cursor: pointer; color: #64748b; line-height: 1; padding: 0 4px;">&times;</button>
    </div>

    <div style="display: flex; border-bottom: 1px solid #e2e8f0; font-size: 13px; font-weight: 700; background: #ffffff;">
      <button type="button" id="stepTabProvince" style="flex: 1; padding: 12px 10px; border: none; background: transparent; border-bottom: 2px solid #13467d; color: #13467d; cursor: pointer; transition: all 0.2s;">
         1. Tỉnh / Thành phố
      </button>
      <button type="button" id="stepTabWard" style="flex: 1; padding: 12px 10px; border: none; background: transparent; color: #94a3b8; cursor: not-allowed; transition: all 0.2s;" disabled>
         2. Xã / Phường
      </button>
    </div>

    <div style="padding: 10px 14px; border-bottom: 1px solid #f1f5f9; background: #ffffff;">
      <input type="text" id="addressSearchInput" placeholder="Tìm kiếm nhanh..." 
         style="width: 100%; box-sizing: border-box; height: 38px; padding: 8px 12px; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 13.5px; outline: none;">
    </div>

    <div id="addressItemsContainer" style="flex: 1; overflow-y: auto; padding: 8px 14px; max-height: 52vh; background: #ffffff;"></div>
  </div>
</div>

</main>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
(function () {
    function initProfile() {
        if (typeof jQuery === 'undefined') {
            setTimeout(initProfile, 50);
            return;
        }
        var $ = jQuery;
        $(function () {
            var busy = false;
            var currentStep = 'province';
            var selectedProvince = { code: '', name: '' };
            var selectedWard = { code: '', name: '' };
            var administrativeItems = [];

            function toast(message, ok, focusElem) { 
                if (typeof Swal !== 'undefined' && Swal.fire) {
                    Swal.fire({
                        position: 'center', 
                        icon: ok ? 'success' : 'error', 
                        title: ok ? 'Thành công' : 'Thông báo',
                        text: message, 
                        showConfirmButton: !ok, 
                        confirmButtonText: 'Đã hiểu',
                        confirmButtonColor: '#13467d',
                        timer: ok ? 2000 : undefined, 
                        timerProgressBar: ok
                    }).then(function () {
                        if (!ok && focusElem) $(focusElem).focus();
                    });
                } else {
                    alert(message);
                    if (!ok && focusElem) $(focusElem).focus();
                }
            }

            // Mở modal địa chỉ
            function openAddressModal() {
                $('#addressModal').addClass('active');
                $('#addressSearchInput').val('');
                switchAddressStep('province');
            }

            // Đóng modal địa chỉ
            function closeAddressModal() {
                $('#addressModal').removeClass('active');
            }

            // Chuyển tab Tỉnh / Xã
            function switchAddressStep(step) {
                if (step === 'ward' && !selectedProvince.code) {
                    toast('Vui lòng chọn Tỉnh/Thành phố trước.', false);
                    return;
                }
                currentStep = step;
                var $tabP = $('#stepTabProvince');
                var $tabW = $('#stepTabWard');

                if (step === 'province') {
                    $tabP.css({ 'border-bottom': '2px solid #13467d', 'color': '#13467d' });
                    $tabW.css({ 'border-bottom': 'none', 'color': '#94a3b8' });
                } else {
                    $tabW.css({ 'border-bottom': '2px solid #13467d', 'color': '#13467d', 'cursor': 'pointer' }).prop('disabled', false);
                    $tabP.css({ 'border-bottom': 'none', 'color': '#64748b' });
                }
                $('#addressSearchInput').val('');
                loadAdministrativeItems(step);
            }

            // Tải danh mục hành chính từ máy chủ
            function loadAdministrativeItems(step) {
                var $container = $('#addressItemsContainer');
                $container.html('<p style="text-align: center; color: #64748b; font-size: 13px; padding: 24px 0;"><i class="fa-solid fa-spinner fa-spin"></i> Đang tải danh sách...</p>');
                
                $.ajax({
                    url: <?php echo json_encode(XC_URL . '/api/administrativeUnits'); ?>,
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        level: step,
                        province_code: step === 'ward' ? selectedProvince.code : ''
                    }
                }).done(function (res) {
                    if (!res.success || !Array.isArray(res.data)) {
                        administrativeItems = [];
                        $container.html('<p style="text-align: center; color: #dc2626; font-size: 13px; padding: 24px 0;">' + (res.message || 'Không thể tải danh mục hành chính.') + '</p>');
                        return;
                    }
                    if (currentStep !== step) return;
                    administrativeItems = res.data;
                    renderAddressItems('');
                }).fail(function () {
                    administrativeItems = [];
                    $container.html('<p style="text-align: center; color: #dc2626; font-size: 13px; padding: 24px 0;">Lỗi kết nối máy chủ. Vui lòng thử lại.</p>');
                });
            }

            // Hiển thị danh sách và lọc tìm kiếm
            function renderAddressItems(keyword) {
                var $container = $('#addressItemsContainer');
                var list = administrativeItems;
                var kw = $.trim(keyword || '').toLocaleLowerCase('vi');
                if (kw) {
                    list = list.filter(function (item) {
                        return (item.name || '').toLocaleLowerCase('vi').indexOf(kw) !== -1;
                    });
                }
                if (!list.length) {
                    $container.html('<p style="text-align: center; color: #94a3b8; font-size: 13px; padding: 24px 0;">Không tìm thấy kết quả phù hợp.</p>');
                    return;
                }
                var html = '';
                list.forEach(function (item) {
                    html += '<div class="addr-item-row js-select-addr-item" data-code="' + item.code + '" data-name="' + item.name + '">' +
                                item.name +
                            '</div>';
                });
                $container.html(html);
            }

            // Sự kiện chọn 1 dòng tỉnh hoặc xã
            $(document).on('click', '.js-select-addr-item', function () {
                var code = String($(this).data('code'));
                var name = String($(this).data('name'));

                if (currentStep === 'province') {
                    selectedProvince = { code: code, name: name };
                    selectedWard = { code: '', name: '' };
                    $('#provinceCode').val(code);
                    $('#provinceName').val(name);
                    $('#wardCode').val('');
                    $('#wardName').val('');
                    $('#selectedAddressText').text(name + ', chọn Xã/Phường');
                    $('#stepTabWard').prop('disabled', false).css({ 'cursor': 'pointer', 'color': '#13467d' });
                    switchAddressStep('ward');
                } else {
                    selectedWard = { code: code, name: name };
                    $('#wardCode').val(code);
                    $('#wardName').val(name);
                    var fullRegion = selectedProvince.name + ', ' + name;
                    $('#selectedAddressText').text(fullRegion);
                    closeAddressModal();
                    $('#specificAddress').focus();
                }
            });

            // Tìm kiếm nhanh trong modal
            $('#addressSearchInput').on('input', function () {
                renderAddressItems($(this).val());
            });

            // Chuyển tab qua lại
            $('#stepTabProvince').on('click', function () { switchAddressStep('province'); });
            $('#stepTabWard').on('click', function () { switchAddressStep('ward'); });

            // Nút mở / đóng modal
            $('#btnOpenAddressModal').on('click', function () { openAddressModal(); });
            $('#btnCloseAddressModal').on('click', function () { closeAddressModal(); });
            $('#addressModal').on('click', function (e) {
                if ($(e.target).is('#addressModal')) {
                    closeAddressModal();
                }
            });

            // Lấy tọa độ GPS
            $('#btnGetGps').on('click', function () {
                if (!navigator.geolocation) {
                    toast('Trình duyệt hoặc thiết bị không hỗ trợ định vị GPS.', false);
                    return;
                }
                var $icon = $('#gpsIcon');
                var $text = $('#gpsBtnText');
                $icon.removeClass('fa-crosshairs').addClass('fa-spinner fa-spin');
                $text.text('Đang lấy...');

                navigator.geolocation.getCurrentPosition(function (pos) {
                    var lat = pos.coords.latitude.toFixed(6);
                    var lng = pos.coords.longitude.toFixed(6);
                    var gpsStr = 'Tọa độ GPS: ' + lat + ', ' + lng;
                    var curSpecific = $.trim($('#specificAddress').val());
                    if (curSpecific) {
                        $('#specificAddress').val(curSpecific + ' (' + gpsStr + ')');
                    } else {
                        $('#specificAddress').val(gpsStr);
                    }
                    $icon.removeClass('fa-spinner fa-spin').addClass('fa-location-crosshairs');
                    $text.text('Đã lấy');
                    toast('Đã cập nhật tọa độ vị trí của bạn.', true);
                }, function (err) {
                    $icon.removeClass('fa-spinner fa-spin').addClass('fa-crosshairs');
                    $text.text('GPS');
                    toast('Không thể lấy vị trí GPS. Vui lòng kiểm tra quyền truy cập vị trí trên trình duyệt.', false);
                }, { enableHighAccuracy: true, timeout: 10000, maximumAge: 60000 });
            });

            // Xử lý gửi lưu thông tin
            $('#customer-profile-form').on('submit', function (e) {
                e.preventDefault();
                if (busy) return;

                var rawPhone = $('#customer-phone').val() || '';
                var phone = $.trim(rawPhone).replace(/[\s.\-]/g, '').replace(/^(?:\+84|84)/, '0');

                // 1. Kiểm tra số điện thoại
                if (phone === '') {
                    toast('Vui lòng nhập số điện thoại liên hệ.', false, '#customer-phone');
                    return;
                }
                if (!/^[0-9]+$/.test(phone)) {
                    toast('Số điện thoại chỉ được chứa các chữ số (0 - 9).', false, '#customer-phone');
                    return;
                }
                if (!/^(03|05|07|08|09)/.test(phone)) {
                    toast('Số điện thoại không hợp lệ. Vui lòng dùng các đầu số di động Việt Nam: 03, 05, 07, 08 hoặc 09.', false, '#customer-phone');
                    return;
                }
                if (phone.length < 10) {
                    toast('Số điện thoại chưa đủ 10 chữ số (Quý khách mới nhập ' + phone.length + ' số).', false, '#customer-phone');
                    return;
                }
                if (phone.length > 10) {
                    toast('Số điện thoại không được vượt quá 10 chữ số (Hiện đang có ' + phone.length + ' số).', false, '#customer-phone');
                    return;
                }

                // 2. Lấy thông tin địa chỉ
                var provinceName = $('#provinceName').val() || selectedProvince.name || '';
                var wardName = $('#wardName').val() || selectedWard.name || '';
                var specific = $.trim($('#specificAddress').val() || '');
                var currentSelectedText = $.trim($('#selectedAddressText').text());
                
                var addressParts = [];
                if (specific) addressParts.push(specific);
                if (wardName) addressParts.push(wardName);
                if (provinceName) addressParts.push(provinceName);

                var fullAddress = addressParts.join(', ');
                if (!fullAddress && currentSelectedText && currentSelectedText !== 'Chọn Tỉnh/Thành phố, Xã/Phường') {
                    fullAddress = currentSelectedText;
                }

                busy = true;
                var $btn = $('#save-customer-profile');
                var originalHtml = $btn.html();
                $btn.prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin"></i> Đang lưu thông tin...');

                $.ajax({
                    url: <?php echo json_encode(XC_URL . '/api/customerphone'); ?>,
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        csrf: <?php echo json_encode($_SESSION['customer_csrf']); ?>,
                        phone: phone,
                        province: provinceName,
                        ward: wardName,
                        specific_address: specific,
                        address: fullAddress
                    },
                    success: function (res) {
                        toast(res.message || 'Đã lưu thông tin tài khoản thành công.', res.success);
                        if (res.success) {
                            var regionText = [wardName, provinceName].filter(Boolean).join(', ');
                            if (regionText) {
                                $('#selectedAddressText').text(regionText);
                            }
                            setTimeout(function () {
                                window.location.assign(res.data && res.data.url ? res.data.url : <?php echo json_encode(XC_URL); ?>);
                            }, 1200);
                        }
                    },
                    error: function () {
                        toast('Không thể kết nối đến máy chủ. Vui lòng thử lại sau.', false);
                    },
                    complete: function () {
                        busy = false;
                        $btn.prop('disabled', false).html(originalHtml);
                    }
                });
            });

            // Đăng xuất
            $('#customer-logout').on('click', function () {
                if (busy) return;
                busy = true;
                $.ajax({
                    url: <?php echo json_encode(XC_URL . '/api/customerlogout'); ?>,
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        csrf: <?php echo json_encode($_SESSION['customer_csrf']); ?>
                    },
                    success: function (data) {
                        toast(data.message || 'Đã đăng xuất thành công.', data.success);
                        setTimeout(function () {
                            window.location.assign(data.data && data.data.url ? data.data.url : <?php echo json_encode(XC_URL); ?>);
                        }, 600);
                    },
                    error: function () {
                        toast('Không thể đăng xuất. Vui lòng thử lại.', false);
                        busy = false;
                    }
                });
            });
        });
    }
    initProfile();
})();
</script>

<?php include 'footer_new.php'; ?>
