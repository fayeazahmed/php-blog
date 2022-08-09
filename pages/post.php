<?php
include_once '../includes/header.php';
include_once '../includes/db.php';

$id = $_GET['id'];

// Update if form is submitted
if (isset($_POST['update'])) {
    $user_id = $_SESSION['uid'];
    if (!isset($user_id))
        exit;
    $title = $_POST['title'];
    $description = $_POST['description'];

    $query = "UPDATE blog SET `title` = '$title', `description` = '$description' WHERE `id` = $id";
    $result = mysqli_query($conn, $query);

    if ($result)
        header('location: ./post.php?m=Post updated&id=' . $id);
    else
        header('location: ./post.php?m=Something went wrong&id=' . $id);
    exit;
}

// Delete if delete button is clicked 
if (isset($_POST['delete'])) {
    $query = "DELETE FROM `blog` WHERE `id` = $id";
    $result = mysqli_query($conn, $query);
    if ($result)
        header('location: ../index.php?m=Post deleted');
    else
        header('location: ../index.php?m=Something went wrong');
    exit;
}

// Post a comment if comment form is submitted
if (isset($_POST['comment'])) {
    $user_id = $_SESSION['uid'];
    if (!isset($user_id))
        exit;
    $body = $_POST['body'];
    $query = "INSERT INTO `comment`(`body`, `user_id`, `blog_id`) VALUES ('$body', '$user_id', '$id')";
    mysqli_query($conn, $query);
}

$query = "SELECT b.*, u.fullname FROM blog AS b LEFT JOIN user as u ON u.id = b.user_id WHERE b.id = '$id'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_array($result);
$title = $row['title'];
$description = $row['description'];
$fullname = $row['fullname'];
?>

<!-- Disable form controls if user is not post creator -->
<form class="text-start" action="#" method="post">
    <input <?php echo isset($_SESSION['uid']) && $_SESSION['uid'] == $row['user_id'] ? "" : "disabled" ?> class="form-control w-50 mt-2 text-start text-strong" value="<?php echo $fullname ?>" required disabled type="text">
    <input <?php echo isset($_SESSION['uid']) && $_SESSION['uid'] == $row['user_id'] ? "" : "disabled" ?> class="form-control w-50 mt-2 text-start" value="<?php echo $title ?>" required placeholder="Blog title" type="text" name="title">
    <textarea <?php echo isset($_SESSION['uid']) && $_SESSION['uid'] == $row['user_id'] ? "" : "disabled" ?> class="form-control w-50 mt-2 text-start" required placeholder="Blog description" rows="5" type="text" name="description"><?php echo $description ?></textarea>
    <?php if (isset($_SESSION['uid']) && $_SESSION['uid'] == $row['user_id']) : ?>
        <div class="text-start mt-2">
            <input class="btn btn-success" type="submit" name="update" value="Update">
            <input class="btn btn-danger" type="submit" name="delete" value="Delete">
        </div>
    <?php endif ?>
</form>
<h6 class="text-start mt-2 text-primary"><?php if (isset($_GET['m'])) echo ($_GET['m']) ?></h6>

<?php
$query = "SELECT c.*, u.fullname FROM comment AS c LEFT JOIN user as u ON u.id = c.user_id WHERE c.blog_id = '$id'";
$result = mysqli_query($conn, $query);
?>
<h5 class="mt-5 text-start">Comments</h5>
<?php while ($row = mysqli_fetch_array($result)) : ?>
    <div class="mb-3">
        <p class="text-start mb-0"><i><?php echo $row['fullname'] ?></i></p>
        <h6 class="text-start"><?php echo $row['body'] ?></h6>
    </div>
<?php endwhile ?>

<!-- Show comment form if logged in -->
<?php if (isset($_SESSION['uid'])) : ?>
    <form class="text-start" action="" method="post">
        <input class="form-control w-25 mt-2 text-start" required placeholder="Comment..." type="text" name="body">
        <input class="btn btn-success btn-sm mt-2" type="submit" name="comment" value="Post">
    </form>
<?php else : ?>
    <a class="btn btn-link d-block text-start" href="./login.php">Login to comment</a>
<?php endif ?>

<?php
include_once '../includes/footer.php';
