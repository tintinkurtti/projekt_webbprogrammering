<!--
File: create_account.php
Author: Tintin Kurtti, tiku2200@student.miun.se
Date: 2024-03-13
Description: This page is used to create a new account
-->
<?php
$page_title = "Skapa konto";
include("header.php");
include("functions.php");

//If submit is pressed, try to create an account
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["new_username"]) && isset($_POST["new_password"])) {
    $user = $_POST["new_username"];
    $pass = $_POST["new_password"];
    make_acc($user, $pass);
}
?>

<h2>Skapa konto</h2>
<div class="login-container">
    <form class="login-form" method="post">
        <label for="new_username"><strong>Användarnamn:</strong></label><br>
        <input type="text" name="new_username" id="new_username" required><br>
        <label for="new_password"><strong>Lösenord:</strong></label><br>
        <input type="password" name="new_password" id="new_password" required><br>
        <input type="submit" value="Skapa konto">
    </form>
</div>
