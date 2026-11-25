<?php include "header.php"; ?>
<div class="content container-fluid">
   <div class="page-header">
      <div class="row align-items-center">
         <div class="col">
            <h3 class="page-title">Quản trị Chính sách nhà thuốc</h3>
            <ul class="breadcrumb">
               <li class="breadcrumb-item"><a href="<?php echo XC_URL; ?>/admin">Trang chủ</a></li>
               <li class="breadcrumb-item active">Chính sách nhà thuốc</li>
            </ul>
         </div>
         <div class="col-auto">
            <button type="button" class="btn btn-primary btn-open-add-policy" data-toggle="modal" data-target="#modal-add-policy" data-bs-toggle="modal" data-bs-target="#modal-add-policy">
               <i class="fas fa-plus"></i> Thêm chính sách mới
            </button>
         </div>
      </div>
   </div>

   <div class="row">
      <div class="col-sm-12">
         <div class="card card-table">
            <div class="card-header">
               <h4 class="card-title font-weight-bold">Danh sách Chính sách nhà thuốc</h4>
               <p class="card-text text-muted mb-0">Quản trị các văn bản quy định &amp; chính sách: Giá bán, Đổi trả &amp; Hoàn tiền, Phương thức thanh toán, Giao hàng...</p>
            </div>
            <div class="card-body">
               <div class="table-responsive">
                  <table class="table table-hover table-center mb-0">
                     <thead class="thead-light">
                        <tr>
                           <th style="width: 50px;">STT</th>
                           <th>Tên chính sách</th>
                           <th>Xem ngoài Web</th>
                           <th>Người cập nhật</th>
                           <th>Ngày cập nhật</th>
                           <th style="width: 220px;" class="text-right">Thao tác</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php 
                        if (!empty($policies)) {
                           $stt = 1;
                           foreach ($policies as $p) {
                              $slug = $this->helper->bodau($p->introduce_name);
                              $webUrl = XC_URL . '/chinhsach/' . $p->id . '-' . $slug . '.html';
                        ?>
                        <tr id="policy-row-<?php echo (int)$p->id; ?>">
                           <td><?php echo $stt++; ?></td>
                           <td>
                              <strong class="text-dark" id="policy-name-<?php echo (int)$p->id; ?>">
                                 <?php echo htmlspecialchars($p->introduce_name, ENT_QUOTES, 'UTF-8'); ?>
                              </strong>
                              <span class="badge badge-success ml-1" style="font-size: 11px;">Chính sách</span>
                           </td>
                           <td>
                              <a href="<?php echo $webUrl; ?>" target="_blank" class="text-info font-weight-bold" title="Mở trang trên website">
                                 <i class="fas fa-external-link-alt"></i> /chinhsach/<?php echo (int)$p->id; ?>-<?php echo $slug; ?>.html
                              </a>
                           </td>
                           <td><?php echo htmlspecialchars($p->user_fullname ?: 'Admin', ENT_QUOTES, 'UTF-8'); ?></td>
                           <td><?php echo !empty($p->introduce_created_date) ? date('d/m/Y H:i', strtotime($p->introduce_created_date)) : '-'; ?></td>
                           <td class="text-right">
                              <a href="<?php echo XC_URL; ?>/admin/chinhsach/<?php echo (int)$p->id; ?>" class="btn btn-sm btn-white text-primary mr-1" title="Soạn nội dung bằng CKEditor">
                                 <i class="fas fa-edit"></i> Soạn nội dung
                              </a>
                              <button type="button" class="btn btn-sm btn-white text-success btn-rename-policy mr-1" 
                                 data-id="<?php echo (int)$p->id; ?>" 
                                 data-name="<?php echo htmlspecialchars($p->introduce_name, ENT_QUOTES, 'UTF-8'); ?>"
                                 title="Đổi tên chính sách">
                                 <i class="fas fa-pen"></i>
                              </button>
                              <button type="button" class="btn btn-sm btn-white text-danger btn-delete-policy" 
                                 data-id="<?php echo (int)$p->id; ?>" 
                                 data-name="<?php echo htmlspecialchars($p->introduce_name, ENT_QUOTES, 'UTF-8'); ?>"
                                 title="Xóa chính sách">
                                 <i class="fas fa-trash"></i>
                              </button>
                           </td>
                        </tr>
                        <?php 
                           }
                        } else {
                        ?>
                        <tr>
                           <td colspan="6" class="text-center py-4 text-muted">Chưa có bài viết chính sách nào.</td>
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

<!-- MODAL THÊM CHÍNH SÁCH MỚI -->
<div class="modal fade" id="modal-add-policy" tabindex="-1" role="dialog" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title font-weight-bold">Thêm chính sách nhà thuốc mới</h5>
            <button type="button" class="close btn-close-modal" onclick="closeModal('#modal-add-policy')" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Đóng" style="font-size: 24px; border: none; background: transparent; cursor: pointer;">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <form id="form-add-policy">
               <div class="form-group">
                  <label class="font-weight-bold">Tên chính sách: <span class="text-danger">*</span></label>
                  <input type="text" id="new_policy_name" class="form-control" placeholder="Ví dụ: Chính sách hoàn tiền &amp; Đổi trả thuốc, Chính sách giao hàng..." required>
                  <small class="form-text text-muted">Tên này sẽ hiển thị ở menu danh mục bên trái và làm tiêu đề bài viết ngoài Website.</small>
               </div>
               <div class="form-group">
                  <label class="font-weight-bold">Nhóm danh mục:</label>
                  <select id="new_policy_category" class="form-control">
                     <option value="9">Chính sách bán hàng &amp; Nhà thuốc</option>
                  </select>
               </div>
            </form>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-close-modal" onclick="closeModal('#modal-add-policy')" data-dismiss="modal" data-bs-dismiss="modal">Hủy</button>
            <button type="button" id="btn-submit-add-policy" class="btn btn-primary">
               <i class="fas fa-check"></i> Tạo &amp; Soạn nội dung ngay
            </button>
         </div>
      </div>
   </div>
</div>

<!-- MODAL ĐỔI TÊN CHÍNH SÁCH -->
<div class="modal fade" id="modal-rename-policy" tabindex="-1" role="dialog" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title font-weight-bold">Đổi tên chính sách</h5>
            <button type="button" class="close btn-close-modal" onclick="closeModal('#modal-rename-policy')" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Đóng" style="font-size: 24px; border: none; background: transparent; cursor: pointer;">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <input type="hidden" id="rename_policy_id">
            <div class="form-group">
               <label class="font-weight-bold">Tên chính sách mới: <span class="text-danger">*</span></label>
               <input type="text" id="rename_policy_name" class="form-control" required>
            </div>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-close-modal" onclick="closeModal('#modal-rename-policy')" data-dismiss="modal" data-bs-dismiss="modal">Hủy</button>
            <button type="button" id="btn-submit-rename-policy" class="btn btn-success">
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

   // Mở modal thêm chính sách
   $('.btn-open-add-policy').click(function(e) {
      e.preventDefault();
      $('#new_policy_name').val('');
      openModal('#modal-add-policy');
      setTimeout(function() { $('#new_policy_name').focus(); }, 150);
   });

   // 1. Thêm mới chính sách
   $('#btn-submit-add-policy').click(function(e) {
      e.preventDefault();
      var name = $.trim($('#new_policy_name').val());
      var cat = $('#new_policy_category').val();
      if (name.length < 2) {
         notifyToast('Vui lòng nhập tên chính sách hợp lệ.', false);
         $('#new_policy_name').focus();
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
               notifyToast(res.message || 'Thêm chính sách thành công!', true);
               closeModal('#modal-add-policy');
               setTimeout(function() {
                  window.location.assign('<?php echo XC_URL; ?>/admin/chinhsach/' + (res.id || ''));
               }, 600);
            } else {
               notifyToast((res && res.message) ? res.message : 'Lỗi thêm chính sách', false);
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
   $('.btn-rename-policy').click(function(e) {
      e.preventDefault();
      var id = $(this).data('id');
      var name = $(this).data('name');
      $('#rename_policy_id').val(id);
      $('#rename_policy_name').val(name);
      openModal('#modal-rename-policy');
      setTimeout(function() { $('#rename_policy_name').focus().select(); }, 150);
   });

   // Submit đổi tên
   $('#btn-submit-rename-policy').click(function(e) {
      e.preventDefault();
      var id = $('#rename_policy_id').val();
      var name = $.trim($('#rename_policy_name').val());
      if (name.length < 2) {
         notifyToast('Tên chính sách không được để trống.', false);
         $('#rename_policy_name').focus();
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
               notifyToast('Đổi tên chính sách thành công!', true);
               $('#policy-name-' + id).text(name);
               closeModal('#modal-rename-policy');
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

   // 3. Xóa chính sách
   $('.btn-delete-policy').click(function() {
      var id = $(this).data('id');
      var name = $(this).data('name');

      Swal.fire({
         title: 'Xóa chính sách này?',
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
                     $('#policy-row-' + id).fadeOut(300, function() { $(this).remove(); });
                     notifyToast(res.message || 'Đã xóa chính sách!', true);
                  } else {
                     notifyToast((res && res.message) ? res.message : 'Lỗi xóa chính sách', false);
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