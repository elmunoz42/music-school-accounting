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




//UPDATE account
$app->post("/owner_account/{account_id}/update", function($account_id) use ($app) {
    $account = Account::find($account_id);

    $family_name = $_POST['family_name'] ? $_POST['family_name'] : '';
    $parent_one_name = $_POST['parent_one_name'] ? $_POST['parent_one_name'] : '';
    $parent_two_name = $_POST['parent_two_name'] ? $_POST['parent_two_name'] : '';
    $street_address = $_POST['street_address'] ? $_POST['street_address'] : '';
    $phone_number = $_POST['phone_number'] ? $_POST['phone_number'] : '';
    $email_address = $_POST['email_address'] ? $_POST['email_address'] : '';

    if ($account->updateFamilyName($family_name) && $account->updateParentOneName($parent_one_name) && $account->updateParentTwoName($parent_two_name) && $account->updateSteetAddress($street_address) && $account->updatePhoneNumber($phone_number) && $account->updateEmailAddress($email_address)) {
        // add success message
        return $app->redirect("/owner_accounts");
    } else {
        // add error message
        return $app->redirect("/owner_accounts");
    }
})->before($is_logged_in);



//DELETE account
$app->delete("/owner_account/{account_id}/delete", function($account_id) use ($app) {
    $school = School::find($_SESSION['school_id']);
    $account = Account::find($account_id);
    $students = $account->getStudents();

    if ($account->deleteStudents($students)) {

        if ($account->delete()) {
            // add success message
            return $app->redirect("/owner_accounts");
        } else {
            // add error message
            return $app->redirect("/owner_accounts");
        }
    } else {
        // add error message
        return $app->redirect("/owner_accounts");
    }
})->before($is_logged_in);


// JOIN add student to account
$app->post('/owner_add_student_to_account', function() use($app) {
    $account_id = $_POST['account_id'] ? $_POST['account_id'] : '';
    $student_name = $_POST['student_name'] ? $_POST['student_name'] : '';

    if ($account_id && $student_name) {
        $selected_account = Account::find($account_id);
        $school = School::find($_SESSION['school_id']);

        if ($selected_account && $school) {
            $student = new Student($student_name);
            $student->save();

            $student_id = $student->getId();
            $school->addStudent($student_id);

            $selected_account->addStudent($student_id);

            return $app->redirect("/owner_accounts/" . $account_id);
        } else {
          // error message
          return $app->redirect("/owner_accounts/" . $account_id);
        }
    } else {
        // error message
        return $app->redirect("/owner_accounts/" . $account_id);
    }
})->before($is_logged_in);
