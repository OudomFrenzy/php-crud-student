<?php
include('DBC.php');


if(isset($_GET['id'])){
    $id = $_GET['id'];

    // Delete the row
    $query = "DELETE FROM `students` WHERE `Id` = '$id'";
    $result = mysqli_query($connection, $query);

    if(!$result){
        die("Query Failed: " . mysqli_error($connection));
    }

    // Check if table is empty
    $check = mysqli_query($connection, "SELECT COUNT(*) AS total FROM `students`");
    $row = mysqli_fetch_assoc($check);
    if($row['total'] == 0){
        // Reset AUTO_INCREMENT
        mysqli_query($connection, "ALTER TABLE `students` AUTO_INCREMENT = 1");
    }

    header('location:index.php?delete_msg=You have deleted the record');
}
?>