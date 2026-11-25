<?php include "config.php"; ?>
<!DOCTYPE html>
<html lang="en">
  
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
      <title><?php echo ($pagetitle)? $pagetitle." - " : "";?><?php echo $this->helper->get_config("website_name");?></title>
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800&display=swap" rel="stylesheet">
      <link rel="shortcut icon" href="<?php echo $template_path; ?>/assets/images/logo.png">

<link rel="stylesheet" href="<?php echo $template_path; ?>/backend/assets/css/bootstrap.min.css">

<link rel="stylesheet" href="<?php echo $template_path; ?>/backend/assets/plugins/fontawesome/css/fontawesome.min.css">
<link rel="stylesheet" href="<?php echo $template_path; ?>/backend/assets/plugins/fontawesome/css/all.min.css">
<link rel="stylesheet" href="<?php echo $template_path; ?>/backend/assets/plugins/fullcalendar/fullcalendar.min.css">
<link href="<?php echo $template_path;?>/backend/assets/plugins/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?php echo $template_path; ?>/backend/assets/plugins/select2/css/select2.min.css">

<link rel="stylesheet" href="<?php echo $template_path; ?>/backend/assets/plugins/datatables/datatables.min.css">

<link rel="stylesheet" href="<?php echo $template_path; ?>/backend/assets/css/bootstrap-datetimepicker.min.css">

<link rel="stylesheet" href="<?php echo $template_path; ?>/backend/assets/css/style.css">
      <!--[if lt IE 9]>
      <script src="<?php echo $template_path; ?>/backend/assets/js/html5shiv.min.js"></script>
      <script src="<?php echo $template_path; ?>/backend/assets/js/respond.min.js"></script>
      <![endif]-->
<!-- CSS -->

