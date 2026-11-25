<?php include "header.php";?>
<?php 
$isPolicy = (isset($page_type) && $page_type === 'chinhsach') || ((int)($introduce->introduce_category ?? 0) === 9) || in_array((int)$id, array(6, 8), true);
$pageHeaderTitle = $isPolicy ? 'Soạn thảo Chính sách nhà thuốc' : 'Soạn thảo Giới thiệu phòng khám';
$backUrl = XC_URL . ($isPolicy ? '/admin/chinhsach' : '/admin/gioithieu');
$backTitle = $isPolicy ? 'Chính sách nhà thuốc' : 'Giới thiệu phòng khám';
$slug = $this->helper->bodau($introduce->introduce_name ?? '');
$webUrl = XC_URL . ($isPolicy ? '/chinhsach/' : '/gioi-thieu/') . $id . '-' . $slug . '.html';
$labelTitle = $isPolicy ? 'Tên chính sách:' : 'Tiêu đề bài viết giới thiệu:';
$saveButtonText = $isPolicy ? 'Lưu chính sách' : 'Lưu bài viết';
?>
<script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/super-build/ckeditor.js"></script>

<script>
$(document).ready(function() {
    CKEDITOR.ClassicEditor.create(document.querySelector('textarea[name="summernote_gioithieu"]'), {
        toolbar: {
            items: [
                'findAndReplace', 'selectAll', '|',
                'heading', '|',
                'bold', 'italic', 'strikethrough', 'underline', 'subscript', 'superscript', 'removeFormat', '|',
                'bulletedList', 'numberedList', 'todoList', '|',
                'outdent', 'indent', '|',
                'undo', 'redo', '-',
                'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'highlight', '|',
                'alignment', '|',
                'link', 'insertImage', 'blockQuote', 'insertTable', 'mediaEmbed', '|',
                'specialCharacters', 'horizontalLine', '|',
                'sourceEditing'
            ],
            shouldNotGroupWhenFull: true
        },
        removePlugins: [
            'AIAssistant', 'OpenAIAssistant', 'CKBox', 'CKFinder', 'EasyImage', 'Base64UploadAdapter',
            'ExportPdf', 'ExportWord', 'Pagination', 'WProofreader', 'MathType',
            'RealTimeCollaborativeComments', 'RealTimeCollaborativeTrackChanges', 
            'RealTimeCollaborativeRevisionHistory', 'PresenceList', 'Comments', 
            'TrackChanges', 'TrackChangesData', 'RevisionHistory',
            'SlashCommand', 'Template', 'DocumentOutline', 'FormatPainter', 
            'TableOfContents', 'PasteFromOfficeEnhanced'
        ],
        language: 'vi',
        placeholder: 'Nhập nội dung bài viết / chính sách tại đây...',
        fontSize: {
            options: [ 10, 12, 14, 'default', 18, 20, 22, 26 ],
            supportAllValues: true
        },
        link: {
            addTargetToExternalLinks: true,
            defaultProtocol: 'https://'
        }
    })
    .then(editor => {
        window.editor = editor;
    })
    .catch(error => {
        console.error('Lỗi khởi tạo CKEditor:', error);
    });

    function notifyToast(msg, isSuccess) {
        if (typeof Swal !== 'undefined' && Swal.fire) {
            Swal.fire({
                position: 'center',
                icon: isSuccess ? 'success' : 'error',
                title: msg,
                showConfirmButton: !isSuccess,
                confirmButtonText: 'Đóng',
                timer: isSuccess ? 2000 : 3500,
                timerProgressBar: true
            });
        } else {
            alert(msg);
        }
    }

    $('#updatePage').click(function(e) {
        e.preventDefault();
        var userid = $('#uid').val();
        var type_id = $('#tid').val();
        var title = $.trim($('#policy_title').val());
        var content = window.editor ? window.editor.getData() : $('#summernote_gioithieu').val();

        if (title.length < 2) {
            notifyToast('Vui lòng nhập tên / tiêu đề bài viết.', false);
            $('#policy_title').focus();
            return;
        }

        var $btn = $(this);
        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Đang lưu...');

        $.ajax({
            type: "POST",
            url: "<?php echo XC_URL;?>/api/updateIntroduce",
            data: {
                'userid': userid,
                'type_id': type_id,
                'title': title,
                'content': content
            },
            dataType: 'json',
            success: function(data) {
                if (data && data.status == 200) {
                    notifyToast(data.message || 'Lưu thành công! Đang chuyển ra ngoài...', true);
                    setTimeout(function() {
                        window.location.assign('<?php echo $backUrl; ?>');
                    }, 600);
                } else {
                    notifyToast((data && data.message) ? data.message : 'Lỗi cập nhật', false);
                    $btn.prop('disabled', false).html('<i class="fas fa-save mr-1"></i> <?php echo $saveButtonText; ?>');
                }
            },
            error: function() {
                notifyToast('Không thể kết nối máy chủ.', false);
                $btn.prop('disabled', false).html('<i class="fas fa-save mr-1"></i> Lưu nội dung');
            }
        });
    });
});
</script>

