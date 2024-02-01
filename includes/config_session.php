<?php
    //source: https://www.youtube.com/watch?v=Ojk70Ag8Ofs
    ini_set('session.use_only_cookies', 1);
    ini_set('session.use_strict_mode', 1);

    session_set_cookie_params([
        'lifetime' => 1800,
        'domain' => 'localhost',
        'path' => '/',
        'secure' => true,
        'httponly' => true
    ]);

    session_start();

    if (!isset($_SESSION["lastRegeneration"])) {
        session_regenerate_id();
        $_SESSION["lastRegeneration"] = time();
    } else {
        $interval = 60 * 30;
        if (time() - $_SESSION["lastRegeneration"] >= $interval) {
            session_regenerate_id();
            $_SESSION["lastRegeneration"] = time();
        }
    }
?>
