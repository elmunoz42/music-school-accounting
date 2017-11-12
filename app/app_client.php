<?php

// READ client
$app->get('/client/{client_id}', function($client_id) use ($app) {
    $school = School::find($_SESSION['school_id']);
    $client = Client::find($client_id);


    // if client try to access to different clients info, redirect
    if ( ($_SESSION['role'] == 'client') && ($_SESSION['role_id'] != $client_id)) {
        return $app->redirect("/client/" . $_SESSION['role_id']);
    }


    if ($client) {
        $students = $client->getStudents();
        $teachers = $client->getTeachers();
        $courses = $client->getCourses();
        $lessons = $client->getLessons();
        $notes_array = explode("|", $client->getNotes());
        $last_month = intval(date('m',strtotime('last month')));
        $last_months_year = intval(date('Y',strtotime('last month')));

        return $app['twig']->render('client.html.twig', array(
            'role' => $_SESSION['role'],
            'school'=>$school,
            'client'=>$client,
            'clients'=>$school->getClients(),
            'students'=>$students, 'teachers'=>$teachers,
            'courses'=>$courses,
            'notes_array'=>$notes_array,
            'services'=>$client->getServices(),
            'lessons'=>$lessons,
            'last_month'=>$last_month,
            'last_months_year'=>$last_months_year
        ));
    } else {
        // client is not found
        $app['session']->getFlashBag()->add('errors', "Unexpected Error Happened");
        return $app->redirect($_SESSION['location_uri']);
    }
})
->before($is_logged_in)
->before($client_only)
->after($save_location_uri);



//UPDATE client notes
$app->patch("/client/{client_id}/add_note", function($client_id) use ($app) {
    $selected_client = Client::find($client_id);

    $new_notes = $_POST['new_notes'] ? $_POST['new_notes'] : '';

    if($new_notes) {
        $updated_notes =  date('l jS \of F Y ') . "---->"  . $new_notes  . "|" . $selected_client->getNotes();
        $selected_client->updateNotes($updated_notes);
        $app['session']->getFlashBag()->add('success', "New note added");

    } else {
      // add error
      $app['session']->getFlashBag()->add('errors', "Note cannot be blank");
    }
    return $app->redirect($_SESSION['location_uri']);
})
->before($is_logged_in)
->before($client_only);


//UPDATE client
$app->post("/client/{client_id}/update", function($client_id) use ($app) {
    $client = Client::find($client_id);

    $family_name = $_POST['family_name'] ? $_POST['family_name'] : '';
    $parent_one_name = $_POST['parent_one_name'] ? $_POST['parent_one_name'] : '';
    $parent_two_name = $_POST['parent_two_name'] ? $_POST['parent_two_name'] : '';
    $street_address = $_POST['street_address'] ? $_POST['street_address'] : '';
    $phone_number = $_POST['phone_number'] ? $_POST['phone_number'] : '';
    $email_address = $_POST['email_address'] ? $_POST['email_address'] : '';

    if ($client->updateFamilyName($family_name) && $client->updateParentOneName($parent_one_name) && $client->updateParentTwoName($parent_two_name) && $client->updateSteetAddress($street_address) && $client->updatePhoneNumber($phone_number) && $client->updateEmailAddress($email_address)) {

        $app['session']->getFlashBag()->add('success', "Successfully updated");
        return $app->redirect($_SESSION['location_uri']);
    } else {
        // error
        $app['session']->getFlashBag()->add('errors', "Unexpected errors happened");
        return $app->redirect($_SESSION['location_uri']);
    }
})
->before($is_logged_in)
->before($client_only);



//DELETE client
$app->delete("/client/{client_id}/delete", function($client_id) use ($app) {
    $school = School::find($_SESSION['school_id']);
    $client = Client::find($client_id);
    $students = $client->getStudents();

    if ($client->deleteStudents($students)) {

        if ($client->delete()) {
            //Success
            $app['session']->getFlashBag()->add('success', "Client deleted");
            return $app->redirect("/clients");
        } else {
            //Error
            $app['session']->getFlashBag()->add('errors', "Unexpected errors happened");
            return $app->redirect("/clients");
        }
    } else {
        $app['session']->getFlashBag()->add('errors', "Unexpected errors happened");
        return $app->redirect("/clients");
    }
})
->before($is_logged_in)
->before($owner_only);


// JOIN add student to client
$app->post('/add_student_to_client', function() use($app) {
    $client_id = $_POST['client_id'] ? $_POST['client_id'] : '';
    $student_name = $_POST['student_name'] ? $_POST['student_name'] : '';
    $email_address = $_POST['email_address'] ? $_POST['email_address'] : '';

    if ($client_id && $student_name && $email_address) {
        $selected_client = Client::find($client_id);
        $school = School::find($_SESSION['school_id']);

        if ($selected_client && $school) {
            $student = new Student($student_name, $email_address);
            $student->save();

            $student_id = $student->getId();
            $school->addStudent($student_id);

            $selected_client->addStudent($student_id);

            $app['session']->getFlashBag()->add('success', "Successfully added");

            return $app->redirect("/client/" . $client_id);
        } else {
          // error
          $app['session']->getFlashBag()->add('errors', "Unexpected errors happened");
          return $app->redirect("/client/" . $client_id);
        }
    } else {
        // error
        $app['session']->getFlashBag()->add('errors', "Unexpected errors happened");
        return $app->redirect("/client/" . $client_id);
    }
})
->before($is_logged_in)
->before($client_only);
