<?php include "header.php"; ?>
<div class="content container-fluid">
   <div class="page-header">
      <div class="row align-items-center">
         <div class="col">
            <h3 class="page-title">Quản trị Giới thiệu phòng khám</h3>
            <ul class="breadcrumb">
               <li class="breadcrumb-item"><a href="<?php echo XC_URL; ?>/admin">Trang chủ</a></li>
               <li class="breadcrumb-item active">Giới thiệu phòng khám</li>
            </ul>
         </div>
         <div class="col-auto">
            <button type="button" class="btn btn-primary btn-open-add-intro" data-toggle="modal" data-target="#modal-add-intro" data-bs-toggle="modal" data-bs-target="#modal-add-intro">
               <i class="fas fa-plus"></i> Thêm bài giới thiệu mới
            </button>
         </div>
      </div>
   </div>

   <div class="row">
      <div class="col-sm-12">
         <div class="card card-table">
            <div class="card-header">
               <h4 class="card-title font-weight-bold">Danh sách bài viết Giới thiệu phòng khám &amp; Nhà thuốc</h4>
               <p class="card-text text-muted mb-0">Quản trị nội dung các trang thông tin: Về chúng tôi, Cơ cấu tổ chức, Cơ sở hạ tầng, Tại sao chọn chúng tôi?, Giới thiệu nhà thuốc...</p>
            </div>
            <div class="card-body">
               <div class="table-responsive">
                  <table class="table table-hover table-center mb-0">
                     <thead class="thead-light">
                        <tr>
                           <th style="width: 50px;">STT</th>
                           <th>Tên bài viết giới thiệu</th>
                           <th>Xem ngoài Web</th>
                           <th>Người cập nhật</th>
                           <th>Ngày cập nhật</th>
                           <th style="width: 220px;" class="text-right">Thao tác</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php 
                        if (!empty($introduces)) {
                           $stt = 1;
                           foreach ($introduces as $item) {
                              $slug = $this->helper->bodau($item->introduce_name);
                              $webUrl = XC_URL . '/gioi-thieu/' . $item->id . '-' . $slug . '.html';
                        ?>
                        <tr id="intro-row-<?php echo (int)$item->id; ?>">
                           <td><?php echo $stt++; ?></td>
                           <td>
                              <strong class="text-dark" id="intro-name-<?php echo (int)$item->id; ?>">
                                 <?php echo htmlspecialchars($item->introduce_name, ENT_QUOTES, 'UTF-8'); ?>
                              </strong>
                              <span class="badge badge-secondary ml-1" style="font-size: 11px;">Giới thiệu</span>
                           </td>
                           <td>
                              <a href="<?php echo $webUrl; ?>" target="_blank" class="text-info font-weight-bold" title="Mở trang trên website">
                                 <i class="fas fa-external-link-alt"></i> /gioi-thieu/<?php echo (int)$item->id; ?>-<?php echo $slug; ?>.html
                              </a>
                           </td>
                           <td><?php echo htmlspecialchars($item->user_fullname ?: 'Admin', ENT_QUOTES, 'UTF-8'); ?></td>
                           <td><?php echo !empty($item->introduce_created_date) ? date('d/m/Y H:i', strtotime($item->introduce_created_date)) : '-'; ?></td>
                           <td class="text-right">
                              <a href="<?php echo XC_URL; ?>/admin/gioithieu/<?php echo (int)$item->id; ?>" class="btn btn-sm btn-white text-primary mr-1" title="Soạn nội dung bằng CKEditor">
                                 <i class="fas fa-edit"></i> Soạn nội dung
                              </a>
                              <button type="button" class="btn btn-sm btn-white text-success btn-rename-intro mr-1" 
                                 data-id="<?php echo (int)$item->id; ?>" 
                                 data-name="<?php echo htmlspecialchars($item->introduce_name, ENT_QUOTES, 'UTF-8'); ?>"
                                 title="Đổi tên bài viết">
                                 <i class="fas fa-pen"></i>
                              </button>
                              <button type="button" class="btn btn-sm btn-white text-danger btn-delete-intro" 
                                 data-id="<?php echo (int)$item->id; ?>" 
                                 data-name="<?php echo htmlspecialchars($item->introduce_name, ENT_QUOTES, 'UTF-8'); ?>"
                                 title="Xóa bài viết">
                                 <i class="fas fa-trash"></i>
                              </button>
                           </td>
                        </tr>
                        <?php 
                           }
                        } else {
                        ?>
                        <tr>
                           <td colspan="6" class="text-center py-4 text-muted">Chưa có bài viết giới thiệu nào.</td>
                        </tr>
                        <?php } ?>
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<!-- MODAL THÊM BÀI VIẾT GIỚI THIỆU MỚI -->
<div class="modal fade" id="modal-add-intro" tabindex="-1" role="dialog" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title font-weight-bold">Thêm bài viết Giới thiệu mới</h5>
            <button type="button" class="close btn-close-modal" onclick="closeModal('#modal-add-intro')" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Đóng" style="font-size: 24px; border: none; background: transparent; cursor: pointer;">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <form id="form-add-intro">
               <div class="form-group">
                  <label class="font-weight-bold">Tên bài viết / Tiêu đề: <span class="text-danger">*</span></label>
                  <input type="text" id="new_intro_name" class="form-control" placeholder="Ví dụ: Về chúng tôi, Tầm nhìn sứ mệnh..." required>
                  <small class="form-text text-muted">Tên này sẽ hiển thị ở menu giới thiệu bên trái và làm tiêu đề bài viết ngoài Website.</small>
               </div>
               <div class="form-group">
                  <label class="font-weight-bold">Nhóm giới thiệu:</label>
                  <select id="new_intro_category" class="form-control">
                     <option value="2">Về chúng tôi</option>
                     <option value="3">Cơ cấu tổ chức</option>
                     <option value="4">Cơ sở hạ tầng</option>
                     <option value="5">Tại sao chọn chúng tôi?</option>
                     <option value="8">Giới thiệu nhà thuốc</option>
                     <option value="1">Thông tin chung phòng khám</option>
                  </select>
               </div>
            </form>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-close-modal" onclick="closeModal('#modal-add-intro')" data-dismiss="modal" data-bs-dismiss="modal">Hủy</button>
            <button type="button" id="btn-submit-add-intro" class="btn btn-primary">
               <i class="fas fa-check"></i> Tạo &amp; Soạn nội dung ngay
            </button>
         </div>
      </div>
   </div>
