<?php
session_start();            // 1. PHP session starts
include('DBC.php');          // 2. Include database

// 3. Handle form submission BEFORE any HTML output
if(isset($_POST['update_student'])){
    $idnew = intval($_POST['id']); 
    $fname = mysqli_real_escape_string($connection, $_POST['f_name']);
    $lname = mysqli_real_escape_string($connection, $_POST['l_name']);
    $age = intval($_POST['age']);
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $gender = mysqli_real_escape_string($connection, $_POST['gender']);

    $query = "UPDATE students 
              SET FirstName='$fname', LastName='$lname', Age=$age,
                  Email='$email', Gender='$gender'
              WHERE Id=$idnew";

    $result = mysqli_query($connection, $query);
    if(!$result){
        die("Query Failed: ".mysqli_error($connection));
    }

    // 4. Redirect after update
    header('Location: index.php?update_msg=You have successfully updated the data');
    exit(); // stop execution after redirect
}

// 5. Fetch student data to pre-fill form
if(isset($_GET['id'])){
    $id = intval($_GET['id']);
    $result = mysqli_query($connection, "SELECT * FROM students WHERE Id = $id");
    if(!$result) die("Query Failed: ".mysqli_error($connection));
    $row = mysqli_fetch_assoc($result);
    if(!$row) die("Student not found!");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Project</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h1 id="main_title">CRUD Project</h1>
<div class="container">
    <form method="POST" action="">
        <input type="hidden" name="id" value="<?php echo $row['Id']; ?>">
        <div class="mb-3">
            <label>First Name</label>
            <input type="text" name="f_name" class="form-control" value="<?php echo $row['FirstName']; ?>" required>
        </div>
        <div class="mb-3">
            <label>Last Name</label>
            <input type="text" name="l_name" class="form-control" value="<?php echo $row['LastName']; ?>" required>
        </div>
        <div class="mb-3">
            <label>Age</label>
            <input type="number" name="age" class="form-control" value="<?php echo $row['Age']; ?>" required>
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="<?php echo $row['Email']; ?>" required>
        </div>
        <div class="mb-3">
            <label>Gender</label>
            <select name="gender" class="form-control" required>
                <option value="Male" <?php if($row['Gender']=='Male') echo 'selected'; ?>>Male</option>
                <option value="Female" <?php if($row['Gender']=='Female') echo 'selected'; ?>>Female</option>
                <option value="Other" <?php if($row['Gender']=='Other') echo 'selected'; ?>>Other</option>
            </select>
        </div>
        <button type="submit" name="update_student" class="btn btn-success">UPDATE</button>
    </form>
</div>
</body>
</html>