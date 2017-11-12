<?php


//UPDATE service payments
$app->get("/payments", function() use($app) {

    $school = School::find($_SESSION['school_id']);
    $client = Client::find($_SESSION['client_id']);

    return $app['twig']->render('client_payment', array('role' => $_SESSION['role'], 'school_name'=> $school->getName(), 'client' => $new_client));

})
->before($is_logged_in)
->before($owner_only)
->after($save_location_uri);