</div>

<!-- MODAL ĐỔI TÊN BÀI VIẾT -->
<div class="modal fade" id="modal-rename-intro" tabindex="-1" role="dialog" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title font-weight-bold">Đổi tên bài viết Giới thiệu</h5>
            <button type="button" class="close btn-close-modal" onclick="closeModal('#modal-rename-intro')" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Đóng" style="font-size: 24px; border: none; background: transparent; cursor: pointer;">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <input type="hidden" id="rename_intro_id">
            <div class="form-group">
               <label class="font-weight-bold">Tên bài viết mới: <span class="text-danger">*</span></label>
               <input type="text" id="rename_intro_name" class="form-control" required>
            </div>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-close-modal" onclick="closeModal('#modal-rename-intro')" data-dismiss="modal" data-bs-dismiss="modal">Hủy</button>
            <button type="button" id="btn-submit-rename-intro" class="btn btn-success">
               <i class="fas fa-save"></i> Cập nhật tên
            </button>
         </div>
      </div>
   </div>
</div>

<script>
// Hàm đóng modal toàn cục, gọi được trực tiếp từ inline HTML onclick
window.closeModal = function(modalId) {
   var selector = modalId || '.modal';
   var $m = $(selector);
   if (window.jQuery && typeof $m.modal === 'function') {
      try { $m.modal('hide'); } catch(e) {}
   }
   if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
      $m.each(function() {
         try {
            var inst = bootstrap.Modal.getInstance(this);
            if (inst) { inst.hide(); }
         } catch(e) {}
      });
   }
   $m.removeClass('show in').css('display', 'none').attr('aria-hidden', 'true').removeAttr('aria-modal');
   $('body').removeClass('modal-open').css('padding-right', '');
   $('.modal-backdrop').remove();
};

