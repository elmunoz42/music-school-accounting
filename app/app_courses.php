<?php
// READ courses
$app->get("/courses", function() use ($app) {
    $school = School::find($_SESSION['school_id']);

    return $app['twig']->render('courses.html.twig', array('role' => $_SESSION['role'], 'school' => $school, 'courses' => $school->getCourses()));
})
->before($is_logged_in)
->after($save_location_uri);


// CREATE new course
$app->post("/courses", function() use ($app) {
    $school = School::find($_SESSION['school_id']);
    $course_title = $_POST['course_title'];
    $new_course = new Course($course_title);
    $new_course->save();
    $school->addCourse($new_course->getId());

    return $app->redirect("/courses");
})
->before($is_logged_in)
->before($teacher_only);
