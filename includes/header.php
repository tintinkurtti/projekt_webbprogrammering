<!--
File: header.php
Author: Tintin Kurtti, tiku2200@student.miun.se
Date: 2024-03-13
Description: The header of the website with the main menu
-->
<?php
include ("config.php");
?>
<!DOCTYPE html>
<html lang="sv">
<head>
    <title><?= $site_title . $divider . $page_title; ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/~tiku2200/dt100g/projekt/css/style.css" type="text/css">
</head>
<body>
<section id="container">
    <header id="mainheader">
        <h1>Tintins lösenordshanterare</h1>
        <?php include("mainmenu.php"); ?>
    </header>
</section>


