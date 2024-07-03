<!--
File: login.php
Author: Tintin Kurtti, tiku2200@student.miun.se
Date: 2024-03-13
Description: This page is used to log in to the website and access the password manager
-->
<?php
$page_title = "Logga in";
include("header.php");
include("functions.php");

//If submit is pressed, try to login
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login_username"]) && isset($_POST["login_password"])) {
    $username = $_POST["login_username"];
    $password = $_POST["login_password"];
    try_login($username, $password);
}
?>

<h2>Logga in</h2>
<div class="login-container">
    <form class="login-form" method="post" >
        <label for="login_username"><strong>Användarnamn:</strong></label><br>
        <input type="text" name="login_username" id="login_username" required><br>
        <label for="login_password"><strong>Lösenord:</strong></label><br>
        <input type="password" name="login_password" id="login_password" required><br>
        <input type="submit" value="Logga in">
    </form>
</div>

