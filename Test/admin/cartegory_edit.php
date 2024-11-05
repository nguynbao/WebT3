<?php
    include "header.php";
    include "slider.php";
    include "class/cartegory_class.php";
?>

<?php
$cartegory = new cartegory();
if(!isset($_GET["cartegory_id"])  || $_GET["cartegory_id"]==NULL){
    echo "<script>window.location = 'cartegory_list.php'</script>";
}
else{
    $cartegory_id = $_GET['cartegory_id'];
}
$get_cartegory = $cartegory->get_cartegory($cartegory_id);
if($get_cartegory){
    $result = $get_cartegory->fetch_assoc();
}
?>

<?php
if($_SERVER['REQUEST_METHOD']==='POST'){
    $cartegory_name=$_POST['cartegory_name'];
    $update_cartegory = $cartegory->update_cartegory($cartegory_name,$cartegory_id);
}
?>

<div class="admin_content_right">
            <div class="admin_content_right_cartegory_add">
                <h1>Sửa Danh Mục</h1>
                <form action="" method="post">
                    <input required type="text" name="cartegory_name" id="" placeholder="Nhập tên danh mục" value="<?php echo $result['cartegory_name'] ?>">
                    <button type="submit">Sửa</button>
                </form>
            </div>
        </div>
    </section>
</body>

</html>