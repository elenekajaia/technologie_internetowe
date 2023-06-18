<?php

session_start();

//wylogowanie 
function logout() {

    $_SESSION = array();

//usuniecie sesji
    session_destroy();

    header("Location: index.php");
    exit();
}

logout();
?>