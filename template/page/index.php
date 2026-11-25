<?php include "header_new.php"; ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<style>
   .date-input {
    position: relative;
    width: 100%;
}

.date-input input {
    width: 100%;
    padding-right: 42px; /* chừa chỗ icon */
}

.calendar-icon {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 16px;
    color: #60a5fa;
    cursor: pointer;
    pointer-events: auto;
}
</style>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    const ngayKhamEl = document.querySelector("#ngaykham");
    if (ngayKhamEl) {
        const fp = flatpickr(ngayKhamEl, {
            dateFormat: "d/m",
            allowInput: false,
            clickOpens: true,
            disableMobile: true
        });
        ngayKhamEl.addEventListener("click", function () {
            fp.open();
        });
    }
</script>
</section>    

<!-- ========================================================
     SLIDER SẢN PHẨM MỚI NHẤT (STT 6)
     ======================================================== -->
<section id="sec-new-products" class="hp-section hp-section-products">
   <div class="ctn">
      <div class="hp-sec-header">
         <div class="hp-sec-title-wrap">
            <span class="hp-badge hp-badge-orange"><i class="fa-solid fa-sparkles"></i> Mới cập nhật</span>
            <h2 class="hp-sec-title">Sản phẩm mới nhất</h2>
            <p class="hp-sec-subtitle">Thuốc, thiết bị y tế và sản phẩm chăm sóc sức khỏe chất lượng cao</p>
         </div>
         <div class="hp-slider-controls">
            <button type="button" class="hp-nav-btn hp-nav-prev" aria-label="Sản phẩm trước">
               <i class="fa-solid fa-chevron-left"></i>
            </button>
            <button type="button" class="hp-nav-btn hp-nav-next" aria-label="Sản phẩm kế tiếp">
               <i class="fa-solid fa-chevron-right"></i>
            </button>
         </div>
      </div>

      <?php if (!empty($new_products)) { ?>
      <div class="hp-products-slider" id="homeNewProductsSlider">
         <?php foreach ($new_products as $pro) { 
            $price = (float)$pro->product_price;
            $discount = (int)$pro->product_discount;
            $priceAfter = $discount > 0 ? ($price * (100 - $discount) / 100) : $price;
            $isPrescription = ($price <= 0);
            $displayPrice = ($priceAfter > 0) ? number_format($priceAfter, 0, ',', '.') . 'đ' : 'Liên hệ';
            $proImage = !empty($pro->product_image) ? XC_URL . "/uploads/products/" . $pro->product_image : $template_path . "/assets/images/logo.png";
            $detailUrl = $this->helper->permalink($pro->pid, 'product_detail');
         ?>
         <div class="hp-slider-item">
            <article class="hp-pro-card">
               <?php if ($discount > 0) { ?>
                  <span class="hp-pro-badge-discount">-<?php echo $discount; ?>%</span>
               <?php } else { ?>
                  <span class="hp-pro-badge-new">Mới</span>
               <?php } ?>

               <a href="<?php echo $detailUrl; ?>" class="hp-pro-thumb">
                  <img src="<?php echo $proImage; ?>" alt="<?php echo htmlspecialchars($pro->product_name, ENT_QUOTES, 'UTF-8'); ?>" loading="lazy">
               </a>

               <div class="hp-pro-info">
                  <span class="hp-pro-cat"><?php echo !empty($pro->category_name) ? htmlspecialchars($pro->category_name, ENT_QUOTES, 'UTF-8') : 'Nhà thuốc'; ?></span>
                  <h3 class="hp-pro-title">
                     <a href="<?php echo $detailUrl; ?>" title="<?php echo htmlspecialchars($pro->product_name, ENT_QUOTES, 'UTF-8'); ?>">
                        <?php echo htmlspecialchars($pro->product_name, ENT_QUOTES, 'UTF-8'); ?>
                     </a>
                  </h3>
                  
                  <?php if (!empty($pro->product_spec)) { ?>
                     <div class="hp-pro-spec"><?php echo htmlspecialchars($pro->product_spec, ENT_QUOTES, 'UTF-8'); ?></div>
                  <?php } elseif (!empty($pro->unit_name)) { ?>
                     <div class="hp-pro-spec">ĐVT: <?php echo htmlspecialchars($pro->unit_name, ENT_QUOTES, 'UTF-8'); ?></div>
                  <?php } else { ?>
                     <div class="hp-pro-spec">&nbsp;</div>
                  <?php } ?>

                  <div class="hp-pro-price-box">
                     <?php if ($isPrescription) { ?>
                        <span class="hp-pro-price-contact"><i class="fa-solid fa-file-prescription"></i> Thuốc kê đơn</span>
                     <?php } else { ?>
                        <?php if ($discount > 0 && $price > 0 && $priceAfter > 0) { ?>
                           <span class="hp-pro-price-old"><?php echo number_format($price, 0, ',', '.'); ?>đ</span>
                        <?php } ?>
                        <span class="hp-pro-price-current"><?php echo $displayPrice; ?></span>
                     <?php } ?>
                  </div>

                  <div class="hp-pro-actions">
                     <?php if ($cartEnabled && !$isPrescription) { ?>
                        <button type="button" class="hp-btn-cart js-add-to-cart" data-product-id="<?php echo (int)$pro->pid; ?>" title="Thêm vào giỏ hàng">
                           <i class="fa-solid fa-cart-plus"></i>
                           <span>Thêm giỏ</span>
                        </button>
                     <?php } else { ?>
                        <a href="<?php echo $detailUrl; ?>" class="hp-btn-detail" title="Xem chi tiết & tư vấn">
                           <i class="fa-solid fa-circle-info"></i>
                           <span>Tư vấn</span>
                        </a>
                     <?php } ?>
                     <a href="<?php echo $detailUrl; ?>" class="hp-btn-quickview" title="Xem chi tiết">
                        <i class="fa-solid fa-arrow-right"></i>
                     </a>
                  </div>
               </div>
            </article>
         </div>
         <?php } ?>
      </div>
      <?php } ?>
   </div>
