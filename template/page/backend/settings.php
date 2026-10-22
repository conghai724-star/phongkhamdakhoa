<?php include "header.php";?>
<?php $type = isset($type) ? $type : 'general'; ?>
<div class="content container-fluid">
   <div class="page-header">
      <div class="row">
         <div class="col-sm-6">
            <h3 class="page-title">Thiết lập</h3>
            <ul class="breadcrumb">
               <li class="breadcrumb-item"><a href="<?php echo XC_URL; ?>/admin">Trang chủ</a></li>
               <li class="breadcrumb-item active">Cài đặt</li>
            </ul>
         </div>
      </div>
   </div>
   <div class="row">
      <div class="col-md-12">
         <div class="card bg-white">
            <div class="card-body">
               <ul class="nav nav-tabs nav-tabs-solid nav-justified">
<li class="nav-item"><a class="nav-link" href="<?php echo XC_URL; ?>/admin/socialsettings">Đăng nhập Mạng xã hội (Google / FB / Zalo)</a></li>
                  <li class="nav-item">
                     <a class="nav-link <?php echo ($type == 'general') ? 'active' : ''; ?>" href="<?php echo XC_URL; ?>/admin/setting">Phòng khám và Nhà thuốc</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link <?php echo ($type == 'change-password') ? 'active' : ''; ?>" href="<?php echo XC_URL; ?>/admin/setting?type=change-password">Đổi mật khẩu</a>
                  </li>
               </ul>
               <div class="tab-content pt-4">
                  <?php if($type == 'change-password'){ ?>
                  <div class="tab-pane show active">
                     <form id="change-password-form">
                        <div class="row form-group mb-3">
                           <label class="col-sm-3 col-form-label input-label">Mật khẩu hiện tại</label>
                           <div class="col-sm-9">
                              <input type="password" class="form-control" id="oldpass" name="oldpass" placeholder="Nhập mật khẩu hiện tại">
                           </div>
                        </div>
                        <div class="row form-group mb-3">
                           <label class="col-sm-3 col-form-label input-label">Mật khẩu mới</label>
                           <div class="col-sm-9">
                              <input type="password" class="form-control" id="newpass" name="newpass" placeholder="Nhập mật khẩu mới">
                           </div>
                        </div>
                        <div class="row form-group mb-3">
                           <label class="col-sm-3 col-form-label input-label">Nhập lại mật khẩu mới</label>
                           <div class="col-sm-9">
                              <input type="password" class="form-control" id="renewpass" name="renewpass" placeholder="Nhập lại mật khẩu mới">
                           </div>
                        </div>
                        <div class="text-end">
                           <button type="submit" class="btn btn-primary">Cập nhật mật khẩu</button>
                        </div>
                     </form>
                  </div>
                  <script>
                  document.addEventListener('DOMContentLoaded', function () {
                     var form = document.getElementById('change-password-form');
                     if (!form) {
                        return;
                     }

                     form.addEventListener('submit', function (event) {
                        event.preventDefault();
                        var formData = new FormData(form);

                        fetch('<?php echo XC_URL; ?>/api/changepass', {
                           method: 'POST',
                           body: formData
                        })
                           .then(function (response) {
                              return response.json();
                           })
                           .then(function (data) {
                              var message = data.message || 'Đã xử lý xong';
                              if (typeof Swal !== 'undefined') {
                                 Swal.fire({
                                    icon: data.status == 200 ? 'success' : 'error',
                                    text: message
                                 }).then(function () {
                                    if (data.status == 200 && data.url) {
                                       window.location.href = data.url;
                                    }
                                 });
                              } else {
                                 alert(message);
                                 if (data.status == 200 && data.url) {
                                    window.location.href = data.url;
                                 }
                              }
                           })
                           .catch(function () {
                              alert('Không thể đổi mật khẩu lúc này.');
                           });
                     });
                  });
                  </script>
                  <?php } else { ?>
                  <div class="tab-pane show active">
                     <form>
                        <div class="row form-group mb-3">
                           <label for="website_name" class="col-sm-3 col-form-label input-label">Tên đơn vị</label>
                           <div class="col-sm-9">
                              <input type="text" class="form-control" id="website_name" name="company_name" placeholder="Tên đơn vị" value="<?php echo $this->helper->get_config("website_name");?>">
                           </div>
                        </div>
                        <div class="row form-group mb-3">
                           <label for="company_phone" class="col-sm-3 col-form-label input-label">Điện thoại</label>
                           <div class="col-sm-9">
                              <input type="text" class="form-control" id="company_phone" name="company_phone" placeholder="Điện thoại" value="<?php echo $this->helper->get_config("site_phone");?>">
                           </div>
                        </div>
                        <div class="row form-group mb-3">
                           <label for="email" class="col-sm-3 col-form-label input-label">Email</label>
                           <div class="col-sm-9">
                              <input type="email" class="form-control" id="email" placeholder="Email" value="<?php echo $this->helper->get_config("site_email");?>">
                           </div>
                        </div>
                        <div class="row form-group mb-3">
                           <label for="company_address" class="col-sm-3 col-form-label input-label">Địa chỉ</label>
                           <div class="col-sm-9">
                              <input type="text" class="form-control" id="company_address" name="company_address" placeholder="Địa chỉ" value="<?php echo $this->helper->get_config("site_address");?>">
                           </div>
                        </div>
                     </form>
                  </div>
                  <?php } ?>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
</div>
<?php include "footer.php";?>