<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css"> -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.26.3/dist/sweetalert2.min.css">
<style>
/* Chuẩn hóa giao diện SweetAlert2 trung tâm cao cấp */
.swal2-container {
    z-index: 100200 !important;
    background: rgba(15, 23, 42, 0.48) !important;
    backdrop-filter: blur(5px) !important;
    -webkit-backdrop-filter: blur(5px) !important;
}
.swal2-container .swal2-popup {
    background: #ffffff !important;
    border-radius: 20px !important;
    padding: 30px 24px 24px !important;
    width: calc(100% - 32px) !important;
    max-width: 400px !important;
    margin: 0 auto !important;
    box-shadow: 0 20px 45px -10px rgba(15, 23, 42, 0.22), 0 0 0 1px rgba(15, 23, 42, 0.06) !important;
    border: none !important;
    overflow: hidden !important;
    position: relative !important;
    box-sizing: border-box !important;
    text-align: center !important;
}
.swal2-container .swal2-icon {
    width: 62px !important;
    height: 62px !important;
    margin: 0 auto 16px !important;
    border-width: 3px !important;
    border-style: solid !important;
    box-sizing: border-box !important;
    position: relative !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    zoom: 1 !important;
}
.swal2-container .swal2-icon.swal2-success .swal2-success-circular-line-left,
.swal2-container .swal2-icon.swal2-success .swal2-success-circular-line-right,
.swal2-container .swal2-icon.swal2-success .swal2-success-fix,
.swal2-container .swal2-icon.swal2-success .swal2-success-ring {
    display: none !important;
}
.swal2-container .swal2-icon.swal2-success {
    border-color: #10b981 !important;
    color: #10b981 !important;
}
.swal2-container .swal2-icon.swal2-success [class^='swal2-success-line'] {
    background-color: #10b981 !important;
    height: 3.5px !important;
    border-radius: 2px !important;
    display: block !important;
    position: absolute !important;
    z-index: 2 !important;
}
.swal2-container .swal2-icon.swal2-success .swal2-success-line-tip {
    top: 32px !important;
    left: 12px !important;
    width: 18px !important;
    transform: rotate(45deg) !important;
}
.swal2-container .swal2-icon.swal2-success .swal2-success-line-long {
    top: 28px !important;
    right: 8px !important;
    width: 31px !important;
    transform: rotate(-45deg) !important;
}
.swal2-container .swal2-icon.swal2-error {
    border-color: #ef4444 !important;
    color: #ef4444 !important;
    position: relative !important;
}
.swal2-container .swal2-icon.swal2-error .swal2-x-mark {
    display: block !important;
    position: absolute !important;
    inset: 0 !important;
    width: 100% !important;
    height: 100% !important;
    margin: 0 !important;
    padding: 0 !important;
}
.swal2-container .swal2-icon.swal2-error .swal2-x-mark-line-left {
    display: block !important;
    position: absolute !important;
    top: 50% !important;
    left: 50% !important;
    width: 28px !important;
    height: 3.5px !important;
    margin: 0 !important;
    border-radius: 2px !important;
    background-color: #ef4444 !important;
    transform: translate(-50%, -50%) rotate(45deg) !important;
}
.swal2-container .swal2-icon.swal2-error .swal2-x-mark-line-right {
    display: block !important;
    position: absolute !important;
    top: 50% !important;
    left: 50% !important;
    width: 28px !important;
    height: 3.5px !important;
    margin: 0 !important;
    border-radius: 2px !important;
    background-color: #ef4444 !important;
    transform: translate(-50%, -50%) rotate(-45deg) !important;
}
.swal2-container .swal2-title {
    font-family: inherit !important;
    font-size: 16.5px !important;
    font-weight: 700 !important;
    color: #0f172a !important;
    line-height: 1.45 !important;
    margin: 0 !important;
    padding: 0 !important;
    text-align: center !important;
}
.swal2-container .swal2-html-container {
    font-family: inherit !important;
    font-size: 14px !important;
    color: #64748b !important;
    line-height: 1.55 !important;
    margin: 8px 0 0 !important;
    padding: 0 !important;
    text-align: center !important;
}
.swal2-container .swal2-actions button.swal2-confirm {
    background: #1760a5 !important;
    color: #ffffff !important;
    border: none !important;
    border-radius: 10px !important;
    font-size: 14px !important;
    font-weight: 600 !important;
    padding: 10px 26px !important;
    box-shadow: 0 4px 14px rgba(23, 96, 165, 0.25) !important;
}
.swal2-container .swal2-timer-progress-bar {
    background: #10b981 !important;
    height: 3px !important;
    border-radius: 0 0 20px 20px !important;
}
.swal2-container .swal2-popup.swal2-icon-error .swal2-timer-progress-bar {
    background: #ef4444 !important;
}
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


<script src="<?php echo $template_path; ?>/backend/assets/js/jquery-3.6.0.min.js"></script>

<script src="<?php echo $template_path; ?>/backend/assets/js/popper.min.js"></script>
<script src="<?php echo $template_path; ?>/backend/assets/js/bootstrap.min.js"></script>

<script src="<?php echo $template_path; ?>/backend/assets/js/feather.min.js"></script>

<script src="<?php echo $template_path; ?>/backend/assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>

<script src="<?php echo $template_path; ?>/backend/assets/plugins/select2/js/select2.min.js"></script>

<script src="<?php echo $template_path; ?>/backend/assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo $template_path; ?>/backend/assets/plugins/datatables/datatables.min.js"></script>
<script src="<?php echo $template_path; ?>/backend/assets/js/jquery-ui.min.js"></script>
<script src="<?php echo $template_path; ?>/backend/assets/plugins/moment/moment.min.js"></script>
<script src="<?php echo $template_path; ?>/backend/assets/js/bootstrap-datetimepicker.min.js"></script>
<script src="<?php echo $template_path; ?>/backend/assets/js/number.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.26.3/dist/sweetalert2.all.min.js"></script>
 <script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/super-build/ckeditor.js"></script>

