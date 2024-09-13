<?php
include 'db_connect.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    $username = $_POST['username'];
    $phone = $_POST['phone'];
    $Region = $_POST['Region'];
    $password = $_POST['password'];
    $retype_password = $_POST['retype_password'];

    if ($password !== $retype_password) {
        echo "Passwords do not match!";
        exit();
    }

    $hashed_password = hash('SHA256', $password);

    $sql = "INSERT INTO users (username, phone, Region, password) VALUES ('$username', '$phone', '$Region', '$hashed_password')";
    if ($conn->query($sql) === TRUE) {
        echo "Registration successful!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $sql->bind_param("s", $username);
    $sql->execute();
    $result = $sql->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
         session_start();
        if (hash("sha256", $password) == $row["password"]) {
            $_SESSION['username'] = $username;
            header("Location: Dashboard.php");
            exit();
        } else {
            echo "Wrong password!";
        }
    } else {
        echo "No Customer found with that username!";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UserLogin</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #faff81;     
        }

        .login-container, .register-container {
            background-color:#b26700;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 40px 30px;
            text-align: center;
            width: 300px;
        }

        .login-container h2, .register-container h2 {
            margin-bottom: 20px;
        }

        .login-container input[type="text"],
        .login-container input[type="password"],
        .register-container input[type="text"],
        .register-container input[type="password"],
        .register-container input[type="number"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .login-container button, .register-container button {
            width: 90%;
            padding: 10px;
            margin-top: 20px;
            background: #faff81;
            border: none;
            border-radius: 5px;
            color: black;
            font-size: 16px;
            cursor: pointer;
        }

        .login-container button:hover, .register-container button:hover {
            background: #ffc53a;
        }

        .login-container .forgot-password,
        .login-container .create-account {
            margin-top: 10px;
            display: block;
            color: black;
            text-decoration: none;
        }

       .login-container .forgot-password:hover,
        .login-container .create-account:hover {
            text-decoration: underline;

        }
        .hidden {
            display: none;
        }
        h10{
         color: maroon;
        }
    </style>
</head>
<body>

    <div id="Login-form" class="login-container">
        <h10>WELCOME TO<b> GR </b>CITY HOTEL </h10> 
        <h2>Customer Login</h2>
        <form method="post" action="">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="login">Login</button>
            <a href="ForgotPassword.php" class="forgot-password">Forgot Username Password?</a>
            <a href="#" class="create-account" onclick="toggleForm('Register')">Register</a>
        </form>
    </div>

    <div id="Register-form" class="register-container hidden">
        <h10>WELCOME TO <b> GR </b> CITY HOTEL</h10> 
         <h3>Register</h3>
        <form method="post" action="">
            <div class="form-group">
                <input type="text" id="username" name="username" placeholder="username" required>
            </div>
            <div class="form-group">
                <input type="number" id="phone" name="phone" placeholder="0687030949" required>
            </div>
            <div class="form-group">
                <input type="text" id="Region" name="Region" placeholder="Region" required>
            </div>
            <div class="form-group">
                <input type="password" id="password" name="password" placeholder="Password" required>
            </div>
            <div class="form-group">
                <input type="password" id="retype_password" name="retype_password" placeholder="Re-Type Password" required>
            </div>
            <button type="submit" name="register">Register</button>
            <a href="#" onclick="toggleForm('Login')">Back to Login</a>
        </form>
    </div>

    <script>
        function toggleForm(formType) {
            document.getElementById('Login-form').classList.add('hidden');
            document.getElementById('Register-form').classList.add('hidden');

            if (formType === 'Register') {
                document.getElementById('Register-form').classList.remove('hidden');
            } else if (formType === 'Login') {
                document.getElementById('Login-form').classList.remove('hidden');
            }
        }
    </script>



</body>
</html>
