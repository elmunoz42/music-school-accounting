<?php

//READ clients
$app->get("/clients", function() use ($app) {
    $school = School::find($_SESSION['school_id']);

    return $app['twig']->render('clients.html.twig', array('role' => $_SESSION['role'], 'school' => $school, 'clients' => $school->getClients()));
})
->before($is_logged_in)
->before($client_only)
->after($save_location_uri);

// CREATE client
$app->post("/clients", function() use ($app) {

    $school = School::find($_SESSION['school_id']);

    // get user input from POST
    $family_name = $_POST['family_name'] ? $_POST['family_name'] : '';
    $parent_one_name = $_POST['parent_one_name'] ? $_POST['parent_one_name'] : '';
    $street_address = $_POST['street_address'] ? $_POST['street_address'] : '';
    $phone_number = $_POST['phone_number'] ? $_POST['phone_number'] : '';
    $email_address = $_POST['email_address'] ? $_POST['email_address'] : '';
    $parent_two_name = $_POST['parent_two_name'] ? $_POST['parent_two_name'] : '';
    $notes = $_POST['notes'] ? $_POST['notes'] : '';
    $billing_history = $_POST['billing_history'] ? $_POST['billing_history'] : '';
    $outstanding_balance = $_POST['outstanding_balance'] ? intval($_POST['outstanding_balance']) : '';

    // create new client
    $new_client = new Client($family_name, $parent_one_name, $street_address, $phone_number, $email_address);

    $notes_array = explode("|", $new_client->getNotes());
    $new_client->setParentTwoName($parent_two_name);
    $new_client->setNotes($notes);
    $new_client->setBillingHistory($billing_history);
    $new_client->setOutstandingBalance($outstanding_balance);

    if ($new_client->save()) {
        //add relationship
        if ($school->addClient($new_client->getId())) {
            // success message
            $app['session']->getFlashBag()->add('success', "Successfully created Client");
        } else {
            // error message
            $app['session']->getFlashBag()->add('errors', "INGJSJDIO Unexpected errors happened");
        }

        if ($new_client->addUser($_SESSION['new_account_id'])) {
            $app['session']->getFlashBag()->add('success', "Successfully added");

        } else {
            // error message
            $app['session']->getFlashBag()->add('errors', "Unexpected errors happened");
        }
    } else {
        // error message
        $app['session']->getFlashBag()->add('errors', "Unexpected errors happened");
    }

    unset($_SESSION['new_account_id']);
    return  $app->redirect("/clients");
})
->before($is_logged_in)
->before($owner_only);


//search client
$app->post("/clients/search", function() use ($app) {
    $search_input = $_POST['search_input'] ? $_POST['search_input'] : '';

    if ($search_input) {
        $clients = Client::search($search_input);

        if ($clients) {
            return $app['twig']->render('clients_search.html.twig', array('role' => $_SESSION['role'], 'clients' => $clients));
        } else {
            // no results
            $app['session']->getFlashBag()->add('errors', "Unexpected errors happened");
        }
    } else {
      // input is empty
      // add error message
      $app['session']->getFlashBag()->add('errors', "Input cannot be empty");
    }
    return  $app->redirect("/clients");
})
->before($is_logged_in)
->before($owner_only);


$app->get("/clients/search", function() use ($app) {
    // this route is not exist. therefore redirect to clients
    return  $app->redirect("/clients");
})
->before($is_logged_in)
->before($owner_only)
->after($save_location_uri);
