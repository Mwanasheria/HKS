<?php
session_start();  
if (!isset($_SESSION['username'])) {
    header("Location: hks.php");
    exit();
}
$username = $_SESSION['username'];

include 'db_connect.php';


$query_food_orders = "SELECT * FROM food_orders WHERE username= ? AND payment_status = 'pending'";
if (!$stmt_food = $conn->prepare($query_food_orders)) {
    die("Error preparing statement for food orders: " . $conn->error);
}
$stmt_food->bind_param('s', $username); 
$stmt_food->execute();
$result_food = $stmt_food->get_result();

$payment_number = isset($_SESSION['payment_number']) ? $_SESSION['payment_number'] :'';   
$query_room_bookings = "SELECT * FROM rooms WHERE username = ? AND payment_status = 'pending' AND payment_number = ?";
if (!$stmt_room = $conn->prepare($query_room_bookings)) {
    die("Error preparing statement for room bookings: " . $conn->error);
}
$stmt_room->bind_param('ss', $username, $payment_number);
$stmt_room->execute();
$result_room = $stmt_room->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="Style.css">
    <style>
        table {
            width: 90%;
            max-width: 400px;
            border-collapse: collapse;
            margin-bottom: 20px;
            margin-right: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #faff81;
        }
        .pay-button {
            padding: 5px 10px;
            background-color: #28a745;
            color: #fff;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }
        .success-message {
            color: green;
            font-weight: bold;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<div class="container">

<center><h2>Welcome, <?php echo $_SESSION['username']; ?>!</h2></center>

<a href="hks.php"><span>Logout</span></a>

<h4>Your Food Orders</h4>
<?php if ($result_food->num_rows > 0): ?>
    <table>
        <tr>
            <th>Food Items</th>
            <th>Quantity</th>
            <th>Order Date</th>
            <th>Action</th>
        </tr>
        <?php while ($row = $result_food->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['food_item']; ?></td>
                <td><?php echo $row['quantity']; ?></td>
                <td><?php echo $row['order_date']; ?></td>
                <td><a href="payment.php?booking_id=<?php echo $row['id']; ?>"><button type="button" class="pay-button">Pay Now</button></a></td>
            </tr>
        <?php endwhile; ?>
    </table>
<?php else: ?>
    <p>You have no pending food orders.</p>
<?php endif; ?>

<h4>Your Room Bookings</h4>
       

<?php if (isset($_SESSION['success_message'])): ?>
    <div class="success-message">
        <?php
        echo $_SESSION['success_message'];
        unset($_SESSION['success_message']);
        ?>
    </div>
<?php endif; ?>

<?php if ($result_room->num_rows > 0): ?>
    <table>
        <tr>
            <th>ID</th>
            <th>Room Number</th>
            <th>Room Type</th>
            <th>Check-In Date</th>
            <th>Check-Out Date</th>
            <th>Total Price</th>
            <th>Action</th>
        </tr>
        <?php while ($row = $result_room->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['room_number']; ?></td>
                <td><?php echo $row['room_type']; ?></td>
                <td><?php echo $row['check_in']; ?></td>
                <td><?php echo $row['check_out']; ?></td>
                <td><?php echo $row['total_price']; ?> TZS</td>
                <td><a href="payment.php?booking_id=<?php echo $row['id']; ?>"><button type="button" class="pay-button">Pay Now</button></a></td>
            </tr>
        <?php endwhile; ?>
    </table>
<?php else: ?>
    <p>You have no pending room bookings.</p>
<?php endif; ?>

<nav class="bottom-nav">
    <a href="Dashboard.php" class="nav-button">Dashboard</a>
    <a href="FOOD.php" class="nav-button">Food</a>
    <a href="ACCOMODATION.php">Accommodation</a>
    <a href="Me.php" class="nav-button">Me</a>
</nav>
</div>
</body>
</html>

<?php
$stmt_food->close();
$stmt_room->close();
$conn->close();
?>
