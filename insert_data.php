<?php
include('DBC.php');
if(isset($_POST['add_students'])){
    $f_name = trim($_POST['f_name']);
    $l_name = trim($_POST['l_name']);
    $gender = $_POST['gender'];
    $age = $_POST['age'];
    $email = trim($_POST['email']);

    // Validate inputs
    if(empty($f_name) || empty($l_name) || empty($gender) || empty($age) || empty($email)){
        header('Location: index.php?message=All fields are required!');
        exit();
    }

    // Prepare statement for security
    $stmt = $connection->prepare("INSERT INTO students (FirstName, LastName, Email, Gender, Age) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssi", $f_name, $l_name, $email, $gender, $age);

    if($stmt->execute()){
        header('Location: index.php?insert_msg=Your data has been added successfully');
        exit();
    } else {
        header('Location: index.php?message=Error adding data: ' . $stmt->error);
        exit();
    }

    $stmt->close();
    $connection->close();
}
?>