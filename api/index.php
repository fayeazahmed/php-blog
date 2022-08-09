<?php
include_once '../includes/db.php';

// GET
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $query = "SELECT * FROM blog";
    $result = mysqli_query($conn, $query);
    $response = array();
    while ($row = mysqli_fetch_assoc($result))
        $response[] = $row;
    echo json_encode($response);
    exit;
}


/* POST {
    title : some title,
    description : some desc,
    user_id : user who is posting
} */
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"));
    $title = $data->title;
    $description = $data->description;
    $user_id = $data->user_id;
    // Converting title into slug- https://stackoverflow.com/a/11330527/11105382
    $slug = strtolower($title); //Lower case everything
    $slug = preg_replace("/[^a-z0-9_\s-]/", "", $slug); //Make alphanumeric (removes all other characters)
    $slug = preg_replace("/[\s-]+/", " ", $slug); //Clean up multiple dashes or whitespaces
    $slug = preg_replace("/[\s_]/", "-", $slug); //Convert whitespaces and underscore to dash

    $query = "INSERT INTO blog (`title`, `slug`, `description`, `user_id`) VALUES ('$title', '$slug', '$description', '$user_id')";
    if (mysqli_query($conn, $query))
        echo json_encode("Successfully posted");
    else
        echo json_encode("Something went wrong");
    exit;
}

/* PATCH {
    title : some title,
    description : some desc,
    post_id : post that is being updated
} */
if ($_SERVER["REQUEST_METHOD"] == "PATCH") {
    $data = json_decode(file_get_contents("php://input"));
    $title = $data->title;
    $description = $data->description;
    $post_id = $data->post_id;

    $query = "UPDATE blog SET `title` = '$title', `description` = '$description' WHERE `id` = $post_id";
    if (mysqli_query($conn, $query))
        echo json_encode("Successfully updated");
    else
        echo json_encode("Something went wrong");
    exit;
}

/* DELETE {
    post_id : post that is being deleted
} */
if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
    $data = json_decode(file_get_contents("php://input"));
    $id = $data->post_id;
    $query = "DELETE FROM `blog` WHERE `id` = $id";

    if (mysqli_query($conn, $query))
        echo json_encode("Successfully deleted");
    else
        echo json_encode("Something went wrong");
    exit;
}
