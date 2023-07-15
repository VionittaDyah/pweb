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
    <div class="medsos">
        <div class="container">
            <ul>
                <li><a href="https://www.facebook.com/UADYogyakarta"><i class="fab fa-facebook"></i></a></li>
                <li><a href="https://www.youtube.com/channel/UCEw9Tv_E3nMMIUrXIYIPsKA"><i class="fab fa-youtube"></i></a></li>
                <li><a href="https://instagram.com/butterlof"><i class="fab fa-instagram"></i></a></li>
            </ul>
        </div>
    </div>
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
            <h3>SHOPPING CART</h3>
            <div class="form-section">
                <form action="/Database/process.php" method="post" enctype="multipart/form-data">
                <div class="left-side">
                  <input type="text" placeholder="Nama Lengkap" name="Nama_Lengkap" autocomplete="off" required/>
                  <input type="number" placeholder="No Telepon" name="No_Telepon" autocomplete="off" required/>
                  <input type="text" placeholder="Alamat Pengantaran" name="Alamat" autocomplete="off" required/>
                <div class="selection">
                    <select name="tipe" id="tipe" onchange="drugsSelection()">
                      <option value="0">MED-DRUGS</option>
                      <option value="ambroxol">AMBROXOL</option>
                      <option value="anelat">ANELAT</option>
                      <option value="gluco">GLUCO STRIP</option>
                      <option value="ta">TOLAK ANGIN</option>
                      <option value="imboost">IMBOOST vit</option>
                      <option value="sangobion">SANGOBION vit</option>
                      <option value="rhinos">GLUCO STRIP</option>
                      <option value="fluimucil">FLUIMUCIL</option>
                      <option value="meprolut">MEPROLUT</option>
                      <option value="metformin">METFORMIN</option>
                    </select>
            <div class="right-side">
              <p class="docreceipt">RECEIPT DOCTER</p>
              <div class="file-upload">
                <input type="file" name="receipt" required/>
            </div>
            <div class="submit">
                <input type="submit" id="submit" />
            </div>
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
    <footer>
        <div class="container">
            <small>Copyright &copy; 2023 - KAMIBISA, All Rights Reserved.</small>
        </div>
    </footer>
</body>
</html>