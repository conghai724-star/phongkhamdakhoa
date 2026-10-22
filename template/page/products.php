<?php require "header_new.php"; ?>
<?php
$products = is_array($products ?? null) ? $products : array();
$product_category = is_array($product_category ?? null) ? $product_category : array();
$currentCategoryId = isset($id_category) ? (int) $id_category : 0;
$isCategoryPage = isset($category) && $category === 'category';
$currentCategoryName = 'Tất cả loại thuốc';
$cartEnabled = $this->helper->is_cart_enabled();
$cartCount = $cartEnabled ? $this->helper->get_cart_count() : 0;

if ($isCategoryPage && isset($category_fil) && !empty($category_fil->category_name)) {
    $currentCategoryName = $category_fil->category_name;
}

$categorySlug = $isCategoryPage ? $this->helper->bodau($currentCategoryName) : '';
$currentPageNumber = isset($current_page) ? (int) $current_page : 1;
$totalPages = isset($total_pages) ? (int) $total_pages : 1;
$totalRecords = isset($total_records) ? (int) $total_records : count($products);
$visibleCount = count($products);
$styleVersion = file_exists(__DIR__ . '/assets/themes/stylepr.css') ? filemtime(__DIR__ . '/assets/themes/stylepr.css') : time();
?>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const input = document.getElementById("searchInput");
    const productCards = document.querySelectorAll(".pm-product-card");
    const resultCount = document.getElementById("pmVisibleCount");
    const emptyState = document.getElementById("pmEmptyState");

    function filterProducts() {
        const keyword = (input ? input.value : "").trim().toLowerCase();
        let visible = 0;

        productCards.forEach(function(product) {
            const name = product.getAttribute("data-name") || "";
            const category = product.getAttribute("data-category") || "";
            const matched = name.includes(keyword) || category.includes(keyword);
            product.style.display = matched ? "" : "none";
            if (matched) visible++;
        });

        if (resultCount) resultCount.textContent = visible;
        if (emptyState) emptyState.style.display = visible === 0 ? "flex" : "none";
    }

    if (input) {
        input.addEventListener("input", filterProducts);
    }

    const mobileInput = document.getElementById("mobileSearchInput");
    if (mobileInput) {
        mobileInput.addEventListener("input", function() {
            if (input) input.value = mobileInput.value;
            filterProducts();
        });
        const urlParams = new URLSearchParams(window.location.search);
        const urlKeyword = urlParams.get('keyword');
        if (urlKeyword) {
            mobileInput.value = urlKeyword;
            if (input) input.value = urlKeyword;
            filterProducts();
        }
    }


});

function toggleMobileMenu() {
    const menu = document.getElementById("mobileCatMenu");
    if (menu) menu.classList.toggle("show");
}

window.addEventListener("click", function(event) {
    if (!event.target.closest(".pm-mobile-category")) {
        const dropdown = document.getElementById("mobileCatMenu");
        if (dropdown) dropdown.classList.remove("show");
    }
});
</script>
</section>
<div id="breadcrumbs">
    <div class="ctn">
        <div id="crumbs"><a href="<?php echo XC_URL; ?>">Trang chủ</a> <span>/</span> <a class="current">Nhà thuốc</a></div>
    </div>
