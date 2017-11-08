<?php

$app->get("/create_owner", function() use ($app) {
    return $app['twig']->render('create_owner.html.twig', array('role' => $_SESSION['role']));
})
->after($save_location_uri);

$app->get("/create_user", function() use ($app) {
    return $app['twig']->render('create_user.html.twig', array('role' => $_SESSION['role']));
})
->before($isLoggedIn)
->before($owner_only)
->after($save_location_uri);

$app->get("/create_account_role/{account_role}", function($account_role) use ($app) {
    return $app['twig']->render('create_account_role.html.twig', array('role' => $_SESSION['role'], 'account_role' => $account_role));
})
->before($isLoggedIn)
->before($owner_only)
->after($save_location_uri);



//CREATE owner  //TODO eventually this function and related page should be removed or add more security
$app->post("/create_owner", function() use ($app) {

    $first_name = $_POST['first_name'] ? $_POST['first_name'] : '';
    $last_name = $_POST['last_name'] ? $_POST['last_name'] : '';
    $email_address = $_POST['email_address'] ? $_POST['email_address'] : '';
    $password = $_POST['password'] ? $_POST['password'] : '';
    $confirm_password = $_POST['cofirm_password'] ? $_POST['confirm_password'] : '';

    if ($password == $confirm_password) {
        $role = 'owner';

        $owner = Owner::findOwnerByEmailAddress($email_address);

        if (!$owner) {
            // if existing account does not exist, create new account
            $new_owner = new Owner($first_name, $last_name, $email_address, $role);
            var_dump($new_owner);
            exit;
            if( $new_owner->createAccount($password)) {

                loginOwner($new_owner);
                $app['session']->getFlashBag()->add('success', 'Account successfully created');
                return $app->redirect("/create_school");

            } else {
                // error
                $app['session']->getFlashBag()->add('errors', 'Unexpected error happened');
            }
        } else {
            $app['session']->getFlashBag()->add('errors', 'Account already exist');
        }
    } else {
        //error
        $app['session']->getFlashBag()->add('errors', 'Password does not match');
    }
    return $app->redirect('/create_owner');

});

  $app->post("/create_user", function() use ($app) {

      $first_name = $_POST['first_name'] ? $_POST['first_name'] : '';
      $last_name = $_POST['last_name'] ? $_POST['last_name'] : '';
      $email_address = $_POST['email_address'] ? $_POST['email_address'] : '';
      $password = $_POST['password'] ? $_POST['password'] : '';
      $confirm_password = $_POST['confirm_password'] ? $_POST['confirm_password'] : '';
      $role = $_POST['role'] ? $_POST['role'] : '';
      $school_id = $_SESSION['school_id'];

      if ($password == $confirm_password) {

          $user = Owner::findOwnerByEmailAddress($email_address);

          if (!$user) {
              // if account not exist, create new account
              $new_user = new Owner($first_name, $last_name, $email_address, $role);



              if ($new_user->createAccount($password)) {

                  $school = School::find($school_id);

                  if ($school->addOwner($new_user->getId())) {

                      $_SESSION['new_account_id'] = $new_user->getId();
                      return $app->redirect("/create_account_role/" . $role);

                  } else {
                      $app['session']->getFlashBag()->add('errors', 'Unexpected error happened');
                  }
              } else {
                  $app['session']->getFlashBag()->add('errors', 'Unexpected error happened');
              }
          } else {
              $app['session']->getFlashBag()->add('errors', 'Account already exist');
          }
      } else {
          //error
          $app['session']->getFlashBag()->add('errors', 'Password does not match');
      }
      return $app->redirect('/create_user');
  })
  ->before($is_logged_in)
  ->before($owner_only);
