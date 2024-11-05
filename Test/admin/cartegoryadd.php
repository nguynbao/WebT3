<?php
    include "header.php";
    include "slider.php";
    include "class/cartegory_class.php";
?>

<?php
$cartegory = new cartegory();
if($_SERVER['REQUEST_METHOD']==='POST'){
    $cartegory_name=$_POST['cartegory_name'];
    $insert_cartegory = $cartegory->insert_cartegory($cartegory_name);
}
?>

<div class="admin_content_right">
            <div class="admin_content_right_cartegory_add">
                <h1>Thêm Danh Mục</h1>
                <form action="" method="post">
                    <input required type="text" name="cartegory_name" id="" placeholder="Nhập tên danh mục">
                    <button type="submit">Thêm</button>
                </form>
            </div>
        </div>
    </section>
</body>

</html>