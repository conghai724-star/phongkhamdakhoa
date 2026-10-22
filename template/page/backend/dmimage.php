<?php include "header.php"; ?>
<?php
function dmImageHtml($value){
  return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}
function dmImageTypeLabel($image){
  if((int)$image->image_category !== 3) return 'Ảnh thường';
  return (int)$image->image_device === 1 ? 'Slider Mobile' : 'Slider Desktop';
}
function dmImageTypeClass($image){
  if((int)$image->image_category !== 3) return 'normal';
  return (int)$image->image_device === 1 ? 'mobile' : 'desktop';
}
?>
<style>
  .image-library-header{display:flex;align-items:center;justify-content:space-between;gap:16px;margin-bottom:20px}
  .image-library-header h3{margin:0;color:#253858}.image-library-header p{margin:6px 0 0;color:#7a869a}
  .image-filter-card{border:0;box-shadow:0 3px 12px rgba(32,56,85,.08);margin-bottom:22px}.image-filter-card .card-body{padding:18px}
  .image-filter-actions{display:flex;align-items:center;gap:8px;height:100%}
  .image-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:20px}
  .image-card{background:#fff;border:1px solid #e7ebf0;border-radius:12px;overflow:hidden;box-shadow:0 4px 14px rgba(37,56,88,.08);transition:.2s ease;display:flex;flex-direction:column;min-width:0}
  .image-card:hover{transform:translateY(-3px);box-shadow:0 9px 24px rgba(37,56,88,.15)}
  .image-preview{height:190px;background:#eef2f6;position:relative;overflow:hidden}.image-preview img{width:100%;height:100%;object-fit:cover;display:block}
  .image-preview .image-fallback{width:100%;height:100%;display:flex;align-items:center;justify-content:center;color:#9ca8b5;font-size:38px}
  .image-type-badge{position:absolute;top:12px;left:12px;padding:5px 10px;border-radius:20px;color:#fff;font-size:11px;font-weight:700;box-shadow:0 2px 8px #0002}
  .image-type-badge.normal{background:#64748b}.image-type-badge.desktop{background:#1760a5}.image-type-badge.mobile{background:#e36928}
  .image-card-body{padding:15px;display:flex;flex:1;flex-direction:column;gap:12px}.image-card-name{font-size:16px;font-weight:700;color:#253858;margin:0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
  .image-meta{font-size:12px;color:#7a869a}.image-url-box{display:flex;align-items:center;gap:8px;background:#f5f7fa;border:1px solid #e7ebf0;border-radius:7px;padding:8px}
  .image-url-text{font-size:11px;color:#5e6c84;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;flex:1;min-width:0}.btn-copy-image{border:0;background:#fff;color:#1760a5;border-radius:5px;padding:5px 8px}
  .image-card-actions{display:grid;grid-template-columns:1fr auto;gap:8px;margin-top:auto}.image-card-actions .btn{border-radius:7px}
  .image-empty{grid-column:1/-1;background:#fff;border:1px dashed #ccd4dd;border-radius:12px;padding:60px 20px;text-align:center;color:#7a869a}.image-empty i{font-size:44px;margin-bottom:14px;color:#b2bdc8}
  #toast-container{position:fixed;bottom:20px;right:20px;z-index:9999}.image-toast{background:#1760a5;color:#fff;padding:11px 18px;border-radius:7px;box-shadow:0 4px 12px #0003}
  @media(max-width:767px){.image-library-header{align-items:flex-start;flex-direction:column}.image-filter-actions{margin-top:8px}.image-grid{grid-template-columns:1fr}}
</style>

<div class="content container-fluid">
  <div class="image-library-header">
    <div>
      <h3>Danh mục hình ảnh</h3>
      <p>Quản lý thư viện ảnh và cấu hình slider hiển thị trên website.</p>
    </div>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add_image">
      <i class="fas fa-plus me-1"></i> Thêm hình ảnh
    </button>
  </div>

  <div class="card image-filter-card">
    <div class="card-body">
      <form method="get" action="<?php echo XC_URL; ?>/admin/dmimages">
        <div class="row align-items-end">
          <div class="col-lg-5 col-md-5">
            <div class="form-group mb-md-0">
              <label>Tìm theo tên hình</label>
              <input type="text" class="form-control" name="image_name" value="<?php echo dmImageHtml($filter_image_name); ?>" placeholder="Nhập tên hình ảnh...">
            </div>
          </div>
          <div class="col-lg-4 col-md-4">
            <div class="form-group mb-md-0">
              <label>Loại hình</label>
              <select class="form-control" name="image_type">
                <option value="">Tất cả loại hình</option>
                <option value="normal" <?php echo $filter_image_type === 'normal' ? 'selected' : ''; ?>>Ảnh thường</option>
                <option value="slider_desktop" <?php echo $filter_image_type === 'slider_desktop' ? 'selected' : ''; ?>>Slider Desktop</option>
                <option value="slider_mobile" <?php echo $filter_image_type === 'slider_mobile' ? 'selected' : ''; ?>>Slider Mobile</option>
              </select>
            </div>
          </div>
          <div class="col-lg-3 col-md-3">
            <div class="image-filter-actions">
              <button type="submit" class="btn btn-primary"><i class="fas fa-search me-1"></i> Lọc</button>
              <a href="<?php echo XC_URL; ?>/admin/dmimages" class="btn btn-white">Đặt lại</a>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>

  <div class="image-grid" id="image-grid">
    <?php if(empty($images)){ ?>
      <div class="image-empty"><i class="far fa-images"></i><h5>Không tìm thấy hình ảnh</h5><p>Thử thay đổi bộ lọc hoặc thêm hình ảnh mới.</p></div>
    <?php } else { foreach($images as $image){
      $imageUrl = XC_URL . '/uploads/images/' . $image->image_url;
    ?>
      <div class="image-card" id="image-card-<?php echo intval($image->imageid); ?>">
        <div class="image-preview">
          <?php if(!empty($image->image_url)){ ?>
            <img src="<?php echo dmImageHtml($imageUrl); ?>" alt="<?php echo dmImageHtml($image->image_name); ?>" loading="lazy" onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
            <div class="image-fallback" style="display:none"><i class="far fa-image"></i></div>
          <?php } else { ?>
            <div class="image-fallback"><i class="far fa-image"></i></div>
          <?php } ?>
          <span class="image-type-badge <?php echo dmImageTypeClass($image); ?>"><?php echo dmImageTypeLabel($image); ?></span>
        </div>
        <div class="image-card-body">
          <div>
            <h5 class="image-card-name" title="<?php echo dmImageHtml($image->image_name); ?>"><?php echo dmImageHtml($image->image_name); ?></h5>
            <div class="image-meta">Ngày thêm: <?php echo !empty($image->image_created_date) ? date('d/m/Y H:i', strtotime($image->image_created_date)) : 'Không rõ'; ?></div>
          </div>
          <div class="image-url-box">
            <span class="image-url-text"><?php echo dmImageHtml($imageUrl); ?></span>
            <button type="button" class="btn-copy-image" data-copy="<?php echo dmImageHtml($imageUrl); ?>" title="Sao chép đường dẫn"><i class="far fa-copy"></i></button>
          </div>
          <div class="image-card-actions">
            <button type="button" data-bs-toggle="modal" data-bs-target="#slider" class="btn btn-sm btn-outline-primary btn-config-image" data-id="<?php echo intval($image->imageid); ?>" data-device="<?php echo intval($image->image_device); ?>" data-category="<?php echo intval($image->image_category); ?>">
              <i class="fas fa-cog me-1"></i> Cấu hình slider
            </button>
            <button type="button" class="btn btn-sm btn-outline-danger btn-delete-image" data-id="<?php echo intval($image->imageid); ?>" title="Xóa hình"><i class="far fa-trash-alt"></i></button>
          </div>
        </div>
      </div>
    <?php }} ?>
  </div>
</div>
</div>

<div id="add_image" class="modal custom-modal fade" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document"><div class="modal-content">
    <div class="modal-header"><h5 class="modal-title">Thêm hình ảnh</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
    <div class="modal-body">
      <form id="add-image-form">
        <div class="form-group"><label>Tên hình <span class="text-danger">*</span></label><input class="form-control" type="text" id="image_name" required></div>
        <div class="form-group"><label>Hình ảnh <span class="text-danger">*</span></label><input class="form-control" type="file" id="image_file" accept=".jpg,.jpeg,.png" required></div>
        <input type="hidden" value="<?php echo intval($_SESSION['user']['id']); ?>" id="image_usercreate">
        <div class="submit-section"><button type="submit" class="btn btn-primary submit-btn" id="addImage">Thêm</button></div>
      </form>
    </div>
  </div></div>
</div>

<div class="modal custom-modal fade" id="slider" role="dialog">
  <div class="modal-dialog modal-dialog-centered"><div class="modal-content">
    <div class="modal-header"><h5 class="modal-title">Cấu hình slider</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
    <div class="modal-body">
      <form id="slider-form">
        <div class="form-group"><label>Thiết bị hiển thị</label><select id="image_type" class="form-control"><option value="0">Desktop</option><option value="1">Mobile</option></select></div>
        <div class="form-group"><label class="text-danger"><input type="checkbox" value="1" id="cancel_slider"> Xóa cấu hình slider, chuyển về ảnh thường</label></div>
        <input type="hidden" id="iid_slider">
        <div class="submit-section"><button type="submit" class="btn btn-primary submit-btn" id="ch_slider">Lưu cấu hình</button></div>
      </form>
    </div>
  </div></div>
</div>

<script>
$(document).ready(function(){
  function showResult(data, successTitle){
    if(data.status == 200){
      Swal.fire({icon:'success',title:successTitle,timer:1400,showConfirmButton:false});
      setTimeout(function(){ location.reload(); }, 1500);
    }else{
      Swal.fire({icon:'error',title:'Lỗi',text:data.message || 'Không thể thực hiện thao tác.'});
    }
  }

  $('#add-image-form').on('submit', function(e){
    e.preventDefault();
    var file = $('#image_file')[0].files[0];
    if(!$('#image_name').val().trim() || !file) return;
    var formData = new FormData();
    formData.append('image_name', $('#image_name').val().trim());
    formData.append('image_usercreate', $('#image_usercreate').val());
    formData.append('image_file', file);
    $('#addImage').prop('disabled', true);
    $.ajax({type:'POST',url:'<?php echo XC_URL; ?>/api/addImage',data:formData,dataType:'json',processData:false,contentType:false,
      success:function(data){ showResult(data, 'Thêm hình ảnh thành công'); },
      error:function(){ Swal.fire({icon:'error',title:'Lỗi',text:'Không thể kết nối máy chủ.'}); },
      complete:function(){ $('#addImage').prop('disabled', false); }
    });
  });

  $('.btn-config-image').on('click', function(){
    $('#iid_slider').val($(this).data('id'));
    $('#image_type').val(String($(this).data('device')));
    $('#cancel_slider').prop('checked', Number($(this).data('category')) !== 3);
  });

  $('#slider-form').on('submit', function(e){
    e.preventDefault();
    var formData = new FormData();
    formData.append('iid', $('#iid_slider').val());
    formData.append('image_type', $('#image_type').val());
    formData.append('cancel_slider', $('#cancel_slider').is(':checked') ? 1 : 0);
    $('#ch_slider').prop('disabled', true);
    $.ajax({type:'POST',url:'<?php echo XC_URL; ?>/api/update_imagetype',data:formData,dataType:'json',processData:false,contentType:false,
      success:function(data){ showResult(data, 'Cấu hình thành công'); },
      error:function(){ Swal.fire({icon:'error',title:'Lỗi',text:'Không thể kết nối máy chủ.'}); },
      complete:function(){ $('#ch_slider').prop('disabled', false); }
    });
  });

  $('#image-grid').on('click', '.btn-delete-image', function(){
    var iid = $(this).data('id');
    Swal.fire({title:'Xóa hình ảnh này?',text:'Hình ảnh sẽ không còn hiển thị trong danh mục.',icon:'warning',showCancelButton:true,confirmButtonText:'Xóa',cancelButtonText:'Hủy'}).then(function(result){
      if(!result.isConfirmed) return;
      $.ajax({type:'POST',url:'<?php echo XC_URL; ?>/api/deleteImage',data:{iid:iid},dataType:'json',
        success:function(data){
          if(data.status == 200){
            $('#image-card-' + iid).fadeOut(250, function(){ $(this).remove(); });
            Swal.fire({icon:'success',title:'Xóa thành công',timer:1300,showConfirmButton:false});
          }else Swal.fire({icon:'error',title:'Lỗi',text:data.message});
        },
        error:function(){ Swal.fire({icon:'error',title:'Lỗi',text:'Không thể kết nối máy chủ.'}); }
      });
    });
  });

  $('#image-grid').on('click', '.btn-copy-image', function(){
    var text = $(this).data('copy');
    function copiedSuccess(){
      Swal.fire({
        icon:'success',
        title:'Đã sao chép',
        text:'Đường dẫn hình ảnh đã được sao chép.',
        timer:1500,
        showConfirmButton:false
      });
    }
    function fallbackCopy(){
      var input = $('<textarea>').css({position:'fixed',opacity:0}).val(text).appendTo('body');
      input[0].select();
      try{
        document.execCommand('copy');
        copiedSuccess();
      }catch(error){
        Swal.fire({icon:'error',title:'Không thể sao chép',text:'Vui lòng sao chép đường dẫn thủ công.'});
      }
      input.remove();
    }
    if(navigator.clipboard && window.isSecureContext){
      navigator.clipboard.writeText(text).then(copiedSuccess).catch(fallbackCopy);
    }else{
      fallbackCopy();
    }
  });
});
</script>
<?php include "footer.php"; ?>
