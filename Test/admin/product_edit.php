<?php
include "header.php";
include "slider.php";
include "class/product_class.php";

$product = new product();

if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];
    $get_product = $product->get_product_by_id($product_id);
    if ($get_product) {
        $result = $get_product->fetch_assoc();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_product'])) {
    $update_product = $product->update_product($product_id, $_POST, $_FILES);
}
?>

<div class="admin_content_right">
    <div class="admin_content_right_product_edit">
        <h1>Sửa Sản Phẩm</h1>
        <form action="" method="POST" enctype="multipart/form-data">
            <label for="product_name">Tên Sản Phẩm</label>
            <input type="text" style="width:500px; height:30px;" name="product_name" value="<?php echo $result['product_name']; ?>">
            <br>
            <label for="cartegory_id">Danh Mục</label>
            <select name="cartegory_id">
                <?php
                $show_cartegory = $product->show_cartegory();
                if ($show_cartegory) {
                    while ($cartegory = $show_cartegory->fetch_assoc()) {
                ?>
                    <option value="<?php echo $cartegory['cartegory_id']; ?>" <?php if ($cartegory['cartegory_id'] == $result['cartegory_id']) echo 'selected'; ?>>
                        <?php echo $cartegory['cartegory_name']; ?>
                    </option>
                <?php
                    }
                }
                ?>
            </select>
            <label for="brand_id">Thương Hiệu</label>
            <select name="brand_id">
                <?php
                $show_brand = $product->show_brand();
                if ($show_brand) {
                    while ($brand = $show_brand->fetch_assoc()) {
                ?>
                    <option value="<?php echo $brand['brand_id']; ?>" <?php if ($brand['brand_id'] == $result['brand_id']) echo 'selected'; ?>>
                        <?php echo $brand['brand_name']; ?>
                    </option>
                <?php
                    }
                }
                ?>
            </select>
            <label for="product_price">Giá</label>
            <input type="text" name="product_price" value="<?php echo $result['product_price']; ?>">
            <label for="product_price_new">Giá Mới</label>
            <input type="text" name="product_price_new" value="<?php echo $result['product_price_new']; ?>">
            <label for="product_desc">Mô Tả</label>
            <textarea name="product_desc"><?php echo $result['product_desc']; ?></textarea>
            <label for="product_img">Hình Ảnh</label>
            <img src="uploads/<?php echo $result['product_img']; ?>" width="100">
            <input type="file" name="product_img">
            <button type="submit" name="update_product">Cập Nhật</button>
        </form>
    </div>
</div>
</section>
</body>
</html>