</section>

<style>
/* CSS NÂNG CẤP TRANG CHỦ: DANH MỤC & SLIDER SẢN PHẨM MỚI */
/* Chuẩn hóa Banner Top: gom gọn trong khung container chuẩn, thu nhỏ chiều cao vừa vặn */
#slider {
   width: 100%;
   position: relative;
   margin: 12px 0 20px 0;
}
#slider .is_pc {
   max-width: 1270px;
   margin: 0 auto;
   padding: 0 10px;
   box-sizing: border-box;
}
#slider .is_pc .slider {
   width: 100%;
   margin: 0;
   border-radius: 16px;
   overflow: hidden;
   box-shadow: 0 8px 24px rgba(21, 81, 145, 0.08);
   border: 1px solid #e2e8f0;
}
#slider .is_pc .slider a {
   display: block;
   width: 100%;
   outline: none;
   background: #f8fafc;
}
#slider .is_pc .slider img {
   width: 100%;
   height: auto;
   max-height: 400px;
   display: block;
   object-fit: cover;
   object-position: center;
}

#slider .is_mobi {
   width: 100%;
}
#slider .is_mobi .slider {
   width: 100%;
   margin: 0;
}
#slider .is_mobi .slider img {
   width: 100%;
   height: auto;
   max-height: 220px;
   object-fit: cover;
}

.hp-section {
   position: relative;
   width: 100%;
}
.hp-section-products {
   background: #ffffff;
   border-bottom: 1px solid #f1f5f9;
   padding: 32px 0 42px 0;
}
.hp-sec-header {
   display: flex;
   align-items: flex-end;
   justify-content: space-between;
   gap: 15px;
   margin-bottom: 20px;
   flex-wrap: wrap;
}
.hp-badge {
   display: inline-flex;
   align-items: center;
   gap: 6px;
   font-size: 12px;
   font-weight: 700;
   text-transform: uppercase;
   letter-spacing: 0.5px;
   padding: 4px 10px;
   border-radius: 999px;
   background: #e0f2fe;
   color: #0284c7;
}
.hp-badge-orange {
   background: #ffedd5;
   color: #ea580c;
}
.hp-sec-title {
   font-size: 22px;
   font-weight: 800;
   color: #155191;
   margin: 4px 0 0 0;
   line-height: 1.25;
}
.hp-sec-subtitle {
   font-size: 13.5px;
   color: #64748b;
   margin: 4px 0 0 0;
}
.hp-view-all {
   display: inline-flex;
   align-items: center;
   gap: 8px;
   font-size: 13.5px;
   font-weight: 600;
   color: #155191;
   text-decoration: none;
   padding: 7px 15px;
   border-radius: 10px;
   border: 1.5px solid #dbeafe;
   background: #ffffff;
   transition: all 0.2s ease;
}
.hp-view-all:hover {
   background: #155191;
   color: #ffffff;
   border-color: #155191;
}

