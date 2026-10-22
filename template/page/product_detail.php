<?php require "header_new.php"; ?>
<?php
$product = isset($product_detail) ? $product_detail : null;
$related_products = is_array($related_products ?? null) ? $related_products : array();
$cartEnabled = $this->helper->is_cart_enabled();
$productImage = ($product && !empty($product->product_image)) ? XC_URL . "/uploads/products/" . $product->product_image : $template_path . "/assets/images/logo.png";
$price = $product ? (float)$product->product_price : 0;
$discount = $product ? (int)$product->product_discount : 0;
$finalPrice = $discount > 0 ? ($price * (100 - $discount) / 100) : $price;
$detailDisplayPrice = $finalPrice > 0 ? number_format($finalPrice, 0, ',', '.') . 'đ' : 'Liên hệ';
?>

</section>
<div id="breadcrumbs">
    <div class="ctn">
        <div id="crumbs">
            <a href="<?php echo XC_URL; ?>">Trang chủ</a> <span>/</span>
            <a href="<?php echo XC_URL; ?>/nha-thuoc.html">Nhà thuốc</a>
            <?php if ($product && !empty($product->category_name)) { ?>
                <span>/</span> <a href="<?php echo $this->helper->permalink($product->product_category, 'category_product'); ?>"><?php echo htmlspecialchars($product->category_name, ENT_QUOTES, 'UTF-8'); ?></a>
            <?php } ?>
            <span>/</span> <a class="current"><?php echo $product ? htmlspecialchars($product->product_name, ENT_QUOTES, 'UTF-8') : 'Chi tiết thuốc'; ?></a>
        </div>
    </div>
