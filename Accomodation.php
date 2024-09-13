<?php
session_start();  
if (!isset($_SESSION['username'])) {
    header("Location: hks.php");
    exit();
}
$username = $_SESSION['username'];
include 'db_connect.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['room_id'])) {
    $room_id = $_POST['room_id'];
    $check_out = $_POST['check_out']; 

    $check_in = date('Y-m-d H:i:s');
    $payment_number = uniqid(); 


    $sql = "UPDATE rooms SET is_occupied = TRUE, username = ?, payment_status = 'pending', check_in = ?, check_out = ?, payment_number = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        
        $stmt->bind_param("ssssi", $_SESSION['username'], $check_in, $check_out, $payment_number, $room_id);
        if ($stmt->execute()) {
            $_SESSION['success_message'] = "Room booked successfully! Your payment number is: " . $payment_number;
        } else {
            echo "Error booking room: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
}


$sql = "SELECT * FROM rooms";
$result = $conn->query($sql);

$conn->close();
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accommodation</title>
    <link rel="stylesheet" href="Style.css">
    <style>
        table {
            width: 50%;
            border-collapse: collapse;
            margin: 15px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #dddddd;
            text-align: center;
        }
        th {
            background-color: #ffc107;
        }
        .book-button {
            padding: 5px 10px;
            background-color: #28a745;
            color: #fff;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }
        .book-button[disabled] {
            background-color: #ffc107;
            cursor: not-allowed;
        }
        .input-checkout {
            width: 100%;
            padding: 5px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
    </style>
</head>
<body>
<div class="container">

        <header>
            <div class="status">
                <h4><b>Accommodation Services</b></h4>
            </div>
        </header>

        <section class="quantify-section">
        <h2>© Guest House Room Booking<br> After booking return to Dashboard to confirm your payment (€)</h2>
        </section>
   
    <table>
       <tr>
         <th>Room Number</th>
         <th>Room Type</th>
         <th>Status</th>
         <th>Action</th>
       </tr> 
    <?php if ($result->num_rows > 0): ?>
        <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row["room_number"]; ?></td>
                <td><?php echo $row["room_type"]; ?></td>
                <td><?php echo $row["is_occupied"] ? "Occupied" : "Available"; ?></td>
                <td>
                    <?php if (!$row["is_occupied"]): ?>
                        <form method="POST" action="">
                            <input type="hidden" name="room_id" value="<?php echo $row['id']; ?>">
                            <input type="datetime-local" name="check_out" class="input-checkout" required>
                            <button type="submit" class="book-button">Book Now</button>
                        </form>
                    <?php else: ?>
                        <button class="book-button" disabled>Occupied</button>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr>
            <td colspan="4">No rooms available</td>
        </tr>
    <?php endif; ?>
    </table>
    <nav class="bottom-nav">
    <a href="Dashboard.php" class="nav-button">Dashboard</a>
        <a href="FOOD.php" class="nav-button">Food</a>
        <a href="Accommodation.php">Accommodation</a>
        <a href="Me.php" class="nav-button">Me</a>
    </nav>
</div> 
</body>
</html>