/* SLIDER ĐIỀU KHIỂN & SẢN PHẨM */
.hp-slider-controls {
   display: flex;
   gap: 8px;
}
.hp-nav-btn {
   width: 38px;
   height: 38px;
   border-radius: 50%;
   border: 1px solid #cbd5e1;
   background: #ffffff;
   color: #1e293b;
   display: inline-flex;
   align-items: center;
   justify-content: center;
   font-size: 14px;
   cursor: pointer;
   transition: all 0.2s ease;
   box-shadow: 0 2px 4px rgba(0,0,0,0.04);
}
.hp-nav-btn:hover {
   background: #155191;
   color: #ffffff;
   border-color: #155191;
   transform: scale(1.05);
}
.hp-products-slider {
   margin: 0 -8px;
}
.hp-slider-item {
   padding: 10px 8px;
   outline: none;
}
.hp-pro-card {
   display: flex;
   flex-direction: column;
   height: 100%;
   min-height: 350px;
   background: #ffffff;
   border: 1px solid #e2e8f0;
   border-radius: 14px;
   padding: 12px;
   position: relative;
   transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
   box-shadow: 0 2px 6px rgba(0,0,0,0.03);
}
.hp-pro-card:hover {
   transform: translateY(-4px);
   box-shadow: 0 10px 25px rgba(21, 81, 145, 0.1);
   border-color: #93c5fd;
}
.hp-pro-badge-discount {
   position: absolute;
   top: 10px;
   right: 10px;
   background: #ef4444;
   color: #ffffff;
   font-size: 11px;
   font-weight: 700;
   padding: 2px 8px;
   border-radius: 6px;
   z-index: 2;
}
.hp-pro-badge-new {
   position: absolute;
   top: 10px;
   right: 10px;
   background: #10b981;
   color: #ffffff;
   font-size: 11px;
   font-weight: 700;
   padding: 2px 8px;
   border-radius: 6px;
   z-index: 2;
}
.hp-products-slider:not(.slick-initialized) {
   display: flex;
   overflow-x: auto;
   gap: 12px;
   scrollbar-width: none;
   -webkit-overflow-scrolling: touch;
}
.hp-products-slider:not(.slick-initialized)::-webkit-scrollbar {
   display: none;
}
.hp-products-slider:not(.slick-initialized) .hp-slider-item {
   flex: 0 0 20%;
   max-width: 20%;
   box-sizing: border-box;
}
@media (max-width: 1199px) {
   .hp-products-slider:not(.slick-initialized) .hp-slider-item {
      flex: 0 0 25%;
      max-width: 25%;
   }
}
@media (max-width: 991px) {
   .hp-products-slider:not(.slick-initialized) .hp-slider-item {
      flex: 0 0 33.333%;
      max-width: 33.333%;
   }
}
@media (max-width: 767px) {
   .hp-products-slider:not(.slick-initialized) .hp-slider-item {
      flex: 0 0 50%;
      max-width: 50%;
   }
}
.hp-pro-thumb {
   display: flex;
   align-items: center;
   justify-content: center;
   width: 100%;
   height: 175px;
   max-height: 175px;
   border-radius: 10px;
   overflow: hidden;
   background: #f8fafc;
   margin: 0 auto 10px auto;
   text-align: center;
   padding: 10px;
   box-sizing: border-box;
}
.hp-pro-thumb img {
   max-width: 100%;
   max-height: 100%;
   width: auto;
   height: auto;
   object-fit: contain;
   transition: transform 0.3s ease;
}
.hp-pro-card:hover .hp-pro-thumb img {
   transform: scale(1.06);
}
.hp-pro-info {
   display: flex;
   flex-direction: column;
   flex-grow: 1;
}
.hp-pro-cat {
   font-size: 11px;
   font-weight: 600;
   text-transform: uppercase;
   color: #94a3b8;
   margin-bottom: 4px;
   white-space: nowrap;
   overflow: hidden;
   text-overflow: ellipsis;
}
.hp-pro-title {
   font-size: 13.5px;
   font-weight: 700;
   line-height: 1.35;
   margin: 0 0 6px 0;
   height: 36px;
   overflow: hidden;
   display: -webkit-box;
   -webkit-line-clamp: 2;
   -webkit-box-orient: vertical;
}
.hp-pro-title a {
   color: #1e293b;
   text-decoration: none;
   transition: color 0.2s;
}
.hp-pro-title a:hover {
   color: #155191;
}
.hp-pro-spec {
   font-size: 11.5px;
   color: #64748b;
   height: 18px;
   line-height: 18px;
   margin-bottom: 8px;
   white-space: nowrap;
   overflow: hidden;
   text-overflow: ellipsis;
}
.hp-pro-price-box {
   margin-top: auto;
   margin-bottom: 10px;
   display: flex;
   align-items: baseline;
   gap: 6px;
   flex-wrap: wrap;
}
.hp-pro-price-current {
   font-size: 15px;
   font-weight: 800;
   color: #e36928;
}
.hp-pro-price-old {
   font-size: 12px;
   color: #94a3b8;
   text-decoration: line-through;
}
.hp-pro-price-contact {
   font-size: 12px;
   font-weight: 700;
   color: #0284c7;
   background: #f0f9ff;
   padding: 4px 8px;
   border-radius: 6px;
   display: inline-flex;
   align-items: center;
   gap: 4px;
   border: 1px solid #bae6fd;
}
.hp-pro-actions {
   display: flex;
   gap: 6px;
   align-items: center;
}
.hp-btn-cart {
   flex: 1;
   display: inline-flex;
   align-items: center;
   justify-content: center;
   gap: 6px;
   background: linear-gradient(135deg, #155191 0%, #1e5ba0 100%);
   color: #ffffff;
   border: none;
   border-radius: 8px;
   padding: 8px 10px;
   font-size: 12px;
   font-weight: 700;
   cursor: pointer;
   transition: all 0.2s ease;
}
.hp-btn-cart:hover {
   background: linear-gradient(135deg, #0f3d6e 0%, #174a85 100%);
   transform: translateY(-1px);
   box-shadow: 0 4px 10px rgba(21, 81, 145, 0.25);
}
.hp-btn-detail {
   flex: 1;
   display: inline-flex;
   align-items: center;
   justify-content: center;
   gap: 6px;
   background: #f1f5f9;
   color: #1e293b;
   border: 1px solid #cbd5e1;
   border-radius: 8px;
   padding: 8px 10px;
   font-size: 12px;
   font-weight: 700;
   text-decoration: none;
   transition: all 0.2s ease;
}
.hp-btn-detail:hover {
   background: #e2e8f0;
   color: #0f172a;
}
.hp-btn-quickview {
   width: 32px;
   height: 32px;
   flex: 0 0 32px;
   display: inline-flex;
   align-items: center;
   justify-content: center;
   border-radius: 8px;
   background: #f8fafc;
   border: 1px solid #e2e8f0;
   color: #64748b;
   font-size: 12px;
   text-decoration: none;
   transition: all 0.2s ease;
}
.hp-btn-quickview:hover {
   background: #155191;
   color: #ffffff;
   border-color: #155191;
}

/* Ẩn hoàn toàn các gạch / chấm chỉ số (dots) của slider sản phẩm mới */
.hp-products-slider .slick-dots {
   display: none !important;
}

/* RESPONSIVE */
@media (max-width: 767px) {
   .hp-section-products {
      padding: 24px 0 28px 0;
   }
   .hp-sec-header {
      margin-bottom: 12px;
   }
   .hp-sec-title {
      font-size: 18px;
   }
   .hp-slider-item {
      padding: 6px 4px;
   }
   .hp-pro-card {
      min-height: 295px;
      padding: 10px 8px;
      border-radius: 12px;
   }
   .hp-pro-thumb {
      height: 125px !important;
      max-height: 125px !important;
      padding: 6px !important;
      margin-bottom: 8px;
   }
   .hp-pro-title {
      font-size: 12.5px;
      height: 34px;
      line-height: 1.35;
      margin-bottom: 4px;
   }
   .hp-pro-spec {
      font-size: 11px;
      height: 16px;
      line-height: 16px;
      margin-bottom: 6px;
   }
   .hp-pro-price-current {
      font-size: 14px;
   }
   .hp-btn-cart {
      padding: 7px 6px;
      font-size: 11.5px;
      border-radius: 6px;
   }
   .hp-btn-quickview {
      width: 28px;
      height: 28px;
      flex: 0 0 28px;
      border-radius: 6px;
      font-size: 11px;
   }
   .hp-sec-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      flex-wrap: nowrap;
      gap: 10px;
   }
   .hp-sec-title-wrap {
      flex: 1;
      min-width: 0;
   }
   .hp-slider-controls {
      display: flex !important;
      gap: 6px;
      flex-shrink: 0;
   }
   .hp-nav-btn {
      width: 32px;
      height: 32px;
      font-size: 12px;
      border-radius: 50%;
      border: 1.5px solid #dbeafe;
      background: #ffffff;
      color: #155191;
      box-shadow: 0 2px 6px rgba(21, 81, 145, 0.1);
   }
   /* Ẩn hoàn toàn dots trên mobile để tránh đè lên nút hay khối phía dưới */
   .hp-products-slider .slick-dots {
      display: none !important;
   }
}
#sec1 {
   margin-top: 15px;
   clear: both;
}
</style>

