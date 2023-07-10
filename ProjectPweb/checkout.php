<?php
session_start();

if(isset($_POST["checkout"])) {
    // Connect to the database
    $conn = mysqli_connect("localhost", "username", "password", "database_name");

    // Check connection
    if(!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Get user input
    $name = $_POST["name"];
    $email = $_POST["email"];
    $address = $_POST["address"];

    // Insert order details into the database
    $sql = "INSERT INTO orders (name, email, address) VALUES ('$name', '$email', '$address')";
    if(mysqli_query($conn, $sql)) {
        $order_id = mysqli_insert_id($conn);

        // Insert order items into the database
        foreach($_SESSION["cart"] as $keys => $values) {
            $product_id = $values["product_id"];
            $product_name = $values["product_name"];
            $product_price = $values["product_price"];
            $product_quantity = $values["product_quantity"];

            $sql = "INSERT INTO order_items (order_id, product_id, product_name, product_price, product_quantity) VALUES ('$order_id', '$product_id', '$product_name', '$product_price', '$product_quantity')";
            mysqli_query($conn, $sql);
        }

        // Clear the cart
        unset($_SESSION["cart"]);

        // Redirect to thank you page
        header("Location: thank_you.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
}
?>
