<?php

//READ teachers
$app->get("/teachers", function() use ($app) {
    $school = School::find($_SESSION['school_id']);

    return $app['twig']->render('teachers.html.twig', array('role' => $_SESSION['role'], 'school' => $school, 'teachers' => $school->getTeachers()));
})
->before($is_logged_in)
->before($owner_only)
->after($save_location_uri);

//CREATE teacher
$app->post("/teachers", function() use ($app) {

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

                //TODO REFACTOR check both addTeacher and addUser successfull, then display Success message
                if ($school->addTeacher($teacher->getId())) {
                    $app['session']->getFlashBag()->add('success', 'Successfully added teacher');

                } else {
                    //error message
                    $app['session']->getFlashBag()->add('errors', 'Unexpected error happened');
                }

                if ( $teacher->addUser($_SESSION['new_account_id']) ) {
                    // success message
                } else {
                    // error message
                    $app['session']->getFlashBag()->add('errors', 'Unexpected error happened');
                }
                unset($_SESSION['new_account_id']);

            } else {
                // error message
                $app['session']->getFlashBag()->add('errors', 'Unexpected error happened');
            }
        } else {
            // unknown error
            $app['session']->getFlashBag()->add('errors', 'Unexpected error happened');
        }
    } else {
        // error message
        $app['session']->getFlashBag()->add('errors', 'Unexpected error happened');
    }

    return $app->redirect("/teachers");
})
->before($is_logged_in)
->before($owner_only);
