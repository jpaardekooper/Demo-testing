<?php
function getPathToRoot() {
    return str_repeat("../",
        substr_count(str_replace("\\", "/", getcwd()), "/")
        - substr_count(str_replace("\\", "/", __DIR__), "/") + 1);
}

function getAssetsDirectory() {
    return getPathToRoot() . "assets/";
}

/**
 * Checks a role of a user
 * @param type String: users role
 */
function checkRole($role) {
    if (!isset($_SESSION['user'])) {
        header("Location: " . getPathToRoot() . "login.php");
        exit();
    }
    if (!hasAtLeastRole($role)) {
        header('HTTP/1.0 403 Forbidden');
        exit();
    }
}

function hasAtLeastRole($role) {
    $userRole = getUserRole();
    $checked = false;
    switch ($role) {
        case "user":
            $checked = true;
            break;
        case "admin":
            $checked = $userRole == "admin";
            break;
        default:
            trigger_error("Invalid role specified: " . $role, E_USER_WARNING);
    }
    return $checked;
}

function redirect($location) {
    echo "Redirecting you to: [WEB-ROOT]/" . $location . "...\n";
    header("Location: " . getPathToRoot() . $location);
    exit();
}


function isLoggedIn() {
    return isset($_SESSION['id']);
}

function requireLoggedIn() {
    if (!isLoggedIn()) {
        trigger_error("User not logged in", E_USER_WARNING);
    }
}

function getUserId() {
    requireLoggedIn();
    return (int) $_SESSION['id']['user_id'];
}

function getUserName() {
    requireLoggedIn();
    return $_SESSION['id']['username'];
}

function getUserRole() {
    requireLoggedIn();
    return $_SESSION['id']['role'];
}