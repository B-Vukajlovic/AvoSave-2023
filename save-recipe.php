<?php

if ( $_SERVER[ 'REQUEST_METHOD' ] === 'POST'){

    //sanatize
    $savedStatus = $_POST[ 'savedStatus' ];

    if ($savedStatus){
        echo "<img src='/pictures/saved.png' class='saveButton' alt='saved!' title='Remove from saved recipes.'>"; //locations
    } else {
        echo "<img src='/pictures/unsaved.png' class='saveButton' alt='&lt;3' title='Add to saved recipes.'>";
    }
}
