<?php

//READ accounts
$app->get("/accounts", function() use ($app) {
    $school = School::find($_SESSION['school_id']);

    return $app['twig']->render('accounts.html.twig', array('role' => $_SESSION['role'], 'school' => $school, 'accounts' => $school->getAccounts()));
})
->before($is_logged_in)
->before($client_only)
->after($save_location_uri);

// CREATE account
$app->post("/accounts", function() use ($app) {

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

    // create new account
    $new_account = new Account($family_name, $parent_one_name, $street_address, $phone_number, $email_address);

    $notes_array = explode("|", $new_account->getNotes());
    $new_account->setParentTwoName($parent_two_name);
    $new_account->setNotes($notes);
    $new_account->setBillingHistory($billing_history);
    $new_account->setOutstandingBalance($outstanding_balance);

    if ($new_account->save()) {
        //add relationship
        if ($school->addAccount($new_account->getId())) {
          // success message
        } else {
          // error message
        }

        if ($new_account->addUser($_SESSION['new_account_id'])) {
          // success message
        } else {
          // error message
        }
    } else {
      // error message
    }

    unset($_SESSION['new_account_id']);
    return  $app->redirect("/accounts");
})
->before($is_logged_in)
->before($owner_only);


//search client
$app->post("/accounts/search", function() use ($app) {
    $search_input = $_POST['search_input'] ? $_POST['search_input'] : '';

    if ($search_input) {
        $accounts = Account::search($search_input);

        if ($accounts) {
            return $app['twig']->render('accounts_search.html.twig', array('role' => $_SESSION['role'], 'accounts' => $accounts));
        } else {
            // no results
            // add error message
        }
    } else {
      // input is empty
      // add error message
    }
    return  $app->redirect("/accounts");
})
->before($is_logged_in)
->before($owner_only);


$app->get("/accounts/search", function() use ($app) {
    // this route is not exist. therefore redirect to accounts
    return  $app->redirect("/accounts");
})
->before($is_logged_in)
->before($owner_only)
->after($save_location_uri);
