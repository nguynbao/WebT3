<?php
session_start();
if (isset($_SESSION['addmin'])) {
    include "header.php";
    include "slider.php";
    include "class/brand_class.php";
    $brand = new brand;
    $brand_id = $_GET['brand_id'];
    $get_brand = $brand->get_brand($brand_id);
    if ($get_brand) {
        $resultA = $get_brand->fetch_assoc();
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $category_id = $_POST['category_id'];
        $brand_name = $_POST['brand_name'];
        $update_brand = $brand->update_brand($category_id, $brand_name, $brand_id);
    }
?>

    <style>
        select {
            height: 30px;
            width: 200px;
        }
    </style>

    <div class="admin_content_right">
        <div class="admin_content_right_category_add">
            <h1>Thêm Loại Sản Phẩm</h1>
            <br>
            <form action="" method="post">
                <select name="category_id" id="" required>
                    <option value="">--Chọn Danh Mục</option>
                    <?php
                    $show_category = $brand->show_category();
                    if ($show_category) {
                        while ($result = $show_category->fetch_assoc()) {
                    ?>
                            <option <?php if (isset($resultA['category_id']) && $resultA['category_id'] == $result['category_id']) {
                                        echo "selected";
                                    } ?> value="<?php echo $result['category_id'] ?>"><?php echo $result['category_name'] ?></option>
                    <?php
                        }
                    }
                    ?>
                </select>
                <br>
                <input required type="text" name="brand_name" placeholder="Nhập tên loại sản phẩm" value="<?php if (isset($resultA['brand_name'])) {
                                                                                                                echo $resultA['brand_name'];
                                                                                                            } ?>">
                <button type="submit">Sửa</button>
            </form>
        </div>
    </div>
    </body>

    </html>

<?php
} else {
    echo "Error: 404!";
}
?>