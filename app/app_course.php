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
        // course is not found
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
    $lesson->save();
    $lesson_id = $lesson->getId();
    $school->addLesson($lesson_id);
    $course->addLesson($lesson_id);
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
            } else {
                // add error message
            }
        } else {
           // add errpr ,essage
        }
    } else {
        // add error
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
            } else {
                // add error message
            }
        } else {
            // add error message
        }
    } else {
        // add error message
    }
    return $app->redirect("/courses");
})
->before($is_logged_in)
->before($teacher_only);


$app->delete("/course/{course_id}/delete", function($course_id) use ($app) {
    $school = School::find($_SESSION['school_id']);
    $course = Course::find($course_id);

    if ($course->deleteCourse()) {
        // add success message
        return $app->redirect("/courses");
    } else {
        // add error message
        return $app->redirect("/courses");
    }
})
->before($is_logged_in)
->before($owner_only);
