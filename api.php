<?php

$conne = new mysqli("localhost", "root", "", "vuejs");

if ($conne->connect_errno) {
    die("Database connect erreor");
}

$response = [
    "error" => false,
];

$action = "read";

if (isset($_GET["action"])) {

    $action = $_GET["action"];
}

if ($action === "read") {
    $users = array();
    $result = $conne->query("SELECT * FROM `users`");
    while ($row = $result->fetch_assoc()) {
        array_push($users, $row);
    }
    $response['users'] = $users;
} elseif ($action === "create") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $username = $_POST["username"];

    $result = $conne->query("INSERT INTO `users`(`name`, `username`, `email`) VALUES ('$name','$username','$email')");

    if ($result) {
        $response["message"] = "Data saved";
    } else {
        $response["error"] = true;
        $response["message"] = "Data save failed";
    }

} elseif ($action === "update") {
    $id = $_POST["id"];
    $name = $_POST["name"];
    $email = $_POST["email"];
    $username = $_POST["username"];

    $result = $conne->query("UPDATE `users` SET `name`='$name',`username`='$username',`email`='$email' WHERE `id` = '$id'");

    if ($result) {
        $response["message"] = "Data updated";
    } else {
        $response["error"] = true;
        $response["message"] = "Data update failed";
    }

} elseif ($action === "delete") {
    $id = $_POST["id"];

    $result = $conne->query("DELETE FROM `users` WHERE `id`= '$id'");

    if ($result) {
        $response["message"] = "Data deleted";
    } else {
        $response["error"] = true;
        $response["message"] = "Data delete failed";
    }

} else {
    die("Invalid action!!!");
}
header('Access-Control-Allow-Origin: *');
echo json_encode($response);
