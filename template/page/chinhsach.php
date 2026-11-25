<?php include "header_new.php";?>
</section>

<!-- BREADCRUMBS -->
<div id="breadcrumbs">
   <div class="ctn">
      <div id="crumbs">
         <a href="<?php echo XC_URL; ?>"><i class="fa-solid fa-house"></i> Trang chủ</a> 
         <span>/</span> 
         <a href="<?php echo XC_URL; ?>/chinhsach">Chính sách &amp; Quy định</a>
         <span>/</span> 
         <a class="current"><?php echo htmlspecialchars($introduce->introduce_name ?? 'Chính sách nhà thuốc', ENT_QUOTES, 'UTF-8'); ?></a>
      </div>
   </div>
</div>

<!-- NỘI DUNG CHÍNH SÁCH NHÀ THUỐC (THIẾT KẾ 2 CỘT CHUẨN LONG CHÂU) -->
<div class="ctn policy-page-wrap">
   <div class="policy-layout">
      
      <!-- CỘT TRÁI: DANH MỤC CÁC CHÍNH SÁCH (SIDEBAR) -->
      <aside class="policy-sidebar">
         <div class="policy-sidebar-card">
            <div class="policy-sidebar-header">
               <i class="fa-solid fa-file-shield policy-header-icon" aria-hidden="true"></i>
               <span>Chính sách &amp; Quy định</span>
            </div>

            <nav class="policy-nav-wrap" aria-label="Danh mục chính sách">
               <ul class="policy-nav-list">
                  <?php 
                  if (!empty($policy_items)) {
                     foreach ($policy_items as $pItem) {
                        $isActive = ((int)$pItem->id === (int)$id);
                        $slug = $this->helper->bodau($pItem->introduce_name);
                        $pUrl = XC_URL . '/chinhsach/' . $pItem->id . '-' . $slug . '.html';
                  ?>
                  <li class="policy-nav-li">
                     <a href="<?php echo $pUrl; ?>" class="policy-nav-item <?php echo $isActive ? 'active' : ''; ?>">
                        <span class="policy-item-text"><?php echo htmlspecialchars($pItem->introduce_name, ENT_QUOTES, 'UTF-8'); ?></span>
                        <?php if ($isActive) { ?>
                        <i class="fa-solid fa-chevron-right policy-active-arrow" aria-hidden="true"></i>
                        <?php } ?>
                     </a>
                  </li>
                  <?php 
                     }
                  }
                  ?>
               </ul>
            </nav>
         </div>
      </aside>

      <!-- CỘT PHẢI: NỘI DUNG CHI TIẾT CHÍNH SÁCH -->
      <main class="policy-main-content">
         <article class="policy-article-card">
            <header class="policy-article-header">
               <h1 class="policy-article-title">
                  <?php echo htmlspecialchars($introduce->introduce_name ?? 'Chính sách nhà thuốc', ENT_QUOTES, 'UTF-8'); ?>
               </h1>
            </header>

            <div class="policy-article-body">
               <?php echo $introduce->introduce_content ?? '<p>Nội dung chính sách đang được cập nhật...</p>'; ?>
            </div>
         </article>
      </main>

   </div>
</div>

</main>

<style>
/* ========================================================
   GIAO DIỆN TRANG CHÍNH SÁCH NHÀ THUỐC
   Thiết kế 2 cột chuẩn mực, thanh lịch theo mẫu FPT Long Châu
   ======================================================== */
.policy-page-wrap {
   max-width: 1270px !important;
   width: 100%;
   margin-top: 24px;
   margin-bottom: 50px;
   box-sizing: border-box;
}

.policy-layout {
   display: flex;
   flex-direction: column;
   gap: 24px;
   align-items: flex-start;
}

@media (min-width: 992px) {
   .policy-layout {
      flex-direction: row;
      gap: 28px;
   }
   .policy-sidebar {
      flex: 0 0 310px;
      width: 310px;
      position: sticky;
      top: 110px;
   }
   .policy-main-content {
      flex: 1 1 auto;
      min-width: 0;
   }
}

/* 1. SIDEBAR CỘT TRÁI */
.policy-sidebar-card {
   background: #ffffff;
   border: 1px solid #e2e8f0;
   border-radius: 12px;
   box-shadow: 0 1px 4px rgba(0, 0, 0, 0.04);
   overflow: hidden;
}

.policy-sidebar-header {
   padding: 16px 20px;
   background: #f8fafc;
   border-bottom: 1px solid #e2e8f0;
   display: flex;
   align-items: center;
   gap: 10px;
   font-size: 15px;
   font-weight: 700;
   color: #1e293b;
   line-height: 1.3;
}

