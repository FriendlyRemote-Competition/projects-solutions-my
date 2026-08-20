<?php

if($_SERVER['REQUEST_METHOD'] === "POST")
{
    $user = $_POST['username'];
    $password = $_POST['password'];

    if(empty($user) || empty($password)){
        echo "<script>alert('Empty details')</script>";
        header("Location: login.php");
    }

    $hash = md5($password);
    $content = json_decode(file_get_contents("users.json"));

    foreach($content as $c){
        if($c->username === $user){
            if($c->password === $hash){
                echo "<script>alert('Login success'); window.location.href = 'dashboard.php'</script>";
            }
        }
    }

    echo "<script>alert('Login failed: ".$hash."'); window.location.href = 'login.php'</script>";
}