<?php
include_once './includes/db.php';
include_once './includes/header.php';

// Create a blog post
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $user_id = $_SESSION['uid'];
    $image = $_FILES["image"];

    // Converting title into slug- https://stackoverflow.com/a/11330527/11105382
    $slug = strtolower($title); //Lower case everything
    $slug = preg_replace("/[^a-z0-9_\s-]/", "", $slug); //Make alphanumeric (removes all other characters)
    $slug = preg_replace("/[\s-]+/", " ", $slug); //Clean up multiple dashes or whitespaces
    $slug = preg_replace("/[\s_]/", "-", $slug); //Convert whitespaces and underscore to dash

    if (isset($image)) {
        move_uploaded_file(
            $image["tmp_name"],
            __DIR__ . "/images/" . $image["name"]
        );
        $image = $image["name"];
    }

    $query = "INSERT INTO blog (`title`, `slug`, `description`, `image`, `user_id`) VALUES ('$title', '$slug', '$description', '$image', '$user_id')";
    $result = mysqli_query($conn, $query);
    if ($result) {
        header('location: ./index.php?m=Successfully posted');
        exit;
    } else
        header('location: ./index.php?m=Something went wrong');
}

$uid = isset($_SESSION['uid']) ? $_SESSION['uid'] : 0;
// Select all posts or user posts depending on request
$query = isset($_GET["filter"]) ? "SELECT b.*, u.fullname FROM blog AS b LEFT JOIN user as u ON u.id = b.user_id WHERE b.user_id = $uid" : "SELECT b.*, u.fullname FROM blog AS b LEFT JOIN user as u ON u.id = b.user_id";
$result = mysqli_query($conn, $query);
?>

<div class="mt-2">
    <div>
        <!-- Show post form if logged in -->
        <?php if (isset($_SESSION['uid'])) : ?>
            <form class="text-start" action="" method="post" enctype="multipart/form-data">
                <input class="form-control w-50 mt-2 text-start" required placeholder="Title" type="text" name="title">
                <textarea placeholder="Write something..." class="form-control text-start w-50 mt-2" name="description" rows="5"></textarea>
                <label class="mt-2" for="blogImage">Image (optional)</label>
                <input class="form-control w-50 mt-2 text-start" id="blogImage" type="file" name="image" accept="image/*" />
                <input class="btn btn-success mt-2" type="submit" value="Post">
            </form>
        <?php else : ?>
            <a class="btn btn-link d-block text-start" href="./pages/login.php">Login to post</a>
        <?php endif ?>
    </div>
    <h6 class="text-start mt-2 text-primary"><?php if (isset($_GET['m'])) echo ($_GET['m']) ?></h6>
    <!-- All blog posts -->
    <?php while ($row = mysqli_fetch_array($result)) : ?>
        <div class="mt-4">
            <a href="./pages/post.php?id=<?php echo $row['id'] ?>">
                <h4 class="text-start"><?php echo $row['title'] ?></h4>
            </a>
            <h5 class="text-start"><i><?php echo $row['fullname'] ?></i></h5>
            <?php if (!empty($row['image'])) : ?>
                <div class="text-start"><img src="./images/<?php echo $row['image'] ?>" alt="<?php echo $row['title'] ?>""></div>
            <?php endif ?>
            <h6 class=" text-start"><?php echo $row['description'] ?></h6>
                </div>
            <?php endwhile ?>
        </div>

        <?php
        include_once './includes/footer.php';