<script>
document.addEventListener("DOMContentLoaded", function () {
   var initHomeSlider = function() {
      if (window.jQuery && jQuery.fn && jQuery.fn.slick) {
         // 1. Khởi tạo Banner Top: hiển thị 1 ảnh 100% full-width, hiệu ứng fade mượt mà
         var $topSlider = jQuery('#slider .slider');
         if ($topSlider.length && !$topSlider.hasClass('slick-initialized')) {
            $topSlider.slick({
               slidesToShow: 1,
               slidesToScroll: 1,
               arrows: true,
               dots: true,
               fade: true,
               cssEase: 'linear',
               autoplay: true,
               autoplaySpeed: 5000,
               infinite: true,
               adaptiveHeight: false,
               prevArrow: '<button type="button" class="slick_arrow sbanner_prev" aria-label="Slide trước"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg></button>',
               nextArrow: '<button type="button" class="slick_arrow sbanner_next" aria-label="Slide tiếp theo"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg></button>'
            });
         }

         // 2. Khởi tạo Slider Sản phẩm mới
         var $slider = jQuery('#homeNewProductsSlider');
         if ($slider.length && !$slider.hasClass('slick-initialized')) {
            $slider.slick({
               dots: false,
               arrows: true,
               prevArrow: jQuery('.hp-nav-prev'),
               nextArrow: jQuery('.hp-nav-next'),
               infinite: true,
               speed: 400,
               slidesToShow: 5,
               slidesToScroll: 1,
               autoplay: true,
               autoplaySpeed: 4000,
               pauseOnHover: true,
               swipeToSlide: true,
               touchThreshold: 10,
               responsive: [
                  {
                     breakpoint: 1200,
                     settings: {
                        slidesToShow: 4,
                        slidesToScroll: 1,
                        dots: false
                     }
                  },
                  {
                     breakpoint: 992,
                     settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1,
                        dots: false
                     }
                  },
                  {
                     breakpoint: 768,
                     settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1,
                        arrows: true,
                        dots: false
                     }
                  },
                  {
                     breakpoint: 480,
                     settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1,
                        arrows: true,
                        dots: false
                     }
                  }
               ]
            });
         }
      } else {
         setTimeout(initHomeSlider, 60);
      }
   };
   initHomeSlider();
});
</script>

