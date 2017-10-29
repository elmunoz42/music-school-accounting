<?php

//READ teachers
$app->get("/owner_teachers", function() use ($app) {
    $school = School::find($_SESSION['school_id']);

    return $app['twig']->render('owner_teachers.html.twig', array('school' => $school, 'teachers' => $school->getTeachers()));
})
->before($is_logged_in)
->before($student_only);

//CREATE teacher
$app->post("/owner_teachers", function() use ($app) {
    $new_teacher_name = $_POST['teacher_name'] ? $_POST['teacher_name'] : '';
    $new_teacher_instrument = $_POST['teacher_instrument'] ? $_POST['teacher_instrument'] : '';
    // NOTE Carlos changed $_POST['teacher_name'] : '' to $_POST['teacher_instrument'] : ''

    if ($new_teacher_name && $new_teacher_instrument) {
        $school = School::find($_SESSION['school_id']);
        if ($school) {
            $new_teacher = new Teacher($new_teacher_name, $new_teacher_instrument);
            $new_teacher->setNotes(date('l jS \of F Y h:i:s A') . " of first entry.");

            if ($new_teacher->save()) {
                if ($school->addTeacher($new_teacher->getId())) {
                    // success message
                } else {
                    //error message
                }
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
