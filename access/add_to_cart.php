<?php
session_start();

// Kiểm tra xem người dùng đã đăng nhập chưa
// if (!isset($_SESSION['id'])) {
//     // Nếu chưa đăng nhập, chuyển hướng người dùng đến trang đăng nhập
//     header("Location: index_login.php");
//     exit();
// }

// Lấy thông tin sản phẩm được thêm vào giỏ hàng từ POST request
$product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
$product_name = isset($_POST['product_name']) ? $_POST['product_name'] : "";
$product_price = isset($_POST['product_price']) ? floatval($_POST['product_price']) : 0;
$product_img = isset($_POST['product_img']) ? $_POST['product_img'] : "";
$quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;

// Kiểm tra xem thông tin sản phẩm có hợp lệ không
if ($product_id > 0 && $product_name && $product_price && $quantity > 0) {
    // Tạo một mảng chứa thông tin sản phẩm
    $product = [
        'product_id' => $product_id,
        'product_name' => $product_name,
        'product_price' => $product_price,
        'product_img' => $product_img,
        'quantity' => $quantity
    ];

    // Kiểm tra xem giỏ hàng của người dùng đã được khởi tạo chưa
    if (isset($_SESSION['cart'])) {
        // Nếu giỏ hàng đã tồn tại, thêm sản phẩm vào giỏ hàng
        $_SESSION['cart'][] = $product;
    } else {
        // Nếu giỏ hàng chưa được khởi tạo, tạo một giỏ hàng mới và thêm sản phẩm vào đó
        $_SESSION['cart'] = [$product];
    }
}

// Hiển thị thông báo
echo '<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>';
echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">';
echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>';
echo '<script type="text/javascript">
        $(document).ready(function() {
            toastr.success("Đã thêm sản phẩm vào giỏ hàng");
        });
        setTimeout(function() {
            window.location.href = "index_gio-hang.php";
        },1000);
      </script>';
// Dừng kịch bản PHP ở đây để trình duyệt không thực hiện chuyển hướng tự động
exit();
?>
