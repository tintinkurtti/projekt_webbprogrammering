<?php
/**
 * File: config.php
 * Author: Tintin Kurtti, tiku2200@student.miun.se
 * Date: 2024-03-13
 * Description: This file contains the configuration for the website and the database
 */
$site_title = "Min webbplats";
$divider = " | ";

$servername = "studentmysql.miun.se";
$username = "tiku2200";
$password = "*********";
$dbname = "tiku2200";

// Create connection to the database
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
