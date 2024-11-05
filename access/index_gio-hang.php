<?php
session_start();

// Kiểm tra xem người dùng đã đăng nhập chưa
// if (!isset($_SESSION['id'])) {
//     // Nếu chưa đăng nhập, chuyển hướng người dùng đến trang đăng nhập
//     header("Location: index_login.php");
//     exit();
// }
require_once('header.php');
?>

<div class="breadcrumbs">
    <a href="../index.php"><span class="trangchu">Trang chủ</span></a>
    <span style="padding: 0 5px;">/</span>
    <span class="font-nomal">Giỏ hàng</span>
</div>

<div class="container_giohang">
    <h2>Giỏ hàng</h2>

    <div class="freeship-notice">
        <span class="freeship-code">NFREESHIP</span>
        <span>Chúc mừng! Đơn hàng của bạn đã đủ điều kiện được Freeship 🎉</span>
        <button class="copy-code">Sao chép</button>
    </div>
    <div class="main-content">
        <div class="cart-items">
            <?php
            if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                foreach ($_SESSION['cart'] as $item) {
            ?>
            <div class="cart-item">
                <img src="../admin/uploads/<?php echo htmlspecialchars($item['product_img']); ?>" alt="<?php echo htmlspecialchars($item['product_name']); ?>">
                <div class="item-details">
                    <p class="item-name"><?php echo htmlspecialchars($item['product_name']); ?></p>
                    <!-- Assuming you have a color for each item -->
                </div>
                <div class="item-price"><?php echo number_format($item['product_price'], 0, ',', '.'); ?>đ</div>
                <div class="item-quantity">
                    <button class="quantity-btn">-</button>
                    <span><?php echo $item['quantity']; ?></span>
                    <button class="quantity-btn">+</button>
                </div>
                <button class="remove-btn" style="margin-left:20px">Xóa</button>
            </div>
            <?php
                }
            } else {
                echo "<p>Không có sản phẩm trong giỏ hàng của bạn.</p>";
            }
            ?>
        </div>
    </div>
    <div class="order-summary">
            <h3>Vui lòng chọn địa chỉ giao hàng</h3>
            <label for="province">Tỉnh/Thành phố:</label>
            <select id="province" name="province" onchange="updateDistricts()">
            <option value="">Chọn Tỉnh/Thành phố</option>
                <!-- Tùy chọn sẽ được thêm từ JavaScript -->
            </select>
            <label for="district">Huyện/Quận:</label>
            <select id="district" name="district" onchange="updateWards()">
                <option value="">Chọn Huyện/Quận</option>
            </select>

            <label for="ward">Xã/Phường:</label>
            <select id="ward" name="ward">
                <option value="">Chọn Xã/Phường</option>
            </select>
            <script src="address.js"></script>


            <label for="delivery-address">Địa chỉ nhận hàng</label>
            <input type="text">
            <label for="delivery-address">Số điện thoại</label>
            <input type="text">
            <div class="total">
                <p>Tổng cộng:</p>
                <p id="price">0đ</p> <!-- Thay đổi giá trị mặc định thành 0đ -->
                <p>(Đã bao gồm VAT nếu có)</p>
            </div>
            <div class="discount-code">
                <p>Mã giảm giá</p>
                <button>Chọn mã giảm giá</button>
            </div>

            <label >Phương thức thanh toán</label>
            <select>
                <option value="">Thanh toán khi nhận hàng</option>
                <option value="">Thanh toán qua ngân hàng</option>
            </select>
            <button class="checkout-btn">Thanh Toán</button>
            <div class="payment-methods">
                <img src="http://theme.hstatic.net/200000696635/1001199686/14/footer_trustbadge.png?v=8" alt="Payment">
            </div>
        </div>
    </div>
</div>

<script>
 document.addEventListener('DOMContentLoaded', () => {
    const quantityButtons = document.querySelectorAll('.quantity-btn');
    const totalElement = document.querySelector('.total #price');
    const removeButtons = document.querySelectorAll('.remove-btn');

    quantityButtons.forEach(button => {
        button.addEventListener('click', (e) => {
            const isIncrement = e.target.textContent === '+';
            const quantitySpan = e.target.parentElement.querySelector('span');
            let quantity = parseInt(quantitySpan.textContent);

            if (isIncrement) {
                quantity++;
            } else if (quantity > 1) {
                quantity--;
            }

            quantitySpan.textContent = quantity;
            // Cập nhật tổng tiền khi số lượng sản phẩm thay đổi
            updateTotal();
        });
    });

    removeButtons.forEach(button => {
        button.addEventListener('click', (e) => {
            const cartItem = e.target.closest('.cart-item'); // Tìm phần tử cha gần nhất có class 'cart-item'
            const itemName = cartItem.querySelector('.item-name').textContent; // Lấy tên sản phẩm
            const confirmation = confirm(`Bạn có chắc chắn muốn xóa ${itemName} khỏi giỏ hàng không?`);
            
            if (confirmation) {
                cartItem.remove(); // Xóa phần tử cart-item ra khỏi DOM
                updateTotal(); // Cập nhật tổng tiền sau khi xóa sản phẩm
            }
        });
    });

    function updateTotal() {
    const itemPrices = document.querySelectorAll('.item-price');
    let total = 0;

    itemPrices.forEach(itemPrice => {
        const priceString = itemPrice.textContent.replace('đ', '').replace(/\D/g, '').trim(); // Loại bỏ tất cả các ký tự không phải là số
        const price = parseInt(priceString); // Chuyển đổi chuỗi số thành số nguyên
        const quantity = parseInt(itemPrice.parentElement.querySelector('.item-quantity span').textContent);
        total += price * quantity;
    });

    totalElement.textContent = formatCurrency(total);
}

function formatCurrency(amount) {
    return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(amount);
}

updateTotal();
});

</script>



<?php require_once('footer.php');?>
