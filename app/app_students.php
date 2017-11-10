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
