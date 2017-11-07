<?php

//CREATE a Lesson NOTE GO BACK TO COURSES THOUGH
$app->post("/lesson/{id}", function($id) use ($app) {
    $school = School::find($_SESSION['school_id']);
    $course = Course::find($id);
    $title = $_POST['title'];
    $description = $_POST['description'];
    $content = $_POST['content'];
    $lesson = new Lesson($title,$description,$content,$input_id);
    $lesson->save();
    $lesson_id = $lesson->getId();
    $course->addLesson($lesson_id);

    return $app['twig']->render('course.html.twig', array(
      'role' => $_SESSION['role'],
      'school'=>$school,
      'course' => $course,
      'enrolled_students'=>$course->getStudents(), 'students'=>$school->getStudents(),
      'lessons' => $school->getLessons() ));
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
        return $app->redirect("/courses");
    }
})
->before($is_logged_in)
->after($save_location_uri);


//DELETE Lesson
$app->delete("/lesson/{lesson_id}/delete", function($lesson_id) use ($app) {
    $course_id = $_POST['course_id'] ? $_POST['course_id'] : '';

    if ($course_id) {
        $lesson = Lesson::find($lesson_id);

        if ($lesson->delete()) {
            // add success message
            return $app->redirect("/course/" . $course_id);
        } else {
            // add error message
            return $app->redirect("/course/" . $course_id);
        }
    }
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
        return $app->redirect("/course/" . $course_id);
    } else {
        // add error message
        return $app->redirect("/course/" . $course_id);
    }
})
->before($is_logged_in)
->before($teacher_only);
