<?php
session_start();
require_once('header.php');

$db = new Database();

// Truy vấn danh mục
$sql_category = "SELECT category_id, category_name FROM tbl_category";
$result_category = $db->select($sql_category);

// Truy vấn thương hiệu
$sql_brand = "SELECT brand_id, category_id, brand_name FROM tbl_brand";
$result_brand = $db->select($sql_brand);

$categories = array();
if ($result_category) {
    while ($row = $result_category->fetch_assoc()) {
        $categories[$row['category_id']] = $row['category_name'];
    }
}

$brands = array();
if ($result_brand) {
    while ($row = $result_brand->fetch_assoc()) {
        $brands[] = $row;
    }
}
?>



<div class="breadcrumbs">
    <a href="../index.php"><span class="trangchu">Trang chủ</span></a>
    <span style="padding: 0 5px;">/</span>
    <span class="font-nomal">Tất cả sản phẩm</span>
</div>

<div class="container_products">
    <div class="category-left">
        <ul>
            <?php foreach ($categories as $category_id => $category_name): ?>
                <li class="category-left-li">
                    <a href="brand_product.php?category_id=<?php echo $category_id; ?>"><?php echo $category_name; ?></a>
                    <ul>
                        <?php foreach ($brands as $brand): ?>
                            <?php if ($brand['category_id'] == $category_id): ?>
                                <li><a href="brand_product.php?category_id=<?php echo $category_id; ?>&brand_id=<?php echo $brand['brand_id']; ?>"><?php echo $brand['brand_name']; ?></a></li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <script>
        //----------products----------------
        const itemslidebar = document.querySelectorAll(".category-left-li > a");

        itemslidebar.forEach(function(menu) {
            menu.addEventListener("click", function(event) {
                event.preventDefault();
                const parentLi = menu.parentElement;
                itemslidebar.forEach(function(otherMenu) {
                    if (otherMenu !== menu) {
                        otherMenu.parentElement.classList.remove("block");
                    }
                });
                parentLi.classList.toggle("block");
            });
        });
    </script>

    <div class="category-right">
        <div class="category-right-top">
            <div class="category-right-top-item">
                <p>
                    <?php
                    if (isset($_GET['category_id'])) {
                        $category_id = $_GET['category_id'];
                        echo $categories[$category_id];
                    } else {
                        echo "Tất cả sản phẩm";
                    }
                    ?>
                </p>
            </div>
            <div class="category-right-top-item">
                <select name="" id="">
                    <option value="">Sắp xếp</option>
                    <option value="price_desc">Giá cao đến thấp</option>
                    <option value="price_asc">Giá thấp đến cao</option>
                </select>
            </div>
        </div>

        <div class="category-right-content">
            <?php
            // Truy vấn sản phẩm theo danh mục và thương hiệu
            $sql_product = "SELECT * FROM tbl_product";
            if (isset($_GET['category_id'])) {
                $sql_product .= " WHERE category_id = " . $_GET['category_id'];
                if (isset($_GET['brand_id'])) {
                    $sql_product .= " AND brand_id = " . $_GET['brand_id'];
                }
            }
            $result_product = $db->select($sql_product);

            if ($result_product) {
                while ($product = $result_product->fetch_assoc()) {
            ?>
                    <div class="category-right-content-item">
                        <a href="index_chitiet.php?product_id=<?php echo $product['product_id']; ?>">
                            <img src="../admin/uploads/<?php echo $product['product_img']; ?>" alt="">
                            <h1><?php echo $product['product_name']; ?></h1>
                            <p style="text-decoration: line-through;"><?php echo $product['product_price']; ?><sup>đ</sup></p>
                            <p><?php echo $product['product_price_new']; ?><sup>đ</sup></p>
                        </a>
                    </div>
            <?php
                }
            } else {
                echo "<p>Không có sản phẩm nào</p>";
            }
            ?>
        </div>

        <div class="category-right-bottom row">
            <div class="category-right-bottom-items">
                <p>Hiển Thị 2 <span>|</span> 4 sản phẩm</p>
            </div>

            <div class="category-right-bottom-items">
                <p><span>&#171;</span>1 2 3 4 5 <span>&#187;</span>Trang cuối</p>
            </div>
        </div>
    </div>
</div>

<?php require_once('footer.php'); ?>