$(document).ready(function() {
   function notifyToast(msg, isSuccess) {
      if (typeof Swal !== 'undefined' && Swal.fire) {
         Swal.fire({
            position: 'center',
            icon: isSuccess ? 'success' : 'error',
            title: msg,
            showConfirmButton: !isSuccess,
            confirmButtonText: 'Đóng',
            timer: isSuccess ? 1800 : undefined,
            timerProgressBar: isSuccess
         });
      } else {
         alert(msg);
      }
   }

   // Hàm mở modal tương thích Bootstrap 4, 5 & DOM thuần
   function openModal(modalId) {
      var modalEl = (typeof modalId === 'string') ? document.querySelector(modalId) : modalId;
      if (!modalEl) return;
      if (window.jQuery && typeof jQuery(modalEl).modal === 'function') {
         try { jQuery(modalEl).modal('show'); return; } catch(e) {}
      }
      if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
         try {
            var inst = bootstrap.Modal.getOrCreateInstance ? bootstrap.Modal.getOrCreateInstance(modalEl) : new bootstrap.Modal(modalEl);
            inst.show();
            return;
         } catch(e) {}
      }
      $(modalEl).addClass('show').css('display', 'block').removeAttr('aria-hidden').attr('aria-modal', 'true');
      $('body').addClass('modal-open');
      if (!$('.modal-backdrop').length) {
         $('body').append('<div class="modal-backdrop fade show"></div>');
      }
   }

   // Bắt sự kiện click nút đóng (Hủy, dấu X hoặc class btn-close-modal)
   $(document).on('click', '[data-dismiss="modal"], [data-bs-dismiss="modal"], .btn-close-modal', function(e) {
      var $m = $(this).closest('.modal');
      if ($m.length) {
         closeModal($m[0]);
      }
   });

   // Đóng modal khi click ra vùng nền tối phía ngoài
   $(document).on('click', '.modal', function(e) {
      if ($(e.target).is('.modal')) {
         closeModal(this);
      }
   });

   // Mở modal thêm bài viết
   $('.btn-open-add-intro').click(function(e) {
      e.preventDefault();
      $('#new_intro_name').val('');
      openModal('#modal-add-intro');
      setTimeout(function() { $('#new_intro_name').focus(); }, 150);
   });

   // 1. Thêm mới bài viết
   $('#btn-submit-add-intro').click(function(e) {
      e.preventDefault();
      var name = $.trim($('#new_intro_name').val());
      var cat = $('#new_intro_category').val();
      if (name.length < 2) {
         notifyToast('Vui lòng nhập tên bài viết hợp lệ.', false);
         $('#new_intro_name').focus();
         return;
      }
      var $btn = $(this);
      $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Đang tạo...');
      
      $.ajax({
         type: 'POST',
         url: '<?php echo XC_URL; ?>/api/addIntroduce',
         data: { name: name, category: cat },
         dataType: 'json',
         success: function(res) {
            if (res && res.status === 200) {
               notifyToast(res.message || 'Thêm bài viết thành công!', true);
               closeModal('#modal-add-intro');
               setTimeout(function() {
                  window.location.assign('<?php echo XC_URL; ?>/admin/gioithieu/' + (res.id || ''));
               }, 600);
            } else {
               notifyToast((res && res.message) ? res.message : 'Lỗi thêm bài viết', false);
               $btn.prop('disabled', false).html('<i class="fas fa-check"></i> Tạo &amp; Soạn nội dung ngay');
            }
         },
         error: function() {
            notifyToast('Không thể kết nối máy chủ.', false);
            $btn.prop('disabled', false).html('<i class="fas fa-check"></i> Tạo &amp; Soạn nội dung ngay');
         }
      });
   });

   // 2. Mở modal đổi tên
   $('.btn-rename-intro').click(function(e) {
      e.preventDefault();
      var id = $(this).data('id');
      var name = $(this).data('name');
      $('#rename_intro_id').val(id);
      $('#rename_intro_name').val(name);
      openModal('#modal-rename-intro');
      setTimeout(function() { $('#rename_intro_name').focus().select(); }, 150);
   });

   // Submit đổi tên
   $('#btn-submit-rename-intro').click(function(e) {
      e.preventDefault();
      var id = $('#rename_intro_id').val();
      var name = $.trim($('#rename_intro_name').val());
      if (name.length < 2) {
         notifyToast('Tên bài viết không được để trống.', false);
         $('#rename_intro_name').focus();
         return;
      }
      var $btn = $(this);
      $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Đang lưu...');

      $.ajax({
         type: 'POST',
         url: '<?php echo XC_URL; ?>/api/updateIntroduce',
         data: { type_id: id, title: name },
         dataType: 'json',
         success: function(res) {
            if (res && res.status === 200) {
               notifyToast('Đổi tên bài viết thành công!', true);
               $('#intro-name-' + id).text(name);
               closeModal('#modal-rename-intro');
               setTimeout(function() { window.location.reload(); }, 600);
            } else {
               notifyToast((res && res.message) ? res.message : 'Lỗi đổi tên', false);
               $btn.prop('disabled', false).html('<i class="fas fa-save"></i> Cập nhật tên');
            }
         },
         error: function(xhr, status, err) {
            console.error('Lỗi API updateIntroduce:', xhr.responseText || err);
            notifyToast('Không thể kết nối máy chủ.', false);
            $btn.prop('disabled', false).html('<i class="fas fa-save"></i> Cập nhật tên');
         }
      });
   });

   // 3. Xóa bài viết
   $('.btn-delete-intro').click(function() {
      var id = $(this).data('id');
      var name = $(this).data('name');

      Swal.fire({
         title: 'Xóa bài viết này?',
         text: 'Bạn có chắc muốn xóa "' + name + '"? Thao tác này không thể hoàn tác.',
         icon: 'warning',
         showCancelButton: true,
         confirmButtonColor: '#d33',
         cancelButtonColor: '#6e7881',
         confirmButtonText: 'Đồng ý xóa',
         cancelButtonText: 'Hủy'
      }).then(function(result) {
         if (result.isConfirmed) {
            $.ajax({
               type: 'POST',
               url: '<?php echo XC_URL; ?>/api/deleteIntroduce',
               data: { id: id },
               dataType: 'json',
               success: function(res) {
                  if (res && res.status === 200) {
                     $('#intro-row-' + id).fadeOut(300, function() { $(this).remove(); });
                     notifyToast(res.message || 'Đã xóa bài viết!', true);
                  } else {
                     notifyToast((res && res.message) ? res.message : 'Lỗi xóa bài viết', false);
                  }
               },
               error: function() {
                  notifyToast('Không thể kết nối máy chủ.', false);
               }
            });
         }
      });
   });
});
</script>
<?php include "footer.php"; ?>