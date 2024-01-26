<?php

declare(strict_types=1);

function checkRegisterErrors() {
    if (isset($_SESSION['errorsRegister'])) {
        $errors = $_SESSION['errorsRegister'];

        echo "<br>";

        foreach ($errors as $error) {
            echo '<p class="form-error">'.$error.'</p>';
        }

        unset($_SESSION['errorsRegister']);
    }
}