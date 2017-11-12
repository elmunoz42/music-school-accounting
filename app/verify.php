<?php
// if user is not logged in, redirect
$is_logged_in = function ($request, $app) {
  if (!isLoggedIn()) {
      $app['session']->getFlashBag()->add('errors', "You need to login first");
      return $app->redirect("/login");
  }
};

// if user is not owner, redirect to previous page
$owner_only = function ($request, $app) {
  if ($_SESSION['role'] !== 'owner') {
      if ($_SESSION['location_uri']) {
          $app['session']->getFlashBag()->add('errors', "You are not authorized to access this page");
          return $app->redirect($_SESSION['location_uri']);
      } else {
          return $app->redirect('/');
      }
  }
};

// if user is neither owner nor teacher, redirect to previous page
$teacher_only = function ($request, $app) {
  if ($_SESSION['role'] !== 'teacher' && $_SESSION['role'] != 'owner') {
      // add error
      if ($_SESSION['location_uri']) {
          $app['session']->getFlashBag()->add('errors', "You are not authorized to access this page");
          return $app->redirect($_SESSION['location_uri']);
      } else {
          return $app->redirect('/');
      }
  }
};

// if user is neither owner nor client, redirect to previous page
$client_only = function ($request, $app) {
  if ($_SESSION['role'] !== 'client' && $_SESSION['role'] != 'owner') {
      if ($_SESSION['location_uri']) {

          $app['session']->getFlashBag()->add('errors', "You are not authorized to access this page");
          return $app->redirect($_SESSION['location_uri']);

      } else {

          return $app->redirect('/');
      }

  }
};
