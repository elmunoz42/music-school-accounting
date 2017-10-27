<?php
//READ course
$app->get("/owner_courses/{course_id}", function($course_id) use ($app){
    $school = School::find($_SESSION['school_id']);
    $course = Course::find($course_id);

    if ($course) {
        return $app['twig']->render('owner_course.html.twig', array(
            'school'=> $school,
            'course' => $course,
            'courses' => $school->getCourses(),
            'enrolled_students'=>$course->getStudents(), 'students'=>$school->getStudents(),
            'lessons' => $course->getLessons()
        ));
    } else {
        // course is not found
        return $app->redirect("/owner_courses");
    }
})->before($is_logged_in);



//REDIRECT post to course
$app->post("/owner_courses/redirect", function() use ($app) {
    $school=School::find($_SESSION['school_id']);
    $course = Course::find($_POST['course_select']);
    $id = $course->getId();

    return $app['twig']->render('owner_course.html.twig', array(
      'school'=>$school,
      'course' => $course,
      'courses' => $school->getCourses(),
      'enrolled_students'=>$course->getStudents(), 'students'=>$school->getStudents(),
      'lessons' => $school->getLessons() ));
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

    return $app->redirect("/owner_courses/" . $course_id);
})->before($is_logged_in);


//JOIN students to course
$app->post("/owner_courses/{id}", function($id) use ($app){
    $school = School::find($_SESSION['school_id']);
    $course = Course::find($id);
    $selected_student = Student::find($_POST['student_id']);

    $selected_student->addCourse($id);

    return $app['twig']->render('owner_course.html.twig', array(
      'school'=>$school,
      'course' => $course,
      'courses' => $school->getCourses(),
      'enrolled_students'=>$course->getStudents(), 'students'=>$school->getStudents(),
      'lessons' => $school->getLessons() ));
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
