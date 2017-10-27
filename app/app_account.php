<?php

// READ account
$app->get('/owner_accounts/{account_id}', function($account_id) use ($app) {
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
            'selected_students'=>$students, 'selected_teachers'=>$teachers,
            'selected_courses'=>$courses,
            'notes_array'=>$notes_array,
            'services'=>$account->getServices(),
            'selected_lessons'=>$lessons,
            'last_month'=>$last_month,
            'last_months_year'=>$last_months_year
        ));
    } else {
        // account is not found
        return $app->redirect("/owner_accounts");
    }
})->before($is_logged_in);



//UPDATE account notes
$app->patch("/owner_accounts/{account_id}/add_notes", function($account_id) use ($app) {
    $selected_account = Account::find($account_id);

    $new_notes = $_POST['new_notes'] ? $_POST['new_notes'] : '';

    if($new_notes) {
        $updated_notes =  date('l jS \of F Y ') . "---->"  . $new_notes  . "|" . $selected_account->getNotes();
        $selected_account->updateNotes($updated_notes);
        // add success message
    } else {
      // add error
    }
    return $app->redirect("/owner_accounts/" . $account_id);
})->before($is_logged_in);
