<?php
session_start();
require_once('database.php'); // Đảm bảo kết nối database

$pdo = new PDO('mysql:host=localhost;dbname=', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// Kiểm tra nếu giỏ hàng không trống
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "Giỏ hàng của bạn đang trống!";
    exit();
}

// Kiểm tra thông tin từ form
$delivery_address = isset($_POST['delivery_address']) ? trim($_POST['delivery_address']) : "";
$phone = isset($_POST['phone']) ? trim($_POST['phone']) : "";
$payment_method = isset($_POST['payment_method']) ? trim($_POST['payment_method']) : "";

// Kiểm tra thông tin giao hàng
if (empty($delivery_address) || empty($phone) || empty($payment_method)) {
    echo "Vui lòng điền đầy đủ thông tin giao hàng.";
    exit();
}

// Lưu thông tin đơn hàng vào cơ sở dữ liệu
try {
    $pdo->beginTransaction();

    // Thêm đơn hàng
    $sql_order = "INSERT INTO orders (user_id, total_price, delivery_address, phone, payment_method, created_at)
                  VALUES (:user_id, :total_price, :delivery_address, :phone, :payment_method, NOW())";
    $stmt_order = $pdo->prepare($sql_order);
    $total_price = array_reduce($_SESSION['cart'], function ($sum, $item) {
        return $sum + $item['product_price'] * $item['quantity'];
    }, 0);
    $stmt_order->execute([
        ':user_id' => $_SESSION['id'] ?? null,
        ':total_price' => $total_price,
        ':delivery_address' => $delivery_address,
        ':phone' => $phone,
        ':payment_method' => $payment_method,
    ]);

    // Lấy ID của đơn hàng vừa tạo
    $order_id = $pdo->lastInsertId();

    // Thêm chi tiết đơn hàng
    $sql_detail = "INSERT INTO order_details (order_id, product_id, product_name, product_price, quantity)
                   VALUES (:order_id, :product_id, :product_name, :product_price, :quantity)";
    $stmt_detail = $pdo->prepare($sql_detail);
    foreach ($_SESSION['cart'] as $item) {
        $stmt_detail->execute([
            ':order_id' => $order_id,
            ':product_id' => $item['product_id'],
            ':product_name' => $item['product_name'],
            ':product_price' => $item['product_price'],
            ':quantity' => $item['quantity'],
        ]);
    }

    $pdo->commit();
    // Xóa giỏ hàng sau khi đặt hàng thành công
    unset($_SESSION['cart']);
    header('Location: index.php'); // Chuyển hướng
    exit();
} catch (Exception $e) {
    $pdo->rollBack();
    echo "Đã xảy ra lỗi khi đặt hàng: " . $e->getMessage();
}
