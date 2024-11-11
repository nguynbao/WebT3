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
    <span class="font-nomal">
        <?php
        if (isset($_GET['q']) && $_GET['q'] != '') {
            echo "Kết quả tìm kiếm cho: " . htmlspecialchars($_GET['q']);
        } elseif (isset($_GET['category_id'])) {
            echo $categories[$_GET['category_id']];
        } else {
            echo "Tất cả sản phẩm";
        }
        ?>
    </span>
</div>

<div class="container_products">
    <div class="category-left">
        <ul>
            <?php foreach ($categories as $category_id => $category_name) : ?>
                <li class="category-left-li">
                    <a href="brand_product.php?category_id=<?php echo $category_id; ?>"><?php echo $category_name; ?></a>
                    <ul>
                        <?php foreach ($brands as $brand) : ?>
                            <?php if ($brand['category_id'] == $category_id) : ?>
                                <li><a href="brand_product.php?category_id=<?php echo $category_id; ?>&brand_id=<?php echo $brand['brand_id']; ?>"><?php echo $brand['brand_name']; ?></a></li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <script>
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
                    if (isset($_GET['q']) && $_GET['q'] != '') {
                        echo "Kết quả tìm kiếm cho: " . htmlspecialchars($_GET['q']);
                    } elseif (isset($_GET['category_id'])) {
                        $category_id = $_GET['category_id'];
                        echo $categories[$category_id];
                    } else {
                        echo "Tất cả sản phẩm";
                    }
                    ?>
                </p>
            </div>
            <div class="category-right-top-item">
                <form action="" method="GET">
                    <select name="sort" id="sort" onchange="this.form.submit()">
                        <option value="">Sắp xếp</option>
                        <option value="price_desc" <?php echo isset($_GET['sort']) && $_GET['sort'] == 'price_desc' ? 'selected' : ''; ?>>Giá cao đến thấp</option>
                        <option value="price_asc" <?php echo isset($_GET['sort']) && $_GET['sort'] == 'price_asc' ? 'selected' : ''; ?>>Giá thấp đến cao</option>
                    </select>
                </form>
            </div>
        </div>

        <div class="category-right-content">
            <?php
            // Get the MySQLi connection object from the Database class
            $conn = $db->link; // Use the correct property to get the connection

            // Truy vấn sản phẩm theo danh mục, thương hiệu, và tìm kiếm
            $sql_product = "SELECT * FROM tbl_product";
            $conditions = array();

            if (isset($_GET['category_id'])) {
                $conditions[] = "category_id = " . intval($_GET['category_id']);
                if (isset($_GET['brand_id'])) {
                    $conditions[] = "brand_id = " . intval($_GET['brand_id']);
                }
            }

            if (isset($_GET['q']) && $_GET['q'] != '') {
                $search_query = mysqli_real_escape_string($conn, $_GET['q']);
                $conditions[] = "product_name LIKE '%$search_query%'";
            }

            if (!empty($conditions)) {
                $sql_product .= " WHERE " . implode(" AND ", $conditions);
            }

            if (isset($_GET['sort'])) {
                if ($_GET['sort'] == 'price_desc') {
                    $sql_product .= " ORDER BY product_price DESC";
                } elseif ($_GET['sort'] == 'price_asc') {
                    $sql_product .= " ORDER BY product_price ASC";
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
                            <p style="text-decoration: line-through;"><?php echo number_format($product['product_price']); ?><sup>đ</sup></p>
                            <p><?php echo number_format($product['product_price_new']); ?><sup>đ</sup></p>
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