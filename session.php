<?php
session_start();

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function getUserName() {
    return isset($_SESSION['first_name']) ? $_SESSION['first_name'] : '';
}