<div class="content container-fluid">
   <div class="page-header">
      <div class="row align-items-center">
         <div class="col">
            <h3 class="page-title"><?php echo $pageHeaderTitle; ?></h3>
            <ul class="breadcrumb">
               <li class="breadcrumb-item"><a href="<?php echo XC_URL; ?>/admin">Trang chủ</a></li>
               <li class="breadcrumb-item"><a href="<?php echo $backUrl; ?>"><?php echo $backTitle; ?></a></li>
               <li class="breadcrumb-item active"><?php echo htmlspecialchars($introduce->introduce_name ?? 'Soạn nội dung', ENT_QUOTES, 'UTF-8'); ?></li>
            </ul>
         </div>
         <div class="col-auto">
            <a href="<?php echo $backUrl; ?>" class="btn btn-white mr-2">
               <i class="fas fa-arrow-left"></i> Quay lại danh sách
            </a>
            <a href="<?php echo $webUrl; ?>" target="_blank" class="btn btn-white text-info font-weight-bold">
               <i class="fas fa-external-link-alt"></i> Xem ngoài Web
            </a>
         </div>
      </div>
   </div>

   <div class="row">
      <div class="col-lg-12">
         <div class="card">
            <div class="card-header">
               <h4 class="card-title font-weight-bold mb-0">Nội dung chi tiết bài viết</h4>
            </div>
            <div class="card-body">
               <form action="#" onsubmit="return false;">
                  <div class="form-group mb-4">
                     <label class="font-weight-bold" style="font-size: 14.5px;"><?php echo $labelTitle; ?> <span class="text-danger">*</span></label>
                     <input type="text" id="policy_title" class="form-control" style="font-size: 16px; font-weight: 600; padding: 10px 14px; border-radius: 8px;" value="<?php echo htmlspecialchars($introduce->introduce_name ?? '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="Nhập tiêu đề...">
                     <small class="form-text text-muted">Tiêu đề này sẽ hiển thị ở menu bài viết bên trái và tiêu đề H1 ngoài website.</small>
                  </div>

                  <div class="form-group mb-4">
                     <label class="font-weight-bold" style="font-size: 14.5px;">Nội dung bài viết (Soạn thảo văn bản, bảng biểu, danh sách, in đậm):</label>
                     <textarea id="summernote_gioithieu" name="summernote_gioithieu" style="min-height: 400px;"><?php echo $introduce->introduce_content ?? ''; ?></textarea>
                  </div>

                  <input type='hidden' value='<?php echo $_SESSION['user']['id'] ?? '1'; ?>' id='uid'/>
                  <input type='hidden' value='<?php echo $id; ?>' id='tid' />

                  <div class="mt-4 pt-2 border-top d-flex align-items-center">
                     <button type="button" id='updatePage' class="btn btn-primary btn-lg px-4 mr-3" style="font-weight: 600;">
                        <i class="fas fa-save mr-1"></i> <?php echo $saveButtonText; ?>
                     </button>
                     <a href="<?php echo $backUrl; ?>" class="btn btn-white btn-lg">Hủy</a>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>

<?php include "footer.php";?>