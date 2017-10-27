<?php


//UPDATE service payments
$app->get("/payments", function() use($app) {

    $school = School::find($_SESSION['school_id']);
    $client = Account::find($_SESSION['client_id']);

    return $app['twig']->render('client_payment', array('school_name'=> $school->getName(), 'client' => $new_account));

});
