<?php

// only the admin account can open the admin pages
if (!isset($_SESSION['userID']) || empty($_SESSION['is_admin'])) {
    header("Location: LoginForm.html");
    exit();
}

?>
