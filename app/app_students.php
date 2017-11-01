<?php

//READ students
$app->get("/owner_students", function() use ($app) {
    $school=School::find($_SESSION['school_id']);

    return $app['twig']->render('owner_students.html.twig', array('school' => $school, 'students' => $school->getStudents(), 'teachers' => $school->getTeachers()));
})
->before($is_logged_in)
->before($teacher_only)
->after($save_location_uri);

//CREATE students
$app->post("/owner_students", function() use ($app) {
    $school=School::find($_SESSION['school_id']);

    $new_student_name = $_POST['student_name'];
    $new_student = new Student($new_student_name);
    $new_student->setNotes(date('l jS \of F Y h:i:s A') . " of first entry.");
    $new_student->save();
    $school->addStudent($new_student->getId());

    return $app['twig']->render('owner_students.html.twig', array('school' => $school, 'students' => $school->getStudents(), 'teachers' => $school->getTeachers()));
})
->before($is_logged_in)
->before($client_only);
