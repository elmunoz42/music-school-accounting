<?php
//READ course
$app->get("/course/{course_id}", function($course_id) use ($app){
    $school = School::find($_SESSION['school_id']);
    $course = Course::find($course_id);

    if ($course) {
        return $app['twig']->render('course.html.twig', array(
            'role' => $_SESSION['role'],
            'course' => $course,
            'students'=> $course->getStudents(),
            'all_students' =>$school->getStudents(),
            'lessons' => $course->getLessons()
        ));
    } else {
        $app['session']->getFlashBag()->add('errors', "Unexpected errors happened");
        return $app->redirect("/courses");
    }
})
->before($is_logged_in)
->after($save_location_uri);


//JOIN add a lesson to a course
$app->post("/add_lesson_to_course", function() use($app) {
    $course_id = $_POST['course_id'] ? $_POST['course_id'] : '';
    $title = $_POST['title'] ? $_POST['title'] : '';
    $description = $_POST['description'] ? $_POST['description'] : '';
    $content = $_POST['content'] ? $_POST['content'] : '';

    $school = School::find($_SESSION['school_id']);
    $course = Course::find($_POST['course_id']);

    $lesson = new Lesson($title, $description, $content);

    if ($lesson->save()) {

      $lesson_id = $lesson->getId();

      if ($school->addLesson($lesson_id) && $course->addLesson($lesson_id)) {
          $app['session']->getFlashBag()->add('success', 'Successfully added lesson');

      } else {
          $app['session']->getFlashBag()->add('errors', 'Unexpected error happened');
      }

    } else {
        $app['session']->getFlashBag()->add('errors', 'Unexpected error happened');
    }
    return $app->redirect("/course/". $course_id);

})
->before($is_logged_in)
->before($teacher_only);


//JOIN students to course
$app->post("/course/{course_id}", function($course_id) use ($app){
    $student_id = $_POST['student_id'] ? $_POST['student_id'] : '';

    if ($student_id) {
        $student = Student::find($student_id);
        $course = $student->findCourseById($course_id);

        if (!$course) {
            if ($student->addCourse($course_id)) {
                //add success message
                $app['session']->getFlashBag()->add('success', 'Successfully added');
            } else {
                // add error message
                $app['session']->getFlashBag()->add('errors', 'Unexpected error happened');
            }
        } else {
            // add errpr message
            $app['session']->getFlashBag()->add('errors', 'Unexpected error happened');
        }
    } else {
        // add error
        $app['session']->getFlashBag()->add('errors', 'Unexpected error happened');
    }

    return $app->redirect("/course/" . $course_id);
})
->before($is_logged_in)
->before($teacher_only);


$app->post("/course/{course_id}/update", function($course_id) use ($app) {
    $new_title = $_POST['title'] ? $_POST['title'] : '';
    if ($new_title) {
        $course = Course::find($course_id);

        if ($course) {
            if ($course->updateTitle($new_title)) {
                //add success message
                $app['session']->getFlashBag()->add('success', 'Successfully updated');
            } else {
                // add error message
                $app['session']->getFlashBag()->add('errors', 'Unexpected error happened');
            }
        } else {
            // add error message
            $app['session']->getFlashBag()->add('errors', 'Unexpected error happened');
        }
    } else {
        // add error message
        $app['session']->getFlashBag()->add('errors', 'Input cannot be blank');
    }
    return $app->redirect($_SESSION['location_uri']);
})
->before($is_logged_in)
->before($teacher_only);


$app->delete("/course/{course_id}/delete", function($course_id) use ($app) {
    $school = School::find($_SESSION['school_id']);
    $course = Course::find($course_id);

    if ($course->deleteCourse()) {
        // add success message
        $app['session']->getFlashBag()->add('success', 'Successfully deleted');
    } else {
        // add error message
        $app['session']->getFlashBag()->add('errors', 'Unexpected error happened');
    }
    return $app->redirect($_SESSION['location_uri']);
})
->before($is_logged_in)
->before($owner_only);
