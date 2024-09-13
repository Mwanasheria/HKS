<?php
session_start();  
if (!isset($_SESSION['username'])) {
    header("Location: hks.php");
    exit();
}
$username = $_SESSION['username'];
 include 'db_connect.php'; 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['food_item']) && !empty($_POST['quantity'])) {
        $username = $_SESSION['username'];
        $user_id = $_SESSION['user_id'];
        $food_items = $_POST['food_item'];
        $quantities = $_POST['quantity'];

        $filtered_food_items = [];
        $filtered_quantities = [];

        for ($i = 0; $i < count($food_items); $i++) {
            if (!empty($food_items[$i]) && !empty($quantities[$i])) {
                $filtered_food_items[] = $food_items[$i];
                $filtered_quantities[] = $quantities[$i];
            }
        }

        if (count($filtered_food_items) === count($filtered_quantities)) {
            if ($conn) {
                $stmt = $conn->prepare("INSERT INTO food_orders (username, user_id, food_item, quantity) VALUES (?, ?, ?, ?)");

                for ($i = 0; $i < count($filtered_food_items); $i++) {
                    $food_item = $filtered_food_items[$i];
                    $quantity = $filtered_quantities[$i];

                    $stmt->bind_param("sisi", $username, $user_id, $food_item, $quantity);
                    $stmt->execute();
                }

                $stmt->close();
                $conn->close();

                header("Location: Dashboard.php?order=success");
                exit();
            } else {
                echo "Database connection failed.";
            }
        } else {
            echo "The number of selected items and quantities do not match.";
        }
    } else {
        echo "No food items were selected.";
    }
}
?>






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food</title>
    <link rel="stylesheet" href="Style.css">
   
</head>
<body>
    <div class="container">
        <header>
            <div class="status">
                <h4>Food Services</h4>
            </div>
        </header>

        <section class="quantify-section">
            <h2>Choose food below and return to Dashboard to confirm your payment (€)</h2>
        </section>

        <form action="Food.php" method="POST">
            <section class="section">
                <div class="card">
                    <div class="header">
                        <h3>Rice and Meat</h3>
                        <button type="button" class="details-btn">See details</button>
                    </div>
                    <ul class="details-img">
                        <li><img src="Rice_meat.jpg" style="width: 200px; height: 200px; border-radius: 50%;"></li>
                    </ul>
                    <div class="payment">
                        <h3>Payment:2000 TZS / 1 USD</h3>
                        <div class="placeOrder">
                         <input type="checkbox" name="food_item[]" value="Rice and Meat">
                         <label for="quantity">Quantity:</label>
                         <input type="number" name="quantity[]" min="1" value="1"> <button type="submit" class="placeOrder-btn">Place Order</button>
                        </div> 
                   </div>
                    
                </div>
                
            </section>


            <section class="section">
                <div class="card">
                    <div class="header">
                        <h3> Meat and vegitable</h3>
                        <button type="button" class="details-btn">See details</button>
                    </div>
                    <ul class="details-img">
                        <li><img src="meat_vegitable.jpg" style="width: 200px; height: 200px; border-radius: 50%;"></li>
                    </ul>
                    <div class="payment">
                        <h3>Payment:5000 TZS / 2 USD</h3>
                        <div class="placeOrder">
                         <input type="checkbox" name="food_item[]" value=" Meat and vegitable">
                         <label for="quantity">Quantity:</label>
                         <input type="number" name="quantity[]" min="1" value="1"> <button type="submit" class="placeOrder-btn">Place Order</button>
                        </div> 
                   </div>
                    
                </div>
                
            </section>

            
        </form>

        <nav class="bottom-nav">
            <a href="Dashboard.php" class="nav-button">Dashboard</a>
            <a href="FOOD.php" class="nav-button">Food</a>
            <a href="ACCOMODATION.php">Accomodation</a>
            <a href="Me.php" class="nav-button">Me</a>
        </nav>
    </div>


    <script>
    document.querySelector('form').addEventListener('submit', function(event) {
        const checkboxes = document.querySelectorAll('input[name="food_item[]"]:checked');
        if (checkboxes.length === 0) {
            alert('Please select at least one food item.');
            event.preventDefault(); // Prevent form submission
        }
    });
</script>
  
</body>
</html>
