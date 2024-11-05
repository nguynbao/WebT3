<?php
session_start();
require_once('header.php');
?>


    <div class="breadcrumbs">
        <a href="../index.php"><span class="trangchu">Trang chủ</span></a>
        <span style="padding: 0 5px;">/</span>
        <span class="font-nomal">Kiểm tra đơn hàng</span>
    </div>

    <div class="container_check">
        <h2>Kiểm tra đơn hàng</h2>
        <form id="orderForm">
            <label for="orderId">Nhập mã đơn hàng:</label>
            <input type="text" id="orderId" name="orderId" required>
            <button type="submit">Kiểm tra</button>
        </form>
        <div id="orderDetails" class="hidden">
        </div>
    </div>
    <script>
        document.getElementById("orderForm").addEventListener("submit", function(event) {
            event.preventDefault();
            var orderId = document.getElementById("orderId").value;
            var orderData = getOrderData(orderId);
            displayOrderDetails(orderData);
        });

        function getOrderData(orderId) {
            // Dữ liệu đơn hàng giả lập
            if (orderId === "NS001") {
                return {
                    id: orderId,
                    productName: "Áo Manchester City 2023-2024",
                    quantity: 2,
                    price: "500.000 đ",
                    NameRecipient: "Nguyễn Tất Ngọc",
                    Address: "Thôn Mai Lộc 2, Cam Chính, Cam Lộ, Quảng Trị",
                    Phone: "08472244225",
                    PaymentMethods: "Ngân hàng",
                    TimeOrder: "29/05/2024"
                };
            } else if (orderId === "NS002") {
                return {
                    id: orderId,
                    productName: "Giày 3 sọc",
                    quantity: 1,
                    price: "149.000 đ",
                    NameRecipient: "Nguyễn Văn A",
                    Address: "140 Lê Trọng Tấn, Tây Thạnh, Tân Phú, Hồ Chí Minh",
                    Phone: "013456789",
                    PaymentMethods: "Tiền mặt",
                    TimeOrder: "30/05/2024"
                };
            } else {
                return null; // Trả về null nếu không tìm thấy đơn hàng với mã đơn hàng đã nhập
            }
        }

        function displayOrderDetails(orderData) {
            var orderDetails = document.getElementById("orderDetails");
            orderDetails.innerHTML = "";
            orderDetails.classList.remove("hidden");
            if (orderData) {
                orderDetails.innerHTML = `
                    <h3 class="order-heading">Thông tin đơn hàng</h3>
                    <div class="order-details">
                        <div class="personal-info">
                            <p><strong class="order-label">Tên người nhận:</strong> <span class="order-info">${orderData.NameRecipient}</span></p>
                            <p><strong class="order-label">Địa chỉ:</strong> <span class="order-info">${orderData.Address}</span></p>
                            <p><strong class="order-label">Số điện thoại:</strong> <span class="order-info">${orderData.Phone}</span></p>
                            <p><strong class="order-label">Phương thức thanh toán:</strong> <span class="order-info">${orderData.PaymentMethods}</span></p>
                        </div>
                        <div class="order-info-wrapper">
                            <p><strong class="order-label">Mã đơn hàng:</strong> <span class="order-info">${orderData.id}</span></p>
                            <p><strong class="order-label">Sản phẩm:</strong> <span class="order-info">${orderData.productName}</span></p>
                            <p><strong class="order-label">Số lượng:</strong> <span class="order-info">${orderData.quantity}</span></p>
                            <p><strong class="order-label">Giá:</strong> <span class="order-info">${orderData.price}</span></p>
                            <p><strong class="order-label">Thời gian đặt hàng:</strong> <span class="order-info">${orderData.TimeOrder}</span></p>
                        </div>
                    </div>
                `;
            } else {
                orderDetails.innerHTML = "<p>Không tìm thấy đơn hàng với mã này. Vui lòng kiểm tra lại!</p>";
            }
        }
    </script>
<?php require_once('footer.php');?>