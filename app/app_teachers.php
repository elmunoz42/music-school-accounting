<?php

//READ teachers
$app->get("/owner_teachers", function() use ($app) {
    $school = School::find($_SESSION['school_id']);

    return $app['twig']->render('owner_teachers.html.twig', array('school' => $school, 'teachers' => $school->getTeachers()));
})
->before($is_logged_in)
->before($client_only)
->after($save_location_uri);

//CREATE teacher
$app->post("/owner_teachers", function() use ($app) {

    // get previous location uri
    $location_uri = $_SESSION['location_uri'];

    //get user input
    $teacher_name = $_POST['teacher_name'] ? $_POST['teacher_name'] : '';
    $teacher_instrument = $_POST['teacher_instrument'] ? $_POST['teacher_instrument'] : '';


    if ($teacher_name && $teacher_instrument) {

        $school = School::find($_SESSION['school_id']);

        if ($school) {
            $teacher = new Teacher($teacher_name, $teacher_instrument);
            $teacher->setNotes(date('l jS \of F Y h:i:s A') . " of first entry.");

            if ($teacher->save()) {

                if ($school->addTeacher($teacher->getId())) {

                } else {
                  //error message
                }

                if ( $teacher->addUser($_SESSION['new_account_id']) ) {
                    // success message
                } else {
                    // error message
                }
                unset($_SESSION['new_account_id']);

            } else {
                // error message
            }
        } else {
            // unknown error
        }
    } else {
        // error message
    }

    return $app->redirect("/owner_teachers");
})
->before($is_logged_in)
->before($owner_only);
