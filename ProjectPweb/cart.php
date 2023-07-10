<?php
session_start();

// Check if the product is added to the cart
if(isset($_POST["add_to_cart"])) {
    if(isset($_SESSION["cart"])) {
        $item_array_id = array_column($_SESSION["cart"], "product_id");
        if(!in_array($_GET["id"], $item_array_id)) {
            $count = count($_SESSION["cart"]);
            $item_array = array(
                'product_id' => $_GET["id"],
                'product_name' => $_POST["hidden_name"],
                'product_price' => $_POST["hidden_price"],
                'product_quantity' => $_POST["quantity"]
            );
            $_SESSION["cart"][$count] = $item_array;
        } else {
            echo "<script>alert('Product is already added to the cart!')</script>";
        }
    } else {
        $item_array = array(
            'product_id' => $_GET["id"],
            'product_name' => $_POST["hidden_name"],
            'product_price' => $_POST["hidden_price"],
            'product_quantity' => $_POST["quantity"]
        );
        $_SESSION["cart"][0] = $item_array;
    }
}

// Remove product from the cart
if(isset($_GET["action"])) {
    if($_GET["action"] == "delete") {
        foreach($_SESSION["cart"] as $keys => $values) {
            if($values["product_id"] == $_GET["id"]) {
                unset($_SESSION["cart"][$keys]);
                echo "<script>alert('Product has been removed from the cart!')</script>";
                echo "<script>window.location = 'cart.php'</script>";
            }
        }
    }
}
?>

<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cart</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <header>
        <div class="container">
            <h1><a href="index.html">ALODOCX</h1>
            <ul>
                <li><a href="index.html">HOME</a></li>
                <li><a href="product.html">PRODUCT</a></li>
                <li><a href="contact.html">CONTACT</a></li>
                <li class="active"><a href="cart.php">CART</a></li>
            </ul>
        </div>
    </header>

    <section class="cart">
        <div class="container">
            <h3>Shopping Cart</h3>
            <table>
                <tr>
                    <th>Product Name</th>
                </tr>
                <tr>
                    <th>Price</th>
                </tr>
                <tr>
                    <th>Quantity</th>
                </tr>
                <tr>
                    <th>Total</th>
                </tr>
                <tr>
                    <th>Action</th>
                </tr>
                <?php
                
                if(!empty($_SESSION["cart"])) {
                    $total = 0;
                    foreach($_SESSION["cart"] as $keys => $values) {
                ?>
                <tr>
                    <td><?php echo $values["product_name"];?></td>
                    <td><?php echo $values["product_price"]; ?></td>
                    <td><?php echo $values["product_quantity"]; ?></td>
                    <td><?php echo number_format($values["product_price"] * $values["product_quantity"], 2); ?></td>
                    <td><a href="cart.php?action=delete&id=<?php echo $values["product_id"]; ?>"><i class="fas fa-trash"></i></a></td>
                </tr>
                <?php
                        $total = $total + ($values["product_price"] * $values["product_quantity"]);
                    }
                ?>
                <tr>
                    <td colspan="3" align="right">Total</td>
                    <td align="right"><?php echo number_format($total, 2); ?></td>
                    <td></td>
                </tr>
                <?php
                }
                ?>
            </table>
        </div>
    </section>

    <section class="checkout">
        <div class="container">
            <h3>Checkout</h3>
            <form method="post" action="checkout.php">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
                <label for="address">Address:</label>
                <textarea id="address" name="address" required></textarea>
                <button type="submit" name="checkout">Checkout</button>
            </form>
        </div>
    </section>

    <footer>
        <div class="container">
            <small>© 2023 - KAMIBISA, All Rights Reserved.</small>
        </div>
    </footer>
</body>
</html>