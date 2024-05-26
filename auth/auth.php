<?php
include ('../admin/con.php');
function login($con, $email, $password){
    $q = "SELECT * FROM users WHERE email = ?";
    $stmt = mysqli_prepare($con, $q);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['email'] = $row['email'];
            header("Location: ../admin/dashboard.php");
            exit();
        } else echo "Invalid password.";
    } else echo "No user found with that username.";
}

function register($con, $name, $email, $password){
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $q = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($con, $q);
    mysqli_stmt_bind_param($stmt, "sss", $name, $email, $hash);
    if (mysqli_stmt_execute($stmt)) {
        header("Location: login.php");
        exit();
    } else echo "Error: " . $q . "<br>" . mysqli_error($con);
}