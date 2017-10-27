<?php

//READ accounts
$app->get("/owner_accounts", function() use ($app) {
    $school = School::find($_SESSION['school_id']);

    return $app['twig']->render('owner_accounts.html.twig', array('school' => $school, 'accounts' => $school->getAccounts()));
})->before($is_logged_in);

// CREATE account
$app->post("/owner_accounts", function() use ($app) {
    $school = School::find($_SESSION['school_id']);

    $family_name = $_POST['family_name'];
    $parent_one_name = $_POST['parent_one_name'];
    $street_address = $_POST['street_address'];
    $phone_number = $_POST['phone_number'];
    $email_address = $_POST['email_address'];
    $new_account = new Account($family_name, $parent_one_name, $street_address, $phone_number, $email_address);
    $parent_two_name = $_POST['parent_two_name'];
    $notes = $_POST['notes'];
    $notes_array = explode("|", $new_account->getNotes());
    $billing_history = $_POST['billing_history'];
    $outstanding_balance = intval($_POST['outstanding_balance']);
    $new_account->setParentTwoName($parent_two_name);
    $new_account->setNotes($notes);
    $new_account->setBillingHistory($billing_history);
    $new_account->setOutstandingBalance($outstanding_balance);
    $new_account->save();
    $school->addAccount($new_account->getId());

    return $app['twig']->render('owner_accounts.html.twig', array('school' => $school, 'accounts' => $school->getAccounts(), 'notes_array'=>$notes_array));
})->before($is_logged_in);


//search client
$app->post("/owner_accounts/search", function() use ($app) {
    $search_input = $_POST['search_input'] ? $_POST['search_input'] : '';

    if ($search_input) {
        $accounts = Account::search($search_input);

        if ($accounts) {
            return $app['twig']->render('owner_accounts_search.html.twig', array('accounts' => $accounts));
        } else {
            // no results
            // add error message
        }
    } else {
      // input is empty
      // add error message
    }
    return  $app->redirect("/owner_accounts");
})->before($is_logged_in);
