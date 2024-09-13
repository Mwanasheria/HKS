<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: hks.php");
    exit();
}

include 'db_connect.php';

if (isset($_GET['booking_id'])) {
    $booking_id = $_GET['booking_id'];

  
    $sql = "SELECT * FROM rooms WHERE id = ? AND username = ? AND payment_status = 'pending'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $booking_id, $_SESSION['username']);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $payment_number = $row['payment_number'];

      
        echo "Your payment number is: " . $payment_number . "<br>";
        echo "Payment successful!";

        
        $sql_update = "UPDATE rooms SET payment_status = 'confirmed' WHERE id = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("i", $booking_id);
        $stmt_update->execute();

       
        header("Location: Dashboard.php");
        exit();
    } else {
        echo "Invalid booking or already paid.";
    }

    $stmt->close();
}

$conn->close();
?>
