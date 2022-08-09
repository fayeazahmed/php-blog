<?php
include_once '../includes/db.php';
include_once '../includes/header.php';

if (isset($_SESSION['uid']))
    header('location: ../');

if (isset($_POST['submit'])) {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];

    if ($password !== $password2) {
        header('location: ./register.php?m=Passwords do not match');
        exit;
    }

    $query = "SELECT * FROM user WHERE email = '$email' ";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) !== 0) {
        header('location: ./register.php?m=Email already in use');
        exit;
    }

    $hashedPw = password_hash($password, PASSWORD_DEFAULT);
    $query = "INSERT INTO user (`fullname`, `email`, `password`) VALUES ('$fullname', '$email', '$hashedPw')";
    $result = mysqli_query($conn, $query);
    if ($result) {
        $_SESSION['uid'] = mysqli_insert_id($conn);
        header('location: ../');
    } else
        header('location: ./register.php?m=Something went wrong');
}
?>

<h1 class="text-start">Registration</h1>

<form action="#" method="post">
    <input class="form-control w-25 mt-2 text-start" required placeholder="Full name" type="text" name="fullname">
    <input class="form-control w-25 mt-2 text-start" required placeholder="Email" type="text" name="email">
    <input class="form-control w-25 mt-2 text-start" required placeholder="Password" type="password" name="password">
    <input class="form-control w-25 mt-2 text-start" required placeholder="Password (again)" type="password" name="password2">
    <div class="text-start mt-2">
        <input class="btn btn-primary" type="submit" value="Register" name="submit">
        <a class="btn btn-link" href="./login.php">Login</a>
    </div>
    <h6 class="text-start mt-2 text-danger"><?php if (isset($_GET['m'])) echo ($_GET['m']) ?></h6>
</form>

<?php
include_once '../includes/footer.php';
