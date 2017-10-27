<?php
// if user is not logged in, redirect
$is_logged_in = function ($request, $app) {
  if (!isLoggedIn()) {
      return $app->redirect("/owner_login");
  }
};

// if user is not owner, redirect
$owner_only = function ($request, $app) {
  if ($_SESSION['role'] !== 'owner') {
      // add error
      return $app->redirect("/owner_main");
  }
};

// if user is neither owner nor teacher, redirect
$teacher_only = function ($request, $app) {
  if ($_SESSION['role'] !== 'teacher' && $_SESSION['role'] != 'owner') {
      // add error
      return $app->redirect("/owner_main");
  }
};

// if user is neither owner nor client, redirect
$client_only = function ($request, $app) {
  if ($_SESSION['role'] !== 'client' && $_SESSION['role'] != 'owner') {
      // add error
      return $app->redirect("/owner_main");
  }
};
