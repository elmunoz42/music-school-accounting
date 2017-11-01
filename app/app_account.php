<?php

// READ account
$app->get('/owner_account/{account_id}', function($account_id) use ($app) {
    $school = School::find($_SESSION['school_id']);
    $account = Account::find($account_id);

    if ($account) {
        $students = $account->getStudents();
        $teachers = $account->getTeachers();
        $courses = $account->getCourses();
        $lessons = $account->getLessons();
        $notes_array = explode("|", $account->getNotes());
        $last_month = intval(date('m',strtotime('last month')));
        $last_months_year = intval(date('Y',strtotime('last month')));

        return $app['twig']->render('owner_account.html.twig', array(
            'school'=>$school,
            'account'=>$account,
            'accounts'=>$school->getAccounts(),
            'students'=>$students, 'teachers'=>$teachers,
            'courses'=>$courses,
            'notes_array'=>$notes_array,
            'services'=>$account->getServices(),
            'lessons'=>$lessons,
            'last_month'=>$last_month,
            'last_months_year'=>$last_months_year
        ));
    } else {
        // account is not found
        return $app->redirect("/owner_accounts");
    }
})
->before($is_logged_in)
->before($client_only)
->after($save_location_uri);



//UPDATE account notes
$app->patch("/owner_account/{account_id}/add_note", function($account_id) use ($app) {
    $selected_account = Account::find($account_id);

    $new_notes = $_POST['new_notes'] ? $_POST['new_notes'] : '';

    if($new_notes) {
        $updated_notes =  date('l jS \of F Y ') . "---->"  . $new_notes  . "|" . $selected_account->getNotes();
        $selected_account->updateNotes($updated_notes);
        // add success message
    } else {
      // add error
    }
    return $app->redirect("/owner_account/" . $account_id);
})
->before($is_logged_in)
->before($client_only);


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
})
->before($is_logged_in)
->before($client_only);



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
})
->before($is_logged_in)
->before($owner_only);


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

            return $app->redirect("/owner_account/" . $account_id);
        } else {
          // error message
          return $app->redirect("/owner_account/" . $account_id);
        }
    } else {
        // error message
        return $app->redirect("/owner_account/" . $account_id);
    }
})
->before($is_logged_in)
->before($client_only);
