<?php
    include "header.php";
    include "slider.php";
    include "class/brand_class.php";
?>

<?php
$brand = new brand();
$show_brand = $brand->show_brand();
?>

<div class="admin_content_right">
<div class="admin_content_right_cartegory_list">
                <h1>Danh Sách Danh Mục</h1>
                <table>
                    <tr>
                        <th>STT</th>
                        <th>ID</th>
                        <th>Danh Mục</th>
                        <th>Loại Sản Phẩm</th>
                        <th>Tùy Biến</th>
                    </tr>
                    <?php
                    if ($show_brand) {
                        $i=0;
                        while ($result = $show_brand->fetch_assoc()) {
                            $i++;  
                    ?>
                    <tr>
                        <td><?php echo $i ?></td>
                        <td><?php echo $result['brand_id'] ?></td>
                        <td><?php echo $result['cartegory_name'] ?></td>
                        <td><?php echo $result['brand_name'] ?></td>
                        <td><a href="brand_edit.php?brand_id=<?php echo $result['brand_id'] ?>">Sửa</a>|<a href="brand_delete.php?brand_id=<?php echo $result['brand_id'] ?>">Xóa</a></td>
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