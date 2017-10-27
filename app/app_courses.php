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



$app->post("/owner_courses/{course_id}/update", function($course_id) use ($app) {
    $new_title = $_POST['title'] ? $_POST['title'] : '';
    if ($new_title) {
        $course = Course::find($course_id);
        if ($course) {
            if ($course->updateTitle($new_title)) {
                //add success message
            } else {
                // add error message
            }
        } else {
            // add error message
        }
    } else {
        // add error message
    }
    return $app->redirect("/owner_courses");
})->before($is_logged_in);



$app->delete("/owner_courses/{course_id}/delete", function($course_id) use ($app) {
    $school = School::find($_SESSION['school_id']);
    $course = Course::find($course_id);

    if ($course->deleteCourse()) {
        // add success message
        return $app->redirect("/owner_courses");
    } else {
        // add error message
        return $app->redirect("/owner_courses");
    }
})->before($is_logged_in);
