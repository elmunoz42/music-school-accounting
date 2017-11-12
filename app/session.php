<?php

session_start();
if (empty($_SESSION['school_id'])) {
       $_SESSION['school_id'] = null;
}

if (empty($_SESSION['teacher_id'])) {
       $_SESSION['teacher_id'] = null;
}

if (empty($_SESSION['client_id'])) {
       $_SESSION['client_id'] = null;
}

if (empty($_SESSION['role'])) {
       $_SESSION['role'] = null;
}
