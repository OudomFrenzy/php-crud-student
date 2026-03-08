<?php
session_start(); // must be first

if(!isset($_SESSION['username'])){
    header('Location: login.php');
    exit();
}

include('DBC.php'); // database connection
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home page</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container my-4">
        <h1 id="main_title" class="text-center mb-4">STUDENTS LIST</h1>

        <!-- Box1 -->
        <div class="box1 d-flex justify-content-between align-items-center mb-3">
            <h2 class="fs-5">STUDENTS DATA :</h2>
            <button class="btn btn-red" data-bs-toggle="modal" data-bs-target="#exampleModal">ADD STUDENTS</button>
        </div>

        <!-- Alerts -->
        <?php
        if(isset($_GET['message'])){
            echo "<div class='alert alert-danger text-center'>".$_GET['message']."</div>";
        }
        if(isset($_GET['insert_msg'])){
            echo "<div class='alert alert-success text-center'>".$_GET['insert_msg']."</div>";
        }
        if(isset($_GET['delete_msg'])){
            echo "<div class='alert alert-danger text-center'>".$_GET['delete_msg']."</div>";
        }
        ?>

        <!-- Responsive Table -->
        <div class="table-responsive">
            <table class="table table-hover table-border table-striped">
                <thead>
                    <tr class="table-dark">
                        <th>ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Gender</th>
                        <th>Age</th>
                        <th>Email</th>
                        <th>Update</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT * FROM `students`";
                    $result = mysqli_query($connection, $query);

                    if($result){
                        while($row = mysqli_fetch_assoc($result)){
                            echo "<tr>
                                <td>".$row['Id']."</td>
                                <td>".$row['FirstName']."</td>
                                <td>".$row['LastName']."</td>
                                <td>".$row['Gender']."</td>
                                <td>".$row['Age']."</td>
                                <td>".$row['Email']."</td>
                                <td><a href='update_page_1.php?id=".$row['Id']."' class='btn btn-success btn-sm'>Update</a></td>
                                <td><a href='delete_page_1.php?id=".$row['Id']."' class='btn btn-danger btn-sm'>Delete</a></td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8' class='text-center'>No students found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Modal for adding student -->
        <form action="insert_data.php" method="post">
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add New Student</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">First Name</label>
                                <input type="text" name="f_name" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Last Name</label>
                                <input type="text" name="l_name" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Gender</label>
                                <select name="gender" class="form-control" required>
                                    <option value="">-- Select Gender --</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Age</label>
                                <input type="number" name="age" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <input type="submit" class="btn btn-success" name="add_students" value="ADD">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>