</div>
<div class="product-management-wrapper">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="<?php echo $template_path; ?>/assets/themes/stylepr.css?v=<?php echo $styleVersion; ?>">
    <style>
        .pm-card-link{text-decoration:none;color:inherit;display:block}
        <?php if ($cartEnabled) { ?>
        .pm-card-actions{display:flex;align-items:center;gap:8px;margin-top:10px;flex-wrap:wrap}
        .pm-btn-add-cart{flex:1;min-width:115px;border:0;border-radius:20px;background:linear-gradient(135deg,#0b63f6,#0284c7);color:#fff;padding:7px 12px;font-size:13px;font-weight:600;cursor:pointer;display:inline-flex;align-items:center;justify-content:center;gap:5px;box-shadow:0 3px 10px rgba(11,99,246,.2);transition:all .2s ease}
        .pm-btn-add-cart:hover{background:linear-gradient(135deg,#094fc3,#0369a1);transform:translateY(-1px);box-shadow:0 5px 14px rgba(11,99,246,.3)}
        .pm-btn-add-cart:disabled{opacity:.75;cursor:not-allowed;transform:none}
        .pm-link-cart{font-size:12px;font-weight:600;color:#0284c7;background:#f0f7ff;padding:6px 10px;border-radius:16px;border:1px solid #bae0fd;text-decoration:none;display:inline-flex;align-items:center;gap:4px;white-space:nowrap;transition:all .2s ease}
        .pm-link-cart:hover{background:#e0f2fe;color:#0369a1;border-color:#7dd3fc}
        @media (max-width: 575px) {
            .pm-card-actions{flex-direction:column;gap:6px;margin-top:8px}
            .pm-btn-add-cart{width:100%;min-width:0;padding:6px 8px;font-size:11.5px;border-radius:14px;justify-content:center}
            .pm-link-cart{width:100%;justify-content:center;padding:4px 6px;font-size:11px;border-radius:12px;box-sizing:border-box}
        }
        <?php } ?>
    </style>

    <div class="ctn">
        <div class="pm-container">
            <div class="pm-mobile-category">
                <div class="pm-mobile-select" onclick="toggleMobileMenu()">
                    <span><i class="fa-solid fa-list-ul"></i> Chọn loại thuốc</span>
                    <i class="fa-solid fa-chevron-down"></i>
                </div>
                <div class="pm-mobile-dropdown-content" id="mobileCatMenu">
                    <a href="<?php echo XC_URL; ?>/nha-thuoc.html" class="<?php echo !$isCategoryPage ? 'active' : ''; ?>">Tất cả loại thuốc</a>
                    <?php foreach ($product_category as $item) { ?>
                        <a href="<?php echo $this->helper->permalink($item->id, 'category_product'); ?>" class="<?php echo ($item->id == $currentCategoryId) ? 'active' : ''; ?>"><?php echo htmlspecialchars($item->category_name, ENT_QUOTES, 'UTF-8'); ?></a>
                    <?php } ?>
                </div>
            </div>

            <aside class="pm-sidebar">
                <div class="pm-sidebar-card">
                    <div class="pm-sidebar-heading">
                        <span class="pm-sidebar-kicker">Bộ lọc</span>
                        <h3>Danh mục loại thuốc</h3>
                    </div>
                    <ul class="pm-category-list">
                        <li>
                            <a href="<?php echo XC_URL; ?>/nha-thuoc.html" class="<?php echo !$isCategoryPage ? 'active' : ''; ?>">
                                <i class="fa-solid fa-border-all"></i>
                                <span>Tất cả loại thuốc</span>
                            </a>
                        </li>
                        <?php foreach ($product_category as $item) { ?>
                            <li>
                                <a class="<?php echo ($item->id == $currentCategoryId) ? 'active' : ''; ?>" href="<?php echo $this->helper->permalink($item->id, 'category_product'); ?>">
                                    <i class="<?php echo !empty($item->category_icon) ? $item->category_icon : 'fa-solid fa-pills'; ?>"></i>
                                    <span><?php echo htmlspecialchars($item->category_name, ENT_QUOTES, 'UTF-8'); ?></span>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </aside>

            <main class="pm-main-content">
                <div class="pm-toolbar">
                    <div class="pm-toolbar-copy">
                        <span class="pm-toolbar-label">Danh sách sản phẩm</span>
                        <h2><?php echo htmlspecialchars($currentCategoryName, ENT_QUOTES, 'UTF-8'); ?></h2>
                        <p>Hiển thị <strong id="pmVisibleCount"><?php echo $visibleCount; ?></strong> sản phẩm trên trang này.</p>
                    </div>
                    <div class="pm-search-box">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input type="text" placeholder="Tìm kiếm theo tên thuốc hoặc loại thuốc..." id="searchInput">
                    </div>
                </div>

                <div class="pm-product-grid">
                    <?php foreach ($products as $product) {
                        $price = (float) $product->product_price;
                        $discount = (int) $product->product_discount;
                        $priceAfter = $discount > 0 ? ($price * (100 - $discount) / 100) : $price;
                        $displayPrice = $priceAfter > 0 ? number_format($priceAfter, 0, ',', '.') . 'đ' : 'Liên hệ';
                        $productImage = !empty($product->product_image) ? XC_URL . "/uploads/products/" . $product->product_image : $template_path . "/assets/images/logo.png";
                    ?>
                        <article class="pm-product-card" data-name="<?php echo htmlspecialchars(mb_strtolower($product->product_name, 'UTF-8'), ENT_QUOTES, 'UTF-8'); ?>" data-category="<?php echo htmlspecialchars(mb_strtolower($product->category_name ?? '', 'UTF-8'), ENT_QUOTES, 'UTF-8'); ?>">
                            <?php if ($discount > 0) { ?>
                                <div class="pm-discount-tag">-<?php echo $discount; ?>%</div>
                            <?php } ?>
                            <div class="pm-card-top">
                                <span class="pm-card-category"><?php echo !empty($product->category_name) ? htmlspecialchars($product->category_name, ENT_QUOTES, 'UTF-8') : 'Nhà thuốc'; ?></span>
                            </div>
                            <a class="pm-card-link" href="<?php echo $this->helper->permalink($product->pid, 'product_detail'); ?>">
                                <div class="pm-img-container">
                                    <img src="<?php echo $productImage; ?>" alt="<?php echo htmlspecialchars($product->product_name, ENT_QUOTES, 'UTF-8'); ?>">
                                </div>
                            </a>
                            <div class="pm-card-body">
                                <a class="pm-card-link" href="<?php echo $this->helper->permalink($product->pid, 'product_detail'); ?>">
                                    <h3 class="pm-product-name"><?php echo htmlspecialchars($product->product_name, ENT_QUOTES, 'UTF-8'); ?></h3>
                                </a>
                                <div class="pm-price-block">
                                    <?php if ($discount > 0 && $price > 0 && $priceAfter > 0) { ?>
                                        <span class="pm-price-old"><?php echo number_format($price, 0, ',', '.'); ?>đ</span>
                                    <?php } ?>
                                    <span class="pm-price-new"><?php echo $displayPrice; ?></span>
                                </div>
                                <div class="pm-card-footer">
                                    <a class="pm-card-link" href="<?php echo $this->helper->permalink($product->pid, 'product_detail'); ?>" style="display:flex;align-items:center;justify-content:space-between;gap:12px;width:100%;">
                                        <span class="pm-card-note"><?php echo !empty($product->product_unit) ? 'Xem chi tiết sản phẩm' : 'Tư vấn tại nhà thuốc'; ?></span>
                                        <span class="pm-card-arrow"><i class="fa-solid fa-arrow-right"></i></span>
                                    </a>
                                </div>
                                <?php if ($cartEnabled) { ?>
                                    <div class="pm-card-actions">
                                        <button type="button" class="pm-btn-add-cart js-add-to-cart" data-product-id="<?php echo (int) $product->pid; ?>"><i class="fa-solid fa-cart-plus"></i> Thêm vào giỏ</button>
                                        <a class="pm-link-cart" href="<?php echo XC_URL; ?>/gio-hang.html">Xem giỏ hàng</a>
                                    </div>
                                <?php } ?>
                            </div>
                        </article>
                    <?php } ?>
                </div>

                <div class="pm-empty-state" id="pmEmptyState" style="display:none;">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <p>Không tìm thấy sản phẩm phù hợp với từ khóa bạn đang nhập.</p>
                </div>
            </main>
        </div>

        <?php if ($totalPages > 1) { ?>
            <div class="pagination pm-pagination">
                <nav class="paginate_links" aria-label="Phân trang sản phẩm">
                    <?php
                    $buildPageUrl = function ($pageNumber) use ($isCategoryPage, $currentCategoryId, $categorySlug) {
                        if ($isCategoryPage) {
                            return XC_URL."/nha-thuoc/category/".$currentCategoryId."-".$categorySlug."/page/".$pageNumber.".html";
                        }
                        return XC_URL."/nha-thuoc/page/".$pageNumber.".html";
                    };

                    if ($currentPageNumber > 1) {
                        echo "<a class='page-numbers page-nav' href='".$buildPageUrl($currentPageNumber - 1)."' aria-label='Trang trước'>&lt;</a>";
                    } else {
                        echo "<span class='page-numbers page-nav disabled' aria-disabled='true'>&lt;</span>";
                    }

                    if ($totalPages <= 7) {
                        $pagesToShow = range(1, $totalPages);
                    } elseif ($currentPageNumber <= 4) {
                        $pagesToShow = array(1, 2, 3, 4, 5, 'ellipsis', $totalPages);
                    } elseif ($currentPageNumber >= $totalPages - 3) {
                        $pagesToShow = array(1, 'ellipsis');
                        $pagesToShow = array_merge($pagesToShow, range($totalPages - 4, $totalPages));
                    } else {
                        $pagesToShow = array(1, 'ellipsis');
                        $pagesToShow = array_merge($pagesToShow, range($currentPageNumber - 2, $currentPageNumber + 2));
                        $pagesToShow[] = 'ellipsis';
                        $pagesToShow[] = $totalPages;
                    }

                    foreach ($pagesToShow as $i) {
                        if ($i === 'ellipsis') {
                            echo "<span class='page-ellipsis' aria-hidden='true'>...</span>";
                            continue;
                        }

                        if ($i == $currentPageNumber) {
                            echo "<span aria-current='page' class='page-numbers current'>$i</span>";
                        } else {
                            echo "<a class='page-numbers' href='".$buildPageUrl($i)."' aria-label='Trang $i'>$i</a>";
                        }
                    }

                    if ($currentPageNumber < $totalPages) {
                        echo "<a class='page-numbers page-nav' href='".$buildPageUrl($currentPageNumber + 1)."' aria-label='Trang sau'>&gt;</a>";
                    } else {
                        echo "<span class='page-numbers page-nav disabled' aria-disabled='true'>&gt;</span>";
                    }
                    ?>
                </nav>
            </div>
        <?php } ?>
    </div>
</div>
</main>
<?php require "footer_new.php"; ?>
