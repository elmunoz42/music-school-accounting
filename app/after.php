<?php

    // This stores previous location url to Session.
    // so that if error happened, user can redirect to previous page easily
    $save_location_uri = function ($request, $app) {
        $_SESSION['location_uri'] =  $_SERVER['REQUEST_URI'];
    };
