<?php

//READ students
$app->get("/students", function() use ($app) {
    $school = School::find($_SESSION['school_id']);

    return $app['twig']->render('students.html.twig',
        array(
            'role' => $_SESSION['role'],
            'school' => $school,
            'students' => $school->getStudents(),
            'teachers' => $school->getTeachers()
          )
    );
})
->before($is_logged_in)
->before($teacher_only)
->after($save_location_uri);

//CREATE students
$app->post("/students", function() use ($app) {
    $school = School::find($_SESSION['school_id']);

    $new_student_name = $_POST['student_name'] ? $_POST['student_name'] : '';
    $new_student = new Student($new_student_name);
    $new_student->setNotes(date('l jS \of F Y h:i:s A') . " of first entry.");

    if ($new_student->save()) {
        if ($school->addStudent($new_student->getId())) {

            $app['session']->getFlashBag()->add('success', 'Successfully added');

        } else {
            //error
            $app['session']->getFlashBag()->add('errors', 'Unexcepted error happened');
        }
    } else {
        //error
        $app['session']->getFlashBag()->add('errors', 'Unexcepted error happened');
    }

    return $app->redirect("/students");
})
->before($is_logged_in)
->before($client_only);