<script>
   $(document).ready(function() {
    CKEDITOR.ClassicEditor.create(document.querySelector('textarea[name="content"]'), {
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

        // 2. KHẮC PHỤC TRIỆT ĐỂ: Loại bỏ AI và Cloud Plugins
        removePlugins: [
            // Các plugin AI (Gây lỗi ai-invalid-license-key)
            'AIAssistant', 
            'OpenAIAssistant',
            'CKBox', 
            'CKFinder', 
            'EasyImage', 
            'Base64UploadAdapter',
            
            // Các plugin Collaboration & Premium (Gây lỗi channel-id)
            'ExportPdf', 'ExportWord', 'Pagination', 'WProofreader', 'MathType',
            'RealTimeCollaborativeComments', 'RealTimeCollaborativeTrackChanges', 
            'RealTimeCollaborativeRevisionHistory', 'PresenceList', 'Comments', 
            'TrackChanges', 'TrackChangesData', 'RevisionHistory',
            'SlashCommand', 'Template', 'DocumentOutline', 'FormatPainter', 
            'TableOfContents', 'PasteFromOfficeEnhanced'
        ],

        // 3. Các cấu hình bổ trợ
        language: 'vi',
        placeholder: 'Nhập nội dung tại đây...',
        fontSize: {
            options: [ 10, 12, 14, 'default', 18, 20, 22 ],
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
        console.error('Lỗi khởi tạo:', error);
    });


      
   });
   // function getContent() {
   //     var content = $('#summernote_gioithieu').summernote('code');
   //    //  alert("Dữ liệu HTML bạn vừa nhập:\n" + content);
   //    //  console.log(content);
   // }

   
</script>

<link rel="stylesheet" href="<?php echo $template_path; ?>/backend/assets/css/admin-controls.css?v=<?php echo filemtime(__DIR__ . '/assets/css/admin-controls.css'); ?>">
   </head>
   <body>
      <div class="main-wrapper">
         <div class="header">
            <div class="header-left">
               <a href="<?php echo XC_URL;?> " class="logo" style="font-size: 10px;">
               <img src="<?php echo $template_path; ?>/assets/images/logo.png" alt="Logo">  
             
               </a>
               <a href="<?php echo XC_URL;?> " class="logo logo-small">
               <img src="<?php echo $template_path; ?>/assets/images/logo.png" alt="Logo" width="30" height="30">
               </a>
            </div>
            <a href="javascript:void(0);" id="toggle_btn">
            <i class="fas fa-bars"></i>
            </a>
            <div class="top-nav-search">
               <form>
                  <input type="text" class="form-control" placeholder="Search here">
                  <button class="btn" type="submit"><i class="fas fa-search"></i></button>
               </form>
            </div>
            <a class="mobile_btn" id="mobile_btn">
            <i class="fas fa-bars"></i>
            </a>
            <ul class="nav nav-tabs user-menu">
              
               <!--<li class="nav-item dropdown">-->
               <!--   <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">-->
               <!--   <i data-feather="bell"></i> <span class="badge rounded-pill">5</span>-->
               <!--   </a>-->
               <!--   <div class="dropdown-menu notifications">-->
               <!--      <div class="topnav-dropdown-header">-->
               <!--         <span class="notification-title">Notifications</span>-->
               <!--         <a href="javascript:void(0)" class="clear-noti"> Clear All</a>-->
               <!--      </div>-->
               <!--      <div class="noti-content">-->
               <!--         <ul class="notification-list">-->
               <!--            <li class="notification-message">-->
               <!--               <a href="activities.html">-->
               <!--                  <div class="media d-flex">-->
               <!--                     <span class="avatar avatar-sm">-->
               <!--                     <img class="avatar-img rounded-circle" alt="" src="<?php echo $template_path; ?>/backend/assets/img/profiles/avatar-02.jpg">-->
               <!--                     </span>-->
               <!--                     <div class="media-body">-->
               <!--                        <p class="noti-details"><span class="noti-title">Brian Johnson</span> paid the invoice <span class="noti-title">#DF65485</span></p>-->
               <!--                        <p class="noti-time"><span class="notification-time">4 mins ago</span></p>-->
               <!--                     </div>-->
               <!--                  </div>-->
               <!--               </a>-->
               <!--            </li>-->
               <!--            <li class="notification-message">-->
               <!--               <a href="activities.html">-->
               <!--                  <div class="media d-flex">-->
               <!--                     <span class="avatar avatar-sm">-->
               <!--                     <img class="avatar-img rounded-circle" alt="" src="<?php echo $template_path; ?>/backend/assets/img/profiles/avatar-03.jpg">-->
               <!--                     </span>-->
               <!--                     <div class="media-body">-->
               <!--                        <p class="noti-details"><span class="noti-title">Marie Canales</span> has accepted your estimate <span class="noti-title">#GTR458789</span></p>-->
               <!--                        <p class="noti-time"><span class="notification-time">6 mins ago</span></p>-->
               <!--                     </div>-->
               <!--                  </div>-->
               <!--               </a>-->
               <!--            </li>-->
               <!--            <li class="notification-message">-->
               <!--               <a href="activities.html">-->
               <!--                  <div class="media d-flex">-->
               <!--                     <div class="avatar avatar-sm">-->
               <!--                        <span class="avatar-title rounded-circle bg-primary-light"><i class="far fa-user"></i></span>-->
               <!--                     </div>-->
               <!--                     <div class="media-body">-->
               <!--                        <p class="noti-details"><span class="noti-title">New user registered</span></p>-->
               <!--                        <p class="noti-time"><span class="notification-time">8 mins ago</span></p>-->
               <!--                     </div>-->
               <!--                  </div>-->
               <!--               </a>-->
               <!--            </li>-->
               <!--            <li class="notification-message">-->
               <!--               <a href="activities.html">-->
               <!--                  <div class="media d-flex">-->
               <!--                     <span class="avatar avatar-sm">-->
               <!--                     <img class="avatar-img rounded-circle" alt="" src="<?php echo $template_path; ?>/backend/assets/img/profiles/avatar-04.jpg">-->
               <!--                     </span>-->
               <!--                     <div class="media-body">-->
               <!--                        <p class="noti-details"><span class="noti-title">Barbara Moore</span> declined the invoice <span class="noti-title">#RDW026896</span></p>-->
               <!--                        <p class="noti-time"><span class="notification-time">12 mins ago</span></p>-->
               <!--                     </div>-->
               <!--                  </div>-->
               <!--               </a>-->
               <!--            </li>-->
               <!--            <li class="notification-message">-->
               <!--               <a href="activities.html">-->
               <!--                  <div class="media d-flex">-->
               <!--                     <div class="avatar avatar-sm">-->
               <!--                        <span class="avatar-title rounded-circle bg-info-light"><i class="far fa-comment"></i></span>-->
               <!--                     </div>-->
               <!--                     <div class="media-body">-->
               <!--                        <p class="noti-details"><span class="noti-title">You have received a new message</span></p>-->
               <!--                        <p class="noti-time"><span class="notification-time">2 days ago</span></p>-->
               <!--                     </div>-->
               <!--                  </div>-->
               <!--               </a>-->
               <!--            </li>-->
               <!--         </ul>-->
               <!--      </div>-->
               <!--      <div class="topnav-dropdown-footer">-->
               <!--         <a href="activities.html">View all Notifications</a>-->
               <!--      </div>-->
               <!--   </div>-->
               <!--</li>-->
               <li class="nav-item dropdown has-arrow main-drop">
                  <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
                  <span class="user-img">
                  <img src="<?php echo $template_path; ?>/backend/assets/img/profiles/avatar-01.jpg" alt="">
                  <span class="status online"></span>
                  </span>
                  <span><?php if(isset($_SESSSION['user']['id']) && $_SESSSION['user']['id'] != ''){
					  echo $_SESSSION['user']['username_fullname'];
				  }?></span>
                  </a>
                  <div class="dropdown-menu">
                     <a class="dropdown-item" href="<?php echo XC_URL;?>/admin/setting"><i data-feather="settings" class="me-1"></i> Thông tin đơn vị</a>
                     <a class="dropdown-item" href="<?php echo XC_URL;?>/admin/socialsettings"><i data-feather="share-2" class="me-1"></i> Đăng nhập MXH</a>
                     <a class="dropdown-item" href="<?php echo XC_URL;?>/admin/setting?type=change-password"><i data-feather="lock" class="me-1"></i> Đổi mật khẩu</a>
                     <a class="dropdown-item" href="<?php echo XC_URL;?>/logout"><i data-feather="log-out" class="me-1"></i> Logout</a>
                  </div>
               </li>
            </ul>
         </div>
         <div class="sidebar" id="sidebar">
            <div class="sidebar-inner slimscroll">
               <div id="sidebar-menu" class="sidebar-menu">
                  <ul>
                     <li class="menu-title"><span>Tính năng</span></li>
                     <li class="<?php echo ($active_menu == "dashboard")? "active" : "";?>">
                        <a href="<?php echo XC_URL;?>/admin"><i data-feather="home"></i> <span>Tổng quan</span></a>
                     </li>
                      <li class="<?php echo ($active_menu == "calendar")? "active" : "";?>">
                        <a href="<?php echo XC_URL;?>/admin/bookings"><i data-feather="calendar"></i> <span>Lịch hẹn khám</span></a>
                     </li>
					 
                     <li >
                        <a href="<?php echo XC_URL;?>/admin/events"><i data-feather="credit-card"></i> <span>Tin tức & sự kiện</span> </a>
                        
                     </li>
                     
                      <li>
                     <a href="<?php echo XC_URL?>/app/employees"><i data-feather="user-check"></i> <span>Bác sĩ</span></a>
                     </li>
                    
                     <li class="<?php echo ($active_menu == "booking_internal")? "active" : "";?>">
                        <a href="<?php echo XC_URL;?>/admin/booking_internal"><i data-feather="shopping-bag"></i> <span>Đơn thuốc nội bộ</span></a>
                     </li>
                     <li class="<?php echo ($active_menu == "customers")? "active" : "";?>">
                        <a href="<?php echo XC_URL;?>/admin/customers"><i data-feather="users"></i> <span>Quản lý Khách hàng</span></a>
                     </li>
                     <li>
                        <a href="<?php echo XC_URL?>/admin/products"><i data-feather="plus-square"></i> <span>Nhà thuốc</span></a>
                     </li>
                      <li class="submenu"> 
                        <a href="#"><i data-feather="slack"></i> <span>Dịch vụ Phòng khám</span> <span class="menu-arrow"></span></a>
                        <ul>
                           <li><a href="<?php echo XC_URL?>/admin/service/6"> Khám chữa bệnh dịch vụ</a></li>
                            <li><a href="<?php echo XC_URL?>/admin/service/7">Khám chữa bệnh BHYT</a></li>
                        </ul>
                         
                     </li>
                     <li class="menu-title">
                        <span>Hệ thống</span>
                     </li>
                      <li class="submenu <?php echo (isset($active_menu) && $active_menu === 'gioithieu') ? 'active' : ''; ?>">
                          <a href="#"><i data-feather="info"></i> <span>Quản lý Giới thiệu</span> <span class="menu-arrow"></span></a>
                          <ul>
                             <li><a href="<?php echo XC_URL; ?>/admin/gioithieu" style="font-weight: 700; color: #13467d;"><i class="fas fa-list"></i> Danh sách bài giới thiệu</a></li>
                             <?php
                             global $db;
                             $db->query("SELECT * FROM hicrm_introduce WHERE (introduce_status IS NULL OR introduce_status NOT IN (99)) AND (introduce_category IN (1, 2, 3, 4, 5, 8) OR id IN (1, 2, 3, 4, 5)) ORDER BY introduce_orderby ASC, id ASC");		
                             $introItems = $db->fetch_object();
                             if (!empty($introItems)) {
                                 foreach($introItems as $introItem){
                             ?>
                             <li><a href="<?php echo XC_URL; ?>/admin/gioithieu/<?php echo $introItem->id; ?>"><?php echo htmlspecialchars($introItem->introduce_name, ENT_QUOTES, 'UTF-8'); ?></a></li>
                             <?php }} ?>
                          </ul>
                       </li>
                      <li class="submenu <?php echo (isset($active_menu) && $active_menu === 'chinhsach') ? 'active' : ''; ?>">
                          <a href="#"><i data-feather="file-text"></i> <span>Quản lý Chính sách</span> <span class="menu-arrow"></span></a>
                          <ul>
                             <li><a href="<?php echo XC_URL; ?>/admin/chinhsach" style="font-weight: 700; color: #13467d;"><i class="fas fa-list"></i> Danh sách tất cả chính sách</a></li>
                             <?php
                             $db->query("SELECT * FROM hicrm_introduce WHERE (introduce_status IS NULL OR introduce_status NOT IN (99)) AND (introduce_category = 9 OR id IN (6, 8) OR (introduce_category NOT IN (1, 2, 3, 4, 5, 8, 10) AND id NOT IN (1, 2, 3, 4, 5, 7))) ORDER BY introduce_orderby ASC, id ASC");		
                             $policyItems = $db->fetch_object();
                             if (!empty($policyItems)) {
                                 foreach($policyItems as $pItem){
                             ?>
                             <li><a href="<?php echo XC_URL; ?>/admin/chinhsach/<?php echo $pItem->id; ?>"><?php echo htmlspecialchars($pItem->introduce_name, ENT_QUOTES, 'UTF-8'); ?></a></li>
                             <?php }} ?>
                          </ul>
                       </li>
                     <!-- <li class="submenu"> -->
                     <!--   <a href="#"><i data-feather="home"></i> <span>Quản trị trang chủ</span> <span class="menu-arrow"></span></a>-->
                     <!--   <ul>-->
                     <!--       <li><a href="<?php echo XC_URL?>/admin/addusers">Thêm mới người dùng</a></li> -->
                     <!--      <li><a href="<?php echo XC_URL?>/admin/users">Quản lý slider</a></li>-->
                     <!--       <li><a href="<?php echo XC_URL?>/admin/info">Quản lý banner</a></li>-->
                     <!--   </ul>-->
                         
                     <!--</li>-->
                    
                     <li class="submenu <?php echo ($active_menu == "socialsettings")? "active" : "";?>"> 
                        <a href="#"><i data-feather="pie-chart"></i> <span>Quản trị hệ thống</span> <span class="menu-arrow"></span></a>
                        <ul>
                           <!-- <li><a href="<?php echo XC_URL?>/admin/addusers">Thêm mới người dùng</a></li> -->
                           <li><a href="<?php echo XC_URL?>/admin/users">Quản lý tài khoản</a></li>
                           <li><a class="<?php echo ($active_menu == "socialsettings")? "active" : "";?>" href="<?php echo XC_URL?>/admin/socialsettings">Cấu hình Đăng nhập MXH</a></li>
                            <li><a href="<?php echo XC_URL?>/admin/lichcongtac">Lịch công tác</a></li>
                            <li><a href="<?php echo XC_URL?>/admin/feedback">Phản hồi của khách hàng</a></li>
                        </ul>
                         
                     </li>
                      <li class="submenu"> 
                        <a href="#"><i data-feather="layers"></i> <span>Quản trị danh mục</span> <span class="menu-arrow"></span></a>
                        <ul>
                           <li><a  href="<?php echo XC_URL?>/admin/categories/products">Quản lý loại thuốc </a></li>
                           <li><a href="<?php echo XC_URL;?>/admin/dmimages">Danh mục hình ảnh</a></li>   
                           <li><a href="<?php echo XC_URL?>/admin/categories/general">Quản lý danh mục chung</a></li> 
                        </ul>
                         
                     </li>
					 <li class="<?php echo ($active_menu == "settings")? "active" : "";?>">
                        <a href="<?php echo XC_URL;?>/admin/setting"><i data-feather="settings"></i> <span>Thông tin đơn vị</span></a>
                     </li>
					 <li class="<?php echo ($active_menu == "socialsettings")? "active" : "";?>">
                        <a href="<?php echo XC_URL;?>/admin/socialsettings"><i data-feather="share-2"></i> <span>Đăng nhập Mạng xã hội</span></a>
                     </li>
                     <li class="<?php echo (isset($type) && $type == "change-password")? "active" : "";?>">
                        <a href="<?php echo XC_URL;?>/admin/setting?type=change-password"><i data-feather="lock"></i> <span>Đổi mật khẩu</span></a>
                     </li>
                  </ul>
               </div>
            </div>
         </div>
		 <div class="page-wrapper">