.policy-header-icon {
   color: #155191;
   font-size: 16px;
}

.policy-nav-list {
   list-style: none;
   margin: 0;
   padding: 6px 0;
}

.policy-nav-li {
   margin: 0;
   padding: 0;
}

.policy-nav-item {
   display: flex;
   align-items: center;
   justify-content: space-between;
   gap: 10px;
   padding: 12px 20px;
   color: #475569;
   font-size: 14px;
   line-height: 1.45;
   text-decoration: none;
   transition: all 0.15s ease;
   border-left: 3px solid transparent;
}

.policy-nav-item:hover {
   background: #f8fafc;
   color: #155191;
   text-decoration: none;
}

.policy-nav-item.active {
   background: #eff6ff;
   color: #155191;
   font-weight: 700;
   border-left-color: #155191;
}

.policy-item-text {
   flex: 1;
   min-width: 0;
   word-break: break-word;
}

.policy-active-arrow {
   font-size: 12px;
   color: #155191;
   flex-shrink: 0;
}

/* 2. KHỐI NỘI DUNG BÀI VIẾT CỘT PHẢI */
.policy-article-card {
   background: #ffffff;
   border: 1px solid #e2e8f0;
   border-radius: 12px;
   padding: 32px 36px;
   box-shadow: 0 1px 4px rgba(0, 0, 0, 0.04);
   box-sizing: border-box;
}

@media (max-width: 768px) {
   .policy-article-card {
      padding: 20px 18px;
   }
}

.policy-article-header {
   margin-bottom: 24px;
   padding-bottom: 16px;
   border-bottom: 1px solid #f1f5f9;
}

.policy-article-title {
   font-size: 26px;
   font-weight: 800;
   color: #0f172a;
   line-height: 1.35;
   margin: 0;
}

@media (max-width: 768px) {
   .policy-article-title {
      font-size: 21px;
   }
}

/* Nội dung định dạng HTML từ CKEditor */
.policy-article-body {
   font-size: 15px;
   line-height: 1.75;
   color: #334155;
   word-break: break-word;
}

.policy-article-body h2,
.policy-article-body h3,
.policy-article-body h4 {
   color: #0f172a;
   font-weight: 700;
   margin-top: 26px;
   margin-bottom: 12px;
   line-height: 1.4;
}

.policy-article-body h2 { font-size: 20px; }
.policy-article-body h3 { font-size: 17.5px; }
.policy-article-body h4 { font-size: 15.5px; }

.policy-article-body p {
   margin-bottom: 14px;
}

.policy-article-body strong {
   color: #0f172a;
   font-weight: 600;
}

.policy-article-body ul,
.policy-article-body ol {
   margin-bottom: 16px;
   padding-left: 24px;
}

.policy-article-body li {
   margin-bottom: 8px;
   line-height: 1.65;
}

.policy-article-body a {
   color: #155191;
   text-decoration: underline;
   font-weight: 600;
}

.policy-article-body a:hover {
   color: #0c3666;
}

.policy-article-body table {
   width: 100%;
   border-collapse: collapse;
   margin: 18px 0;
   font-size: 14px;
}

.policy-article-body table th,
.policy-article-body table td {
   border: 1px solid #cbd5e1;
   padding: 10px 14px;
   text-align: left;
}

.policy-article-body table th {
   background: #f1f5f9;
   font-weight: 700;
   color: #1e293b;
}

/* 3. KHỐI THÔNG TIN HỖ TRỢ CUỐI TRANG */
.policy-support-callout {
   margin-top: 36px;
   padding: 18px 22px;
   background: #f8fafc;
   border: 1px solid #e2e8f0;
   border-left: 4px solid #155191;
   border-radius: 8px;
   display: flex;
   align-items: flex-start;
   gap: 16px;
}

.policy-support-ico {
   width: 40px;
   height: 40px;
   border-radius: 50%;
   background: #eff6ff;
   color: #155191;
   display: flex;
   align-items: center;
   justify-content: center;
   font-size: 18px;
   flex-shrink: 0;
   margin-top: 2px;
}

.policy-support-body {
   flex: 1;
   min-width: 0;
}

.policy-support-heading {
   display: block;
   font-size: 14.5px;
   color: #0f172a;
   margin-bottom: 4px;
}

.policy-support-text {
   margin: 0;
   font-size: 13.5px;
   color: #475569;
   line-height: 1.6;
}

.policy-phone-link {
   color: #155191;
   font-weight: 700;
   text-decoration: none;
}

.policy-phone-link:hover {
   text-decoration: underline;
}
</style>

<?php include "footer_new.php";?>