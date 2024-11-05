<?php
include "header.php";
include "slider.php";
include "class/product_class.php";

$product = new product();
$show_product = $product->show_product();
?>

<div class="admin_content_right">
    <div class="admin_content_right_cartegory_list">
        <h1>Danh Sách Sản Phẩm</h1>
        <table>
            <tr>
                <th>STT</th>
                <th>ID</th>
                <th>Tên Sản Phẩm</th>
                <th>Danh Mục</th>
                <th>Thương Hiệu</th>
                <th>Giá</th>
                <th>Giá Mới</th>
                <th>Hình Ảnh</th>
                <th>Tùy Biến</th>
            </tr>
            <?php
            if ($show_product) {
                $i = 0;
                while ($result = $show_product->fetch_assoc()) {
                    $i++;
            ?>
            <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $result['product_id']; ?></td>
                <td><?php echo $result['product_name']; ?></td>
                <td><?php echo $result['cartegory_name']; ?></td>
                <td><?php echo $result['brand_name']; ?></td>
                <td><?php echo number_format($result['product_price'], 0, ',', '.'); ?> VND</td>
                <td><?php echo number_format($result['product_price_new'], 0, ',', '.'); ?> VND</td>
                <td><img src="uploads/<?php echo $result['product_img']; ?>" width="50" alt="Product Image"></td>
                <td>
                    <a href="product_edit.php?product_id=<?php echo $result['product_id']; ?>">Sửa</a> |
                    <a href="product_delete.php?product_id=<?php echo $result['product_id']; ?>">Xóa</a>
                </td>
            </tr>
            <?php
                }
            }
            ?>
        </table>
    </div>
</div>
</section>
</body>
</html>
