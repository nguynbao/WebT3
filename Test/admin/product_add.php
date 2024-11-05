<?php
    include "header.php";
    include "slider.php";
    include "class/product_class.php";
?>

<?php
    $product = new product;
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // var_dump($_POST, $_FILES);

        
        $insert_product = $product->insert_product($_POST, $_FILES);
    }
?>

<div class="admin_content_right">
<div class="admin_content_right_product_add">
                <h1>Thêm Sản Phẩm</h1>
                <form action="" method="post" enctype="multipart/form-data">
                    <label for="">Nhập tên sản phẩm <span style ="color: red;">*</span></label>
                    <input required type="text" name="product_name" id="">
                    <label for="">Chọn Danh Muc <span style="color: red;">*</span></label>
                    <select name="cartegory_id" id="cartegory_id" required>
                        <option value="">--Chọn--</option>
                        <?php
                        $show_cartegory = $product->show_cartegory();
                        if ($show_cartegory) {
                            while ($result = $show_cartegory->fetch_assoc()) {
    
                        ?>
                        <option value="<?php echo $result['cartegory_id'] ?>"><?php echo $result['cartegory_name'] ?></option>
                        <?php
                            }
                        }
                        ?>
                    </select>
                    <label for="">Chọn Loại Sản Phẩm <span style="color: red;">*</span></label>
                    <select name="brand_id" id="brand_id" required>
                        
                        <option value="">--Chọn--</option>
                       
                    </select>
                    <label for="">Giá sản phẩm <span style="color: red;">*</span></label>
                    <input required type="text" name="product_price">
                    <label for="">Giá khuyến mãi <span style="color: red;">*</span></label>
                    <input required type="text" name="product_price_new">
                    <label for="">Mô tả sản phẩm <span style="color: red;">*</span></label>
                    <textarea required name="product_desc" id="" rows="10" cols="30"></textarea>
                    <label for="">Ảnh sản phẩm<span style="color: red;">*</span></label>
                    <input required type="file" name="product_img">
                    <label for="">Ảnh mô tả<span style="color: red;">*</span></label>
                    <input required multiple type="file" name="product_img_desc[]">
                    <button type="submit">Thêm</button>
                </form>
            </div>
        </div>
    </section>
</body>

<script>
    $(document).ready(function(){
        $("#cartegory_id").change(function(){
            var x = $(this).val()
            $.get("product_add_ajax.php", {cartegory_id:x}, function(data){
                $("#brand_id").html(data);
            })
        })
    })
</script>

</html>