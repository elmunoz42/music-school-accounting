<?php

    $save_location_uri = function ($request, $app) {
        $_SESSION['location_uri'] =  $_SERVER['REQUEST_URI'];
    };
