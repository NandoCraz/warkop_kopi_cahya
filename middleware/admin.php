<?php

if ($_SESSION['login']['role'] === "user") {
    header("location: dashboard.php");
    exit;
}
