<?php
session_start();
unset($_SESSION['logged_ID']);

header('Location: admin.php');