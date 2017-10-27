<?php

$app->get("/create_owner", function() use ($app) {
    return $app['twig']->render('create_owner.html.twig');
});


//CREATE owner
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
            $new_owner->createAccount($password);

            if ($new_owner->getId()) {
                loginOwner($new_owner);
                return $app->redirect("/create_school");
            } else {
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
