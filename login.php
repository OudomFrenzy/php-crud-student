<?php
session_start();
include('DBC.php');

// Redirect if already logged in
if(isset($_SESSION['username'])){
    header('Location: index.php');
    exit();
}

if(isset($_POST['login'])){
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Prepared statement to prevent SQL injection
    $stmt = $connection->prepare("SELECT * FROM users WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
        if(password_verify($password, $row['password'])){
            session_regenerate_id(true); // prevent session fixation
            $_SESSION['username'] = $username;
            header('Location: index.php');
            exit();
        } else {
            $error = "Incorrect password!";
        }
    } else {
        $error = "Username not found!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Form</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="form-container">
    <form method="post" class="login-form">
        <h2>LOGIN</h2>
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="submit" name="login" value="Login">
        <?php if(isset($error)) { echo "<p class='error'>$error</p>"; } ?>
        <p>Don't have an account? <a href="register.php">Register here</a></p>
    </form>
</div>
</body>
</html>