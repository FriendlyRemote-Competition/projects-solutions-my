<?php

if($_SERVER['REQUEST_METHOD'] === "POST")
{
    $user = $_POST['username'];
    $password = $_POST['password'];

    if(empty($user) || empty($password)){
        echo "<script>alert('Invalid details')</script>";
        header("Location: index.php");
    }

    $hash = md5($password);

    $content = json_decode(file_get_contents("users.json"));
    $content[] = [
        "username" => $user,
        "password" => $hash,
    ];
    file_put_contents("users.json", json_encode($content, JSON_PRETTY_PRINT));

    header("Location: login.php");
}