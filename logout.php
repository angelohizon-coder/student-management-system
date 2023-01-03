<?php

    session_start();
    unset($SESSION);
    unset($SESSION['UserLogin']);
    unset($SESSION['Access']);

    echo header('Location: login.php')

?>