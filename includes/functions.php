<?php
/**
 * File: functions.php
 * Author: Tintin Kurtti, tiku2200@student.miun.se
 * Date: 2024-03-13
 * Description: This file contains functions and a class for the website
 */
class PasswordManager
{
    public function __construct() {
    }
    // Print all posts connected to the logged-in user
    public function printPosts() {
        global $conn;
        session_start();
        // Selects all posts from the database that are connected to the logged-in user
        $stmt = $conn->query("SELECT * FROM Login WHERE accID = {$_SESSION['accID']}");
        $num_rows = $stmt->rowCount(); // Count the number of rows
        if ($num_rows == 0) {
            echo "Inga lösenord skapade.";
        } else {
            while ($post = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // Decrypt the passwords
                $decrypted = decrypt($post['password'], $_SESSION['accID']);
                echo "<div class='post'>";
                echo "<div class='post-content'>";
                echo "<p><strong>{$post['site']}</strong>: {$post['uname']}, $decrypted</p>";
                echo "</div>";
                echo "<form class='delete-form' method='post'>";
                echo "<input type='hidden' name='delete_index' value='{$post['id']}'>";
                echo "<input type='submit' value='Radera'>";
                echo "</form>";
                echo "</div>";
            }
        }
    }
    // Create a new post
    public function makeLogin($site, $uname, $password){
        global $conn;
        session_start();
        // Encrypt the password with the logged-in user's ID
        $encrypted = encrypt($password, $_SESSION['accID']);
        // Insert the post into the database
        $stmt = $conn->prepare("INSERT INTO Login (site, uname, password, accID) VALUES (:site, :uname, :password, :accID)");
        $stmt->bindParam(':site', $site);
        $stmt->bindParam(':uname', $uname);
        $stmt->bindParam(':password', $encrypted);
        $stmt->bindParam(':accID', $_SESSION['accID']);
        $stmt->execute();
    }

    // Delete a post
    public function deletePost($id) {
        global $conn;
        session_start();
        $stmt = $conn->prepare("DELETE FROM Login WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }
}

// Function for encrypting a string with a number (XOR)
function encrypt($str, $key) {
    $encrypted_str = '';
    $length = strlen($str);
    for ($i = 0; $i < $length; $i++) {
        // XOR the character with the key
        $encrypted_str .= chr(ord($str[$i]) ^ $key);
    }
    return $encrypted_str;
}

// Function for decrypting a string with a number (XOR)
function decrypt($str, $key) {
    // XOR the string with the key again to decrypt it
    return encrypt($str, $key);
}

// Function for checking if the user is logged in
function check_login()
{
    session_start();
    if (!isset($_SESSION['loggedin'])) {
        header("location:/~tiku2200/dt100g/projekt/includes/login.php"); // Omdirigera till inloggningssidan om användaren inte är inloggad
    }
}

// Function for logging out
function logout()
{
    session_start();
    if (isset($_SESSION['loggedin'])) {
        session_destroy(); // Destroy the session
        echo "Du är nu utloggad.";
    }
    else {
        echo "Du är inte inloggad.";
    }
}

// Function for trying to log in
function try_login($username, $password)
{
    session_start();
    global $conn;
    // Hämta alla användare från databasen
    $stmt = $conn->query("SELECT * FROM Accounts");
    while ($user = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // Check if the username and decrypted password match
        if ($user['user'] == $username && password_verify($password, $user['pass'])){
            $_SESSION['loggedin'] = true;
            $_SESSION['accID'] = $user['id']; // Save the user's ID in the session
            header("location:/~tiku2200/dt100g/projekt/index.php");
        }
    }
    echo "Felaktigt användarnamn eller lösenord.";

}

//Create account
function make_acc($user, $pass)
{
    // Encrypt the password with the password_hash function
    $hash = password_hash($pass, PASSWORD_DEFAULT);

    global $conn;
    // Check if the username is already taken
    $stmt = $conn->query("SELECT * FROM Accounts");
    while ($post = $stmt->fetch(PDO::FETCH_ASSOC)) {
        if ($post['user'] == $user) {
            echo "Användarnamnet är upptaget.";
            return;
        }
    }

    // Insert the new account into the database
    $stmt = $conn->prepare("INSERT INTO Accounts (user, pass) VALUES (:user, :pass)");
    $stmt->bindParam(':user', $user);
    $stmt->bindParam(':pass', $hash);
    $stmt->execute();
    // Log in the new user
    try_login($user, $pass);
}
