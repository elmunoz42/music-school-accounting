<?php
  function loginOwner($owner) {

      // Renerating the ID protects the admin from session fixation.
      session_regenerate_id();
      $_SESSION['role'] = $owner->getRole();
      $_SESSION['owner_id'] = $owner->getId();
      $_SESSION['last_login'] = time();
      return true;
  }

  function isOwnerLoggedIn() {
    return isset($_SESSION['owner_id']);
  }

  // Call require_login() at the top of any page which needs to
  // require a valid login before granting acccess to the page.
  function isLoggedIn() {
    if (!isOwnerLoggedIn()) {
      return false;
    } else {
      return true;
    }
  }

  function logout() {
    unset($_SESSION['owner_id']);
    unset($_SESSION['last_login']);
    unset($_SESSION['role']);
    session_destroy();
    return true;
  }
