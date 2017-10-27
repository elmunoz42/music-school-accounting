<?php

// GET session
$app->get('/owner_sessions/{service_id}', function($service_id) use($app) {
    $school = School::find($_SESSION['school_id']);
    $service = Service::find($service_id);

    if ($service) {
        $notes_array = explode("|", $service->getNotes());
        return $app['twig']->render(
            'owner_session.html.twig', array(
                'school'=>$school, 'service'=>$service, 'notes_array'=>$notes_array
            )
        );
    } else {
        // NOTE: which page the user should be redirected to??
        // session is not found
        return $app->redirect("/owner_main");
    }
})->before($is_logged_in);



// Update session NOTE: NEEDS TO BE CREATED
$app->patch('/owner_sessions/{id}', function($id) use($app) {
    $school = School::find($_SESSION['school_id']);
    $service = Service::find($id);
    $service->updateDateOfService($_POST['date_of_service']);
    $service->updateRecurrence($_POST['recurrence']);
    $service->updateAttendance($_POST['attendance']);
    $service->updateDuration($_POST['duration']);
    $new_notes = $_POST['new_notes'];
    $updated_notes =  date('l jS \of F Y ') . "---->"  . $new_notes  . "|" . $service->getNotes();
    $service->updateNotes($updated_notes);
    $notes_array = explode("|", $updated_notes);

    return $app['twig']->render('owner_session.html.twig', array('school'=>$school, 'service'=>$service, 'notes_array'=>$notes_array));
})->before($is_logged_in);


// AJAX: Update paid_for status
$app->post('/owner_sessions_update_paid_for', function() use($app) {
    $paid_status = $_POST['paid_status'];
    $service_id = (int)$_POST['service_id'];
    $service = Service::find($service_id);

    if ($paid_status === "true") {
        $paid_status = "false";
        $service->updatePaidFor("0");
    } else {
        $paid_status = "true";
        $service->updatePaidFor("1");
    }
    return $app->json($paid_status);
})->before($is_logged_in);
