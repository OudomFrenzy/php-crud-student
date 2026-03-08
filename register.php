<?php
include('DBC.php');
if(isset($_POST['register'])){
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'] ?? '';

    // Check for password confirmation
    if($password !== $confirm_password){
        $error = "Passwords do not match!";
    } else {
        // Check if username already exists
        $stmt = $connection->prepare("SELECT * FROM users WHERE username=?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows > 0){
            $error = "Username already exists!";
        } else {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            // Insert into database
            $stmt = $connection->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            $stmt->bind_param("ss", $username, $hashed_password);

            if($stmt->execute()){
                header('Location: login.php');
                exit();
            } else {
                $error = "Error: " . $stmt->error;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="form-container">
    <form method="post" class="login-form">
        <h2>REGISTER</h2>
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="password" name="confirm_password" placeholder="Confirm Password" required>
        <input type="submit" name="register" value="Register">
        <?php if(isset($error)) { echo "<p class='error'>$error</p>"; } ?>
        <p>Already have an account? <a href="login.php">Login here</a></p>
    </form>
</div>
</body>
</html>