<?php

// add lesson
$app->post("/lesson/{lesson_id}", function($lesson_id) use ($app) {
    $school = School::find($_SESSION['school_id']);
    $course = Course::find($lesson_id);


    $title = $_POST['title'] ? $_POST['title'] : '';
    $description = $_POST['description'] ? $_POST['description'] : '';
    $content = $_POST['content'] ? $_POST['content'] : 'content';

    $lesson = new Lesson($title, $description, $content, $input_id);


    if ($lesson->save()) {
        $lesson_id = $lesson->getId();

        if ($course->addLesson($lesson_id)) {

            $app['session']->getFlashBag()->add('success', 'Successfully added lesson');

        } else {

            $app['session']->getFlashBag()->add('errors', 'Unexcepted error happened');
        }
    } else {
        $app['session']->getFlashBag()->add('errors', 'Unexcepted error happened');
    }

    return $app->redirect($_SESSION['location_uri']);
})
->before($is_logged_in)
->before($teacher_only);


//READ lesson
$app->get("/lesson/{lesson_id}", function($lesson_id) use ($app){
    $school = School::find($_SESSION['school_id']);
    $lesson = Lesson::find($lesson_id);

    if ($lesson) {
        return $app['twig']->render('lesson.html.twig', array(
            'role' => $_SESSION['role'],
            'school'=>$school,
            'lesson'=>$lesson
        ));
    } else {
        // lesson is not found
        $app['session']->getFlashBag()->add('errors', 'page does not exist');
        return $app->redirect($_SESSION['location_uri']);
    }
})
->before($is_logged_in)
->after($save_location_uri);


//DELETE Lesson
$app->delete("/lesson/{lesson_id}/delete", function($lesson_id) use ($app) {
    $course_id = $_POST['course_id'] ? $_POST['course_id'] : '';
    $lesson = Lesson::find($lesson_id);

    if ($lesson) {
        if ($course_id) {
            if ($lesson->delete()) {
                // add success message
                $app['session']->getFlashBag()->add('success', 'Successfully deleted');
                return $app->redirect("/course/" . $course_id);
            } else {
                // add error message
                $app['session']->getFlashBag()->add('errors', 'Unexcepted error happened');
            }
        } else {
            $app['session']->getFlashBag()->add('errors', 'Unexcepted error happened');
        }
    } else {
        $app['session']->getFlashBag()->add('errors', 'Unexcepted error happened');
    }

    // error case: back to previous page
    $app->redirect($_SESSION['location_uri']);
})
->before($is_logged_in)
->before($owner_only);


//UPDATE Lesson
$app->post("/lesson/{lesson_id}/update", function($lesson_id) use ($app) {
    $lesson = Lesson::find($lesson_id);

    $course_id = $_POST['course_id'] ? $_POST['course_id'] : '';
    $title = $_POST['title'] ? $_POST['title'] : '';
    $description = $_POST['description'] ? $_POST['description'] : '';
    $content = $_POST['content'] ? $_POST['content'] : '';

    if ($lesson->updateTitle($title) && $lesson->updateDescription($description) && $lesson->updateContent($content)) {

        // add success message
        $app['session']->getFlashBag()->add('success', 'Successfully updated');

        if ($course_id) {
            return $app->redirect($_SESSION['location_uri']);
        }
    } else {
        // add error message
        $app['session']->getFlashBag()->add('errors', 'Unexcepted error happened');
    }

    // error case: back to previous page
    $app->redirect($_SESSION['location_uri']);
})
->before($is_logged_in)
->before($teacher_only);
