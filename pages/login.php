<?php
include_once '../includes/header.php';
include_once '../includes/db.php';

if (isset($_SESSION['uid'])) {
    header('location: ../');
    exit;
}

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $query = "SELECT * FROM user WHERE email = '$email' ";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) === 0) {
        header('location: ./login.php?m=Invalid credentials');
        exit;
    }

    $row = mysqli_fetch_array($result);
    if (password_verify($password, $row['password'])) {
        $_SESSION['uid'] = $row['id'];
        header('location: ../');
        exit;
    } else
        header('location: ./login.php?m=Invalid credentials');
}

?>
<h1 class="text-start">Login</h1>

<form action="#" method="post">
    <input class="form-control w-25 mt-2 text-start" required placeholder="Email" type="text" name="email">
    <input class="form-control w-25 mt-2 text-start" required placeholder="Password" type="password" name="password">
    <div class="text-start mt-2">
        <input class="btn btn-primary" type="submit" value="Login" name="submit">
        <a class="btn btn-link" href="./register.php">Register</a>
    </div>
    <h6 class="text-start mt-2 text-danger"><?php if (isset($_GET['m'])) echo ($_GET['m']) ?></h6>
</form>


<?php
include_once '../includes/footer.php';