<section id="sec1">
   <div class="ctn">
      <div class="tac">
         <div class="secHead">
            <i class="fa fa-hospital"></i>
            <span>Chuyên khoa điều trị</span>
         </div>
      </div>
      <div id="sec1Wrp">
         <?php foreach($chuyenkhoa as $chuyenkhoa){ ?>
         <a href="#" class="sec1Box">
         <span class="sec1Box-ic"><img id='cateIc-2' src="<?php echo XC_URL; ?>/uploads/images/<?php echo $chuyenkhoa->depart_image; ?>"></span>
         <b><?php echo $chuyenkhoa->depart_name; ?></b>
         </a>
         <?php } ?>
      </div>
      <div class="sec1Info row">
   <div class="col-12 clg-5">
      <div class="sec1Info-thumb">
         <img src="<?php echo XC_URL; ?>/uploads/images/<?php echo $this->helper->get_images(4)->image_url; ?>" alt="<?php echo $this->helper->get_images(4)->image_name; ?>">
      </div>
   </div>
   <div class="col-12 clg-7">
         <div class="sec1Info-content">
            <h3 style="color:#1760a5; font-weight: bold; margin-bottom: 5px;">PHÒNG KHÁM ĐA KHOA & NHÀ THUỐC</h3>
            <h2 style="color:#e36928; font-weight: 800; margin-bottom: 15px;">TRƯỜNG CAO ĐẲNG KON TUM</h2>
            <p style="line-height: 1.6; color: #444; margin-bottom: 25px;"> 
               <?php echo $this->helper->get_config('website_description'); ?>
            </p>
            
            <div class="sec1Info-action">
               <a href="<?php echo XC_URL; ?>/dang-ky-lich-kham.html" class="btn-booking">
                  <i class="fas fa-calendar-check" style="margin-right: 8px;"></i>
                  ĐẶT HẸN KHÁM NGAY
               </a>
            </div>
         </div>
      </div>
   </div>
   </div>
</section>
<!--<section id="sec2" class="bgGreen">-->
<!--   <div class="ctn">-->
<!--      <div class="tac">-->
<!--         <div class="secHead">-->
<!--            <i class="allicon" id="sec2Ic-1"></i>-->
<!--            <span>Ưu đãi hấp dẫn</span>-->
<!--         </div>-->
<!--      </div>-->
<!--      <div id="sec2Wrp">-->
<!--                <a href="https://chat.bstuvan.com.vn/LR/Chatpre.aspx?id=MMW77888888&lng=en" title="Phòng khám và nhà thuốc trường Cao đẳng kon tum" class="sec2Box">-->
<!--                    <img data-lazy="https://phongkhamcdkontum.com.vn/sharing/anh-shortcode-uudai/tong/uudai-nk.jpg" alt="">-->
<!--                </a>-->
<!--                <a href="https://chat.bstuvan.com.vn/LR/Chatpre.aspx?id=MMW77888888&lng=en" title="Phòng khám và nhà thuốc trường Cao đẳng kon tum" class="sec2Box">-->
<!--                    <img data-lazy="https://phongkhamcdkontum.com.vn/sharing/anh-shortcode-uudai/tong/uudai-pk.jpg" alt="">-->
<!--                </a>-->
<!--                <a href="https://chat.bstuvan.com.vn/LR/Chatpre.aspx?id=MMW77888888&lng=en" title="Phòng khám và nhà thuốc trường Cao đẳng kon tum" class="sec2Box">-->
<!--                    <img data-lazy="https://phongkhamcdkontum.com.vn/sharing/anh-shortcode-uudai/tong/uudai-bxh.jpg" alt="">-->
<!--                </a>-->
<!--                <a href="https://chat.bstuvan.com.vn/LR/Chatpre.aspx?id=MMW77888888&lng=en" title="Phòng khám và nhà thuốc trường Cao đẳng kon tum" class="sec2Box">-->
<!--                    <img data-lazy="https://phongkhamcdkontum.com.vn/sharing/anh-shortcode-uudai/tong/uudai-tri.jpg" alt="">-->
<!--                </a>-->
<!--            </div>-->
<!--   </div>-->
<!--</section>-->
<!--<section id="sec3" class="bgGray">-->
<!--   <div class="ctn">-->
<!--     <div id="sec3Wrp" class="row">-->
<!--                <div class="col-12 clg-12">-->
<!--                    <div class="tac">-->
<!--                        <div class="secHead">-->
<!--                            <i class="allicon" id="sec3Ic-1"></i>-->
<!--                            <span>Không gian phòng khám</span>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="col-12 clg-5">-->
<!--                    <div id="bsWrp">-->
<!--                        <div class="bg-home">-->
<!--                            <img src="https://phongkhamcdkontum.com.vn/wp-content/themes/dkcd/img/home/pic.jpg" alt="">-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->

                <!-- <div class="is_mobi" id="line2W"></div> -->

<!--                <div class="col-12 clg-7">-->
<!--                    <div id="mtpkWrp" class="">-->
<!--                     <?php foreach ($pic as $pic) {?>-->
<!--                    <div class="mtpkBox" style="" aria-hidden="true" tabindex="-1" role="option" aria-describedby="slick-slide30">-->
                     
<!--                            <img src="<?php echo XC_URL; ?>/uploads/images/<?php echo $pic->image_url; ?>" alt="<?php echo $pic->image_name; ?>">-->
                           
<!--                        </div>-->
<!--                         <?php } ?>-->
                       
<!--                        </div>-->
<!--                </div>-->

<!--            </div>-->
<!--   </div>-->
<!--</section>-->
<section id="sec7" class="bgGreen">
   <div class="ctn">
      <div class="tac">
         <div class="secHead">
            <i class="allicon" id="sec3Ic-2"></i>
            <span>Đội ngũ bác sĩ</span>
         </div>
      </div>
      <div id="sec7Wrp">
        <?php foreach($employee as $employee){ ?>
         <div class="slick-slide sec2Box">
            <div class="bsBox-home">
               <div class="bsBox-home-img">
                  <img src="<?php echo XC_URL; ?>/uploads/doctors/<?php echo $employee-> employee_image;?>" alt="<?php echo $employee-> employee_name;?>">
               </div>
               <div class="bsBox-home-inf">
                  <div class="bsBox-home-name"><span><?php echo $employee-> employee_name;?></span></div>
                  <span>Chuyên khoa: <b><?php echo $employee-> depart_name;?></b></span>
               </div>
               <!-- <div class="bsBox-home-exp">
                  <ul class="bs-exp-list">
                     <li><span>Chuyên môn</span> <b>Phụ khoa</b></li>
                     </b>
                  </ul>
               </div> -->
               <a href="<?php echo $this->helper->permalink($employee->employeeid,'doctors');?>" class="rmBtn bsBox-link">Xem thêm bác sĩ <i class="far fa-angle-double-right"></i></a>
            </div>
        </div>
        <?php } ?>
        
         
        
         
         
      </div>
   </div>
</section>
<section id="sec8">
   <div class="ctn">
      <div class="tac">
         <div class="secHead">
            <i class="fas fa-medkit"></i>
            <span>ưu điểm của phòng khám</span>
         </div>
      </div>
      <div id="sec8Wrp">
         <ul id="sec8S">
            <li class="sec8S-item current" data-id="#tab6">Đội ngũ bác sĩ <br> giàu kinh nghiệm</li>
            <li class="sec8S-item" data-id="#tab1">Quy trình khám chữa bệnh nhanh chóng</li>
            <li class="sec8S-item" data-id="#tab3">trang thiết bị <br>hiện đại</li>
            <li class="sec8S-item" data-id="#tab5">Chi phí điều<br>trị hợp lý</li>
            <li class="sec8S-item" data-id="#tab2">Bảo mật<br>thông tin</li>
         </ul>
         <div id="sec8B">
            <div class="sec8B-item" id="tab1">
               <img src="<?php echo $template_path; ?>/assets/themes/dkcd/img/home/p3_1.png" alt="">
               <div class="sec8B-text">
                  <div class="sec8B-tit">QUY TRÌNH KHÁM CHỮA BỆNH NHANH CHÓNG – KHOA HỌC – HIỆU QUẢ.</div>
                  <p>Phòng khám xây dựng quy trình tiếp nhận và khám chữa bệnh khoa học, rõ ràng và tối ưu từng khâu. Thủ tục đơn giản, hướng dẫn cụ thể, phân luồng hợp lý giúp người bệnh hạn chế thời gian chờ đợi, được thăm khám kịp thời và thuận tiện.</p>
                <p>Các bước từ khám lâm sàng, cận lâm sàng đến tư vấn điều trị đều được thực hiện đồng bộ, bảo đảm tính chính xác và liên tục. Kết quả được trả nhanh chóng, giải thích rõ ràng, giúp người bệnh chủ động trong quá trình chăm sóc sức khỏe.</p>
          <p> Chúng tôi tối ưu quy trình để mỗi lần thăm khám đều là một trải nghiệm chuyên nghiệp, tiết kiệm thời gian và hiệu quả.</p>
               </div>
            </div>
            <div class="sec8B-item" id="tab2">
               <img src="<?php echo $template_path; ?>/assets/themes/dkcd/img/home/p1.jpg" alt="">
               <div class="sec8B-text">
                  <div class="sec8B-tit">BẢO MẬT THÔNG TIN – TÔN TRỌNG – TRÁCH NHIỆM</div>
                  <p>Mọi thông tin cá nhân và hồ sơ bệnh án của người bệnh đều được quản lý và lưu trữ theo quy trình bảo mật chặt chẽ, tuân thủ quy định của ngành y tế.</p>
                <p>Phòng khám cam kết không cung cấp, chia sẻ thông tin khi chưa có sự đồng ý của người bệnh, bảo đảm quyền riêng tư và sự an tâm trong suốt quá trình thăm khám và điều trị.</p>
                <p>Tôn trọng người bệnh không chỉ trong chuyên môn mà còn trong trách nhiệm bảo vệ thông tin cá nhân.
</p>
               </div>
            </div>
            <div class="sec8B-item" id="tab3">
               <img src="<?php echo $template_path; ?>/assets/themes/dkcd/img/home/p5.png" alt="">
               <div class="sec8B-text">
                  <div class="sec8B-tit">TRANG THIẾT BỊ HIỆN ĐẠI – ĐỒNG BỘ – AN TOÀN.</div>
                  <p>Phòng khám đầu tư hệ thống trang thiết bị y tế hiện đại, được kiểm định và bảo trì định kỳ theo quy định. Máy móc chẩn đoán và xét nghiệm được cập nhật phù hợp với yêu cầu chuyên môn, hỗ trợ phát hiện sớm và theo dõi chính xác tình trạng bệnh lý.</p>
                  <p>Không gian khám chữa bệnh được bố trí khoa học, bảo đảm vô trùng, an toàn và thân thiện.</p>  
                   <p> Sự kết hợp giữa chuyên môn bác sĩ và công nghệ y tế hiện đại giúp nâng cao chất lượng chẩn đoán và hiệu quả điều trị.</p>

               </div>
            </div>
            <div class="sec8B-item" id="tab5">
               <img src="<?php echo $template_path; ?>/assets/themes/dkcd/img/home/p4.jpg" alt="">
               <div class="sec8B-text">
                  <div class="sec8B-tit">CHI PHÍ ĐIỀU TRỊ HỢP LÝ – MINH BẠCH – CÔNG KHAI.</div>
                  <p>Phòng khám thực hiện công khai, minh bạch các khoản chi phí khám và điều trị theo đúng quy định. Người bệnh được tư vấn rõ ràng trước khi thực hiện các dịch vụ, bảo  đảm quyền được biết và được lựa chọn.</p>
               <p> Phác đồ điều trị được xây dựng phù hợp với tình trạng bệnh lý và điều kiện thực tế, tối ưu hiệu quả nhưng vẫn giảm thiểu gánh nặng tài chính.</p>
               <p> Chúng tôi hướng đến mục tiêu cung cấp dịch vụ y tế chất lượng với chi phí hợp lý, để chăm sóc sức khỏe không còn là nỗi lo của người bệnh.
.</p>
               </div>
            </div>
            <div class="sec8B-item tab-show" id="tab6">
               <img src="<?php echo $template_path; ?>/assets/themes/dkcd/img/home/pic_7.jpg" alt="">
               <div class="sec8B-text">
                  <div class="sec8B-tit">ĐỘI NGŨ BÁC SĨ CHUYÊN NGHIỆP – TẬN TÂM – CHUẨN MỰC.</div>
                  <p>Phòng khám tự hào quy tụ đội ngũ bác sĩ giàu kinh nghiệm, từng công tác trong môi trường quân đội và các cơ sở y tế uy tín trong khu vực. Với nền tảng rèn luyện kỷ luật nghiêm túc, tác phong chuẩn mực và tinh thần trách nhiệm cao, các bác sĩ luôn đặt y đức và sự an toàn của người bệnh lên hàng đầu. Bên cạnh đó là đội ngũ bác sĩ – giảng viên có trình độ chuyên môn sâu, nhiều năm giảng dạy và trực tiếp khám chữa bệnh. Sự kết hợp giữa kiến thức học thuật cập nhật và kinh nghiệm lâm sàng thực tiễn giúp nâng cao độ chính xác trong chẩn đoán, tối ưu phác đồ điều trị và mang lại hiệu quả chăm sóc sức khỏe người bệnh toàn diện. Chúng tôi không chỉ khám bệnh, mà còn đồng hành cùng người bệnh trên hành trình bảo vệ và nâng cao sức khỏe</p>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<section id="sec4" class="bgGreen">
   <div class="ctn">
      <div class="tac">
         <div class="secHead">
            <i class="allicon" id="sec4Ic-1"></i>
            <span>Bài viết nổi bật</span>
         </div>
      </div>
      <div id="sec4Wrp" class="row">
         <?php foreach($events as $event){ ?>
         <div class="col-12 clg-3 item-0">
            <div class="sec4Box">
               <a href="<?php echo $this->helper->permalink($event->id,'event');?>" class="sec4Box-thumb">
               <img src="<?php echo XC_URL; ?>/uploads/events/<?php echo $event->event_image; ?>" alt="<?php echo $event->event_name; ?>">
               </a>
               <div class="sec4Box-txt">
                  <a href="<?php echo $this->helper->permalink($event->id,'event');?>" class="sec4Box-name"><?php echo $event->event_name; ?></a>
                  <p><?php echo $this->helper->limit_text($event->event_description,'50'); ?></p>
               </div>
            </div>
         </div>
         <?php } ?>
         
         
         
         
      </div>
   </div>
</section>
<section id="sec5">
   <div class="ctn">
      <div class="tac">
         <div class="secHead">
            <i class="allicon" id="sec5Ic-1"></i>
            <span>Phản hồi của bệnh nhân</span>
         </div>
      </div>
      <div id="phbnWrp">
         <div class="slick-slide phbnBox">
            <p>Mình có đặt lịch trước nên dễ dàng vào khám theo mã số và thời gian đặt lịch, không phải đợi lâu, thủ tục nhanh gọn không mất thời gian như ở bệnh viện, được bác sĩ, dược sĩ tư vấn nhiệt tình và kê đơn thuốc nên mình rất yên tâm. Phòng khám khang trang sạch sẽ, nhân viên lễ phép, mình đã đăng ký khám phụ khoa định kỳ tại đây.</p>
            <div class="phbnBox-inf">
               <img data-lazy="<?php echo $template_path; ?>/assets/themes/dkcd/img/bn-2.png" alt="" class="phbnBox-thumb">
               <div class="phbnBox-txt">
                  <b>Chị L.A</b> 30 tuổi, Kon Rẫy - Quảng Ngãi
               </div>
            </div>
         </div>
         
         
         <div class="slick-slide phbnBox">
            <p>Chưa bao giờ đi khám bệnh mà tôi được đội ngũ nhân viên y tá hỗ trợ nhiệt tình như thế. Thủ tục giấy tờ rõ ràng, minh bạch, chi phí điều trị tôi thấy cũng có nhiều ưu đãi. Khi thăm khám các bác sĩ cũng nhẹ nhàng hỗ trợ để giúp tôi hiểu rõ hơn về tình trạng bản thân đang mắc phải.</p>
            <div class="phbnBox-inf">
               <img data-lazy="<?php echo $template_path; ?>/assets/themes/dkcd/img/bn-3.png" alt="" class="phbnBox-thumb">
               <div class="phbnBox-txt">
                  <b>Anh N.T.H</b> 36 tuổi - Kon Tum, Quảng Ngãi
               </div>
            </div>
         </div>
         
      </div>
      <div id="videoPk">
          
         <img src="<?php echo $template_path; ?>/assets/themes/dkcd/img/webp/home/iframe_video.webp" alt="" >
         <div class="bgVideo">
           
             <iframe
                src="https://www.youtube.com/embed/a3FbMqt0QDA?autoplay=1&mute=1&controls=0&rel=0&modestbranding=1&fs=0&iv_load_policy=3&loop=1&playlist=a3FbMqt0QDA"
                allow="autoplay"
                allowfullscreen style='width:100%; height:100%; pointer-events: none;'>
            </iframe>
           
         </div>
      </div>
   </div>
   <div class="bgGreen1">
      <div class="ctn">
         <div id="sec5Wrp" class="row">
            <div class="col">
               <div class="sec5Box">
                  <div class="sec5Box-ic"><i id="sec5Ic-2" class="allicon ic3"></i></div>
                  <span>Đội ngũ bác sĩ nhiều năm kinh nghiệm.</span>
               </div>
            </div>
            <div class="col">
               <div class="sec5Box">
                  <div class="sec5Box-ic"><i id="sec5Ic-3" class="allicon ic3"></i></div>
                  <span>Đặt lịch online dễ dàng, miễn phí lấy số khám ưu tiên</span>
               </div>
            </div>
            <div class="col">
               <div class="sec5Box">
                  <div class="sec5Box-ic"><i id="sec5Ic-4" class="allicon ic3"></i></div>
                  <span>Kỹ thuật tiên tiến, đảm bảo hiệu quả điều trị</span>
               </div>
            </div>
            <div class="col">
               <div class="sec5Box">
                  <div class="sec5Box-ic"><i id="sec5Ic-5" class="allicon ic3"></i></div>
                  <span>Bảo mật thông tin, quá trình thăm khám riêng tư</span>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<!-- <section id="sec6">
   <div class="ctn">
      <div class="tac">
         <div class="secHead">
            <i class="allicon" id="sec6Ic-1"></i>
            <span>Truyền thông nói gì về Phòng khám việt sing</span>
         </div>
      </div>
      <div id="sec6Baochi">
         <div class="slick-slide items"><img data-lazy="<?php echo $template_path; ?>/assets/themes/dkcd/img/partners/google.png" alt=""></div>
         <div class="slick-slide items"><img data-lazy="<?php echo $template_path; ?>/assets/themes/dkcd/img/partners/coccoc.png" alt=""></div>
         <div class="slick-slide items"><img data-lazy="<?php echo $template_path; ?>/assets/themes/dkcd/img/partners/facebookl.png" alt=""></div>
         <div class="slick-slide items"><img data-lazy="<?php echo $template_path; ?>/assets/themes/dkcd/img/partners/zalo.png" alt=""></div>
         <div class="slick-slide items"><img data-lazy="<?php echo $template_path; ?>/assets/themes/dkcd/img/partners/zing.png" alt=""></div>
         <div class="slick-slide items"><img data-lazy="<?php echo $template_path; ?>/assets/themes/dkcd/img/partners/tiktok.png" alt=""></div>
         <div class="slick-slide items"><img data-lazy="<?php echo $template_path; ?>/assets/themes/dkcd/img/partners/youtube.png" alt=""></div>
         <div class="slick-slide items"><img data-lazy="<?php echo $template_path; ?>/assets/themes/dkcd/img/partners/24h.png" alt=""></div>
      </div>
   </div>
</section> -->
<!-- <div class="is_mobi">
   <div class="ctn">
      <div id="ftFrm">
         <div id="ftFrm-head" class="tac">
            <i id="ftIc-3" class="allicon"></i>
            <span>Đặt lịch khám</span>
         </div>
         <div class="d_contact">
            <input type="text" placeholder="Họ và tên (*)" require />
            <input type="number" class="d-phone" placeholder="Số điện thoại (*)" require/>
            <div class="row">
               <div class="col-6">
                  <select id = 'booking_person_gender' require>
                     <option value="0" selected>Giới tính (*)</option>
                     <option value="1">Nam</option>
                     <option value="2">Nữ</option>
                  </select>
               </div>
               <div class="col-6">
                  <input type="number" class="d-phone" placeholder="Tuổi (VD:1989) (*)" require max='4' min='4'/>
               </div>
            </div>
            <input type="text" placeholder="Địa chỉ (*)" require />
            <div class="row">
               <div class="col-6">
                <div class="date-input">
                  <input type="date"  id="ngaykham"  placeholder="Ngày khám" >
                  <i class="fa-fa calendar"></i>
               </div>
               </div>
               <div class="col-6">
                  <select name="hour_book" class="chosen-select hour_book" id="booking_hour">
                     <option value="">Giờ khám *</option>
                     <optgroup label="Buổi sáng">
                        <option value="07:00">07:00</option>
                        <option value="08:00">08:00</option>
                        <option value="09:00">09:00</option>
                        <option value="10:00">10:00</option>
                     </optgroup>
                     <optgroup label="Buổi chiều">
                        <option value="13:00">13:00</option>
                        <option value="14:00">14:00</option>
                        <option value="15:00">15:00</option>
                        <option value="15:00">14:00</option>
                     </optgroup>
                  </select>
               </div>
            </div>
            <textarea class="d-content" placeholder="Triệu chứng"></textarea>
            <button class="d-send"><i class="fas fa-paper-plane"></i> Đặt lịch</button>
         </div>
      </div>
   </div>
</div> -->
</main>

<?php include "footer_new.php";?>