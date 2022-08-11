<?php
ob_start();
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <title>PHP Blog</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            text-align: center;
            box-sizing: border-box;
        }

        img {
            width: auto;
            max-height: 220px;
        }
    </style>
</head>

<body>
    <main class="container pt-2">
        <nav class="d-flex justify-content-between">
            <a class="text-decoration-none" href="/php-blog">
                <h1 class="text-secondary">PHP Blog</h1>
            </a>
            <div>
                <?php if (isset($_SESSION['uid'])) : ?>
                    <a href="/php-blog/index.php?filter=user">My posts</a>
                    <a href="/php-blog/pages/logout.php">Logout</a>
                <?php else : ?>
                    <a href="/php-blog/pages/login.php">Login</a>
                <?php endif ?>
            </div>
        </nav>