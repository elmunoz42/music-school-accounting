<?php

$app->get("/create_owner", function() use ($app) {
    return $app['twig']->render('create_owner.html.twig');
})
->after($save_location_uri);

$app->get("/create_user", function() use ($app) {
    return $app['twig']->render('create_user.html.twig');
})
->before($isLoggedIn)
->before($owner_only)
->after($save_location_uri);

$app->get("/create_account_role/{account_role}", function($account_role) use ($app) {
    return $app['twig']->render('create_account_role.html.twig', array('account_role' => $account_role));
})
->before($isLoggedIn)
->before($owner_only)
->after($save_location_uri);



//CREATE owner  //TODO eventually this function and related page should be removed or add more security
$app->post("/create_owner", function() use ($app) {
    // TODO VERIFY
    if ( !empty($_POST['first_name']) && !empty($_POST['last_name']) && !empty($_POST['email_address']) && !empty($_POST['password']) && !empty($_POST['confirm_password']) ) {

        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email_address = $_POST['email_address'];
        $password = $_POST['password'];
        $role = 'owner';

        $errors = [];

        $owner = Owner::findOwnerByEmailAddress($email_address);

        if (!$owner) {
            $new_owner = new Owner($first_name, $last_name, $email_address, $role);

            if( $new_owner->createAccount($password)) {
                loginOwner($new_owner);

                return $app->redirect("/create_school");

            } else {
                // error
                return $app->redirect("/create_owner");
            }
        } else {
            $errors[] = "Account already exist";
            return $app['twig']->render(
                'create_owner.html.twig',
                array(
                    'errors' => $errors
                )
            );
        }
    }
});

  $app->post("/create_user", function() use ($app) {
      // TODO VERIFY
      if ( !empty($_POST['first_name']) && !empty($_POST['last_name']) && !empty($_POST['email_address']) && !empty($_POST['password']) && !empty($_POST['confirm_password']) ) {

          $first_name = $_POST['first_name'];
          $last_name = $_POST['last_name'];
          $email_address = $_POST['email_address'];
          $password = $_POST['password'];
          $role = $_POST['role'];


          $school_id = $_SESSION['school_id'];

          $errors = [];

          $user = Owner::findOwnerByEmailAddress($email_address);

          if (!$user) {
              $new_user = new Owner($first_name, $last_name, $email_address, $role);


              if ( $new_user->createAccount($password)) {

                  $school = School::find($school_id);

                  // create owners_schools relationship
                  if ($school->addOwner($new_user->getId())) {

                      $_SESSION['new_account_id'] = $new_user->getId();

                      return $app->redirect("/create_account_role/" . $role);

                  } else {
                      //error
                      return $app->redirect("/create_user");
                  }
              } else {
                  // error
                  return $app->redirect("/create_user");
              }
          } else {
              $errors[] = "Account already exist";
              return $app['twig']->render(
                  'create_owner.html.twig',
                  array(
                      'errors' => $errors
                  )
              );
          }
      }
  })
  ->before($is_logged_in)
  ->before($owner_only);


  // $app->post('/contact', function() use ($app) {
  // 	$request = $app['request'];
  //
  // 	$message = \Swift_Message::newInstance()
  // 		->setSubject('Llama Feedback')
  // 		->setFrom(array("kojinakagawa0627@gmail.com" => 'Koji'))
  // 		->setTo(array('lightupthesky0627@gmail.com'))
  // 		->setBody('Hello');
  //
  // 	$app['mailer']->send($message);
  //
  // 	return $app['twig']->render('contact.html.twig', array('sent' => true));
  // });
