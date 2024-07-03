<!--
File: index.php
Author: Tintin Kurtti, tiku2200@student.miun.se
Date: 2024-03-13
Description: This is the main page of the password manager. It includes the header, the footer and the functions for the password manager. It also checks if the user is logged in. This page is used to create a new account and manage passwords
-->
<?php
$page_title = "Lösenordshanterare";
include("includes/header.php");
include("includes/functions.php");
check_login();
//Create a new PasswordManager object
$manager = new PasswordManager();
//If delete_index is set, delete the post with that index
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_index'])) {
   $manager->deletePost($_POST['delete_index']);
}
//If submit is pressed, make a login
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["site"]) && isset($_POST["uname"]) && isset($_POST["password"])) {
    $site = $_POST["site"];
    $uname = $_POST["uname"];
    $password = $_POST["password"];
    $manager->makeLogin($site, $uname, $password);
}

?>
<h3>Dina lösenord:</h3>
<?php
$manager->printPosts();
?>
<h4>Skapa lösenord:</h4>
<form method="post">
    <label for="site"><strong>Hemsida/Applikation:</strong></label><br>
    <input type="text" name="site" id="site" required><br>
    <label for="uname"><strong>Användarnamn:</strong></label><br>
    <input type="text" name="uname" id="uname" required><br>
    <label for="password"><strong>Lösenord:</strong></label><br>
    <input type="text" name="password" id="password" required><br>
    <input type="submit" value="Lägg till">
</form>
<?php
include("includes/footer.php");
?>