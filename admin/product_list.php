<?php
session_start();
if(isset($_SESSION['admin'])){
    include "header.php";
    include "slider.php";
    include "class/product_class.php";
    $product = new product();
    $show_product = $product->show_product();
    echo '
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
                </tr>';
    if ($show_product) {
        $i = 0;
        while ($result = $show_product->fetch_assoc()) {
            $i++;
            echo '
                <tr>
                    <td>'. $i .'</td>
                    <td>'. $result['product_id'] .'</td>
                    <td>'. $result['product_name'] .'</td>
                    <td>'. $result['cartegory_name'] .'</td>
                    <td>'. $result['brand_name'] .'</td>
                    <td>'. number_format($result['product_price'], 0, ',', '.') .' VND</td>
                    <td>'. number_format($result['product_price_new'], 0, ',', '.') .' VND</td>
                    <td><img src="uploads/'. $result['product_img'] .'" width="50" alt="Product Image"></td>
                    <td>
                        <a href="product_edit.php?product_id='. $result['product_id'] .'">Sửa</a> |
                        <a href="product_delete.php?product_id='. $result['product_id'] .'">Xóa</a>
                    </td>
                </tr>';
        }
    }
    echo '
            </table>
        </div>
    </div>
    </section>
    </body>
    </html>';
}else{
    echo '
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script type="text/javascript">
    $(document).ready(function() {
        toastr.warning("Bạn cần đăng nhập!");
    });
        </script>';
    echo '<script type="text/javascript">
        setTimeout(function() {
            window.location.href = "../access/index_login.php";
        }, 0);
        </script>';
}
?>
