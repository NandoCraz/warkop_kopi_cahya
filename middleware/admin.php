<?php

if ($_SESSION['login']['role'] === "user") {
    header("location: ../index.php");
    exit;
}