</div>
<div class="ctn pd-page-wrap" style="padding:32px 0 56px;">
    <style>
        .pd-layout{display:grid;grid-template-columns:minmax(0,8fr) minmax(300px,4fr);gap:26px}
        .pd-main,.pd-side{background:#fff;border-radius:26px;box-shadow:0 18px 48px rgba(15,23,42,.08);border:1px solid #e5edf7}
        .pd-main{padding:28px}
        .pd-hero{display:grid;grid-template-columns:minmax(280px,420px) minmax(0,1fr);gap:28px;align-items:start}
        .pd-image-wrap{padding:28px;border-radius:24px;background:linear-gradient(180deg,#f8fbff 0%,#eef5ff 100%);display:flex;align-items:center;justify-content:center}
        .pd-image-wrap img{max-width:100%;max-height:420px;object-fit:contain}
        .pd-kicker{display:inline-flex;padding:8px 12px;border-radius:999px;background:#eaf2ff;color:#0b63f6;font-size:12px;font-weight:800;text-transform:uppercase}
        .pd-title{margin:16px 0 12px;color:#0f2f5a;font-size:34px;line-height:1.25}
        .pd-meta{display:flex;gap:10px;flex-wrap:wrap;margin-bottom:18px}
        .pd-meta span{padding:8px 12px;border-radius:999px;background:#f1f5f9;color:#334155;font-weight:600}
        .pd-price{display:flex;align-items:flex-end;gap:12px;flex-wrap:wrap;margin:18px 0}
        .pd-price-old{text-decoration:line-through;color:#94a3b8;font-size:18px}
        .pd-price-new{font-size:34px;font-weight:800;color:#0b63f6;line-height:1}
        .pd-actions{display:flex;gap:12px;flex-wrap:wrap;margin-top:22px}
        .pd-btn{display:inline-flex;align-items:center;justify-content:center;gap:8px;padding:11px 22px;border-radius:24px;font-size:14.5px;font-weight:600;border:0;cursor:pointer;text-decoration:none;box-shadow:0 3px 12px rgba(11,99,246,.2);transition:all .2s ease}
        .pd-btn-primary{background:linear-gradient(135deg,#0b63f6,#0284c7);color:#fff}
        .pd-btn-primary:hover{background:linear-gradient(135deg,#094fc3,#0369a1);transform:translateY(-1px);box-shadow:0 6px 18px rgba(11,99,246,.32)}
        .pd-btn-soft{background:#f0f7ff;color:#0284c7;border:1px solid #bae0fd;box-shadow:none}
        .pd-btn-soft:hover{background:#e0f2fe;color:#0369a1;border-color:#7dd3fc}
        .pd-description{margin-top:32px;padding:26px 8px 0;border-top:1px solid #e5edf7}
        .pd-description h2{margin:0 0 16px;color:#103a7a}
        .pd-description-body{color:#334155;line-height:1.8;font-size:16px}
        .pd-description-body img{max-width:100%;height:auto}
        .pd-side{padding:22px}
        .pd-side h3{margin:0 0 18px;color:#103a7a;font-size:24px}
        .pd-related-list{display:grid;gap:14px}
        .pd-related-item{display:grid;grid-template-columns:88px minmax(0,1fr);gap:14px;padding:12px;border-radius:18px;background:#f8fbff;border:1px solid #e5edf7;text-decoration:none}
        .pd-related-item img{width:88px;height:88px;object-fit:contain;border-radius:14px;background:#fff}
        .pd-related-item h4{margin:0 0 8px;color:#12345c;font-size:15px;line-height:1.45;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden}
        .pd-related-meta{display:flex;gap:8px;flex-wrap:wrap;margin-bottom:8px}
        .pd-related-meta span{padding:5px 8px;border-radius:999px;background:#fff;color:#4b5563;font-size:12px}
        .pd-related-price{color:#0b63f6;font-size:18px;font-weight:800}
        @media (max-width: 1199px){
            .pd-layout{grid-template-columns:1fr}
        }
        @media (max-width: 767px){
            #breadcrumbs .ctn{
                padding-left:14px !important;
                padding-right:14px !important;
                box-sizing:border-box;
            }
            .pd-page-wrap{
                padding:24px 14px 40px !important;
                box-sizing:border-box;
            }
            .pd-layout{
                gap:18px;
            }
            .pd-main,.pd-side{
                border-radius:22px;
                margin:0;
            }
            .pd-main{padding:20px}
            .pd-hero{grid-template-columns:1fr}
            .pd-kicker,
            .pd-title,
            .pd-meta,
            .pd-price{
                margin-left:6px;
                margin-right:6px;
            }
            .pd-title{font-size:28px}
            .pd-price-new{font-size:28px}
            .pd-actions{flex-direction:column}
            .pd-btn{width:100%}
            .pd-description{
                padding:24px 6px 0;
            }
        }
    </style>
    <?php if (!$product) { ?>
        <div class="pd-main"><p>Không tìm thấy thuốc.</p></div>
    <?php } else { ?>
        <div class="pd-layout">
            <section class="pd-main">
                <div class="pd-hero">
                    <div class="pd-image-wrap">
                        <img src="<?php echo $productImage; ?>" alt="<?php echo htmlspecialchars($product->product_name, ENT_QUOTES, 'UTF-8'); ?>">
                    </div>
                    <div>
                        <span class="pd-kicker"><?php echo !empty($product->category_name) ? htmlspecialchars($product->category_name, ENT_QUOTES, 'UTF-8') : 'Nhà thuốc'; ?></span>
                        <h1 class="pd-title"><?php echo htmlspecialchars($product->product_name, ENT_QUOTES, 'UTF-8'); ?></h1>
                        <div class="pd-meta">
                            <?php if (!empty($product->unit_name)) { ?><span>Đơn vị tính: <?php echo htmlspecialchars($product->unit_name, ENT_QUOTES, 'UTF-8'); ?></span><?php } ?>
                            <?php if (!empty($product->product_spec)) { ?><span><?php echo htmlspecialchars($product->product_spec, ENT_QUOTES, 'UTF-8'); ?></span><?php } ?>
                        </div>
                        <div class="pd-price">
                            <?php if ($discount > 0 && $price > 0 && $finalPrice > 0) { ?><span class="pd-price-old"><?php echo number_format($price, 0, ',', '.'); ?>đ</span><?php } ?>
                            <span class="pd-price-new"><?php echo $detailDisplayPrice; ?></span>
                        </div>
                        <?php if ($cartEnabled) { ?>
                            <div class="pd-actions">
                                <button type="button" class="pd-btn pd-btn-primary js-detail-add-cart" data-product-id="<?php echo (int)$product->pid; ?>"><i class="fa-solid fa-cart-plus"></i> Thêm vào giỏ hàng</button>
                                <a class="pd-btn pd-btn-soft" href="<?php echo XC_URL; ?>/gio-hang.html"><i class="fa-solid fa-cart-shopping"></i> Xem giỏ hàng</a>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="pd-description">
                    <h2>Thông tin mô tả</h2>
                    <div class="pd-description-body">
                        <?php echo !empty($product->product_description) ? $product->product_description : '<p>Sản phẩm đang được cập nhật mô tả.</p>'; ?>
                    </div>
                </div>
            </section>
            <aside class="pd-side">
                <h3>Thuốc liên quan</h3>
                <div class="pd-related-list">
                    <?php if (empty($related_products)) { ?>
                        <p>Chưa có thuốc liên quan.</p>
                    <?php } else { ?>
                        <?php foreach ($related_products as $item) {
                            $itemImage = !empty($item->product_image) ? XC_URL . "/uploads/products/" . $item->product_image : $template_path . "/assets/images/logo.png";
                            $itemPrice = (float)$item->product_price;
                            $itemDiscount = (int)$item->product_discount;
                            $itemFinalPrice = $itemDiscount > 0 ? ($itemPrice * (100 - $itemDiscount) / 100) : $itemPrice;
                            $relatedDisplayPrice = $itemFinalPrice > 0 ? number_format($itemFinalPrice, 0, ',', '.') . 'đ' : 'Liên hệ';
                        ?>
                            <a class="pd-related-item" href="<?php echo $this->helper->permalink($item->pid, 'product_detail'); ?>">
                                <img src="<?php echo $itemImage; ?>" alt="<?php echo htmlspecialchars($item->product_name, ENT_QUOTES, 'UTF-8'); ?>">
                                <div>
                                    <h4><?php echo htmlspecialchars($item->product_name, ENT_QUOTES, 'UTF-8'); ?></h4>
                                    <div class="pd-related-meta">
                                        <?php if (!empty($item->unit_name)) { ?><span><?php echo htmlspecialchars($item->unit_name, ENT_QUOTES, 'UTF-8'); ?></span><?php } ?>
                                    </div>
                                    <div class="pd-related-price"><?php echo $relatedDisplayPrice; ?></div>
                                </div>
                            </a>
                        <?php } ?>
                    <?php } ?>
                </div>
            </aside>
        </div>
    <?php } ?>
</div>
</main>
<?php require "footer_new.php"; ?>
