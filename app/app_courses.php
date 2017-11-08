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
    $course_title = $_POST['course_title'] ? $_POST['course_title'] : '';

    if ($course_title) {
        $new_course = new Course($course_title);


        if ($new_course->save() && $school->addCourse($new_course->getId())) {
            //success
            $app['session']->getFlashBag()->add('success', 'Successfully added course');

        } else {
            //error
            $app['session']->getFlashBag()->add('errors', 'Unexpected error happened');
        }

    } else {
        $app['session']->getFlashBag()->add('errors', 'Input cannot be blank');
    }

    return $app->redirect("/courses");
})
->before($is_logged_in)
->before($teacher_only);
