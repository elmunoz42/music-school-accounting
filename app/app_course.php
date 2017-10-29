<?php
//READ course
$app->get("/owner_course/{course_id}", function($course_id) use ($app){
    $school = School::find($_SESSION['school_id']);
    $course = Course::find($course_id);

    if ($course) {
        return $app['twig']->render('owner_course.html.twig', array(
            'course' => $course,
            'students'=>$course->getStudents(),
            'all_students'=>$school->getStudents(),
            'lessons' => $course->getLessons()
        ));
    } else {
        // course is not found
        return $app->redirect("/owner_courses");
    }
})->before($is_logged_in);


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
    return $app->redirect("/owner_course/". $course_id);

})->before($is_logged_in);


//JOIN students to course
$app->post("/owner_course/{course_id}", function($course_id) use ($app){
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

    return $app->redirect("/owner_course/" . $course_id);
})->before($is_logged_in);


$app->post("/owner_course/{course_id}/update", function($course_id) use ($app) {
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


$app->delete("/owner_course/{course_id}/delete", function($course_id) use ($app) {
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



// //READ course
// $app->get("/teacher_courses/{id}", function($id) use ($app) {
//
//     $school=School::find($_SESSION['school_id']);
//     $teacher=Teacher::find($_SESSION['teacher_id']);
//     $course=Course::find($id);
//     $lessons=$course->getLessons();
//
//     return $app['twig']->render('teacher_course.html.twig', array('school'=>$school->getName(), 'course'=>$course, 'teacher'=>$teacher, 'course_teachers'=>$course->getTeachers(),'lessons'=> $lessons ));
//
// });



// CREATE lesson
// $app->post("/teacher_lessons/{id}", function($id) use ($app) {
//
//     $school=School::find($_SESSION['school_id']);
//     $course = Course::find($id);
//     $title = $_POST['title'];
//     $description = $_POST['description'];
//     $content = $_POST['content'];
//     $lesson = new Lesson($title,$description,$content,$input_id);
//     $lesson->save();
//     $lesson_id = $lesson->getId();
//     $course->addLesson($lesson_id);
//     $teacher->addLesson($lesson_id);
//     $lessons=$course->getLessons();
//
//     return $app['twig']->render('teacher_course.html.twig', array('school'=>$school->getName(), 'course'=>$course, 'teacher'=>$teacher, 'course_teachers'=>$course->getTeachers(),'lessons'=> $lessons ));
//
// });
