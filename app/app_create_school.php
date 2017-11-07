<?php

$app->get("/create_school", function() use ($app) {

    return $app['twig']->render('create_school.html.twig', array('role' => $_SESSION['role']));
})
->before($is_logged_in)
->before($owner_only)
->after($save_location_uri);

$app->post("/create_school", function() use ($app) {
        $owner_id = $_SESSION['user_id'];
        $school_name = $_POST['school_name'];
        $manager_name = $_POST['manager_name'];
        $phone_number = $_POST['phone_number'];
        $email = $_POST['email'];
        $business_address = $_POST['business_address'];
        $city = $_POST['city'];
        $state = $_POST['state'];
        $country = $_POST['country'];
        $zip = $_POST['zip'];
        $type = $_POST['type'];

        $new_school = new School($school_name, $manager_name, $phone_number, $email, $business_address, $city, $state, $country, $zip, $type);

        if($new_school->save()) {
            if($new_school->addOwner($owner_id)) {
                $_SESSION['school_id'] = $new_school->getId();
                return $app->redirect("/main");
            };
        }
})
->before($is_logged_in)
->before($owner_only)
->after($save_location_uri);
