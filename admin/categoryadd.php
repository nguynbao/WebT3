<?php
session_start();
if (isset($_SESSION['admin'])) {
    include "header.php";
    include "slider.php";
    include "class/category_class.php";
    $category = new category();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $category_name = $_POST['category_name'];
        $insert_category = $category->insert_category($category_name);
    }
?>

    <div class="admin_content_right">
        <div class="admin_content_right_category_add">
            <h1>Thêm Danh Mục</h1>
            <form action="" method="post">
                <input required type="text" name="category_name" id="" placeholder="Nhập tên danh mục">
                <button type="submit">Thêm</button>
            </form>
        </div>
    </div>
    </section>
    </body>

    </html>
<?php
} else {
    echo "Erorr: 404!";
}
?>