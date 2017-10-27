<?php
// READ courses
$app->get("/owner_courses", function() use ($app) {
    $school = School::find($_SESSION['school_id']);

    return $app['twig']->render('owner_courses.html.twig', array('school' => $school, 'courses' => $school->getCourses()));
})->before($is_logged_in);


// CREATE new course
$app->post("/owner_courses", function() use ($app) {
    $school=School::find($_SESSION['school_id']);
    $course_title = $_POST['course_title'];
    $new_course = new Course($course_title);
    $new_course->save();
    $school->addCourse($new_course->getId());
    return $app['twig']->render('owner_courses.html.twig', array('school' => $school, 'courses' => $school->getCourses()));
})->before($is_logged_in);
