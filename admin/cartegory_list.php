<?php
session_start();
if (isset($_SESSION['admin'])) {
    include "header.php";
    include "slider.php";
    include "class/cartegory_class.php";
    $cartegory = new cartegory();
    $show_cartegory = $cartegory->show_cartegory();
    ?>
    <div class="admin_content_right">
        <div class="admin_content_right_cartegory_list">
            <h1>Danh Sách Danh Mục</h1>
            <table>
                <tr>
                    <th>STT</th>
                    <th>ID</th>
                    <th>Danh Mục</th>
                    <th>Tùy Biến</th>
                </tr>
                <?php
                if ($show_cartegory) {
                    $i = 0;
                    while ($result = $show_cartegory->fetch_assoc()) {
                        $i++;
                        ?>
                        <tr>
                            <td><?php echo $i ?></td>
                            <td><?php echo $result['cartegory_id'] ?></td>
                            <td><?php echo $result['cartegory_name'] ?></td>
                            <td>
                                <a href="cartegory_edit.php?cartegory_id=<?php echo $result['cartegory_id'] ?>">Sửa</a> |
                                <a href="cartegory_delete.php?cartegory_id=<?php echo $result['cartegory_id'] ?>">Xóa</a>
                            </td>
                        </tr>
                        <?php
                    }
                }
                ?>
            </table>
        </div>
    </div>
    </section>
    </body>
    </html>
    <?php
} else {
    echo "Error: 404!";
}
?>
