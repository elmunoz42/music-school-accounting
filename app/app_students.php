<?php

//READ students
$app->get("/owner_students", function() use ($app) {
    $school=School::find($_SESSION['school_id']);

    return $app['twig']->render('owner_students.html.twig', array('school' => $school, 'students' => $school->getStudents(), 'teachers' => $school->getTeachers()));
})
->before($is_logged_in)
->before($teacher_only);

//CREATE students
$app->post("/owner_students", function() use ($app) {
    $school=School::find($_SESSION['school_id']);

    $new_student_name = $_POST['student_name'];
    $new_student = new Student($new_student_name);
    $new_student->setNotes(date('l jS \of F Y h:i:s A') . " of first entry.");
    $new_student->save();
    $school->addStudent($new_student->getId());

    return $app['twig']->render('owner_students.html.twig', array('school' => $school, 'students' => $school->getStudents(), 'teachers' => $school->getTeachers()));
})->before($is_logged_in);







// //READ student
// $app->get("/teacher_students/{id}", function($id) use($app) {
//
//     $school=School::find($_SESSION['school_id']);
//     $teacher=Teacher::find($_SESSION['teacher_id']);
//     $student=Student::find($id);
//
//     return $app['twig']->render('teacher_student.html.twig', array('school_name'=>$school->getName(), 'teacher' => $teacher, 'student'=>$student, 'lessons'=>$student->getLessons(), 'courses'=>$student->getCourses(), 'services'=>$student->getServices() ));
//
// });
