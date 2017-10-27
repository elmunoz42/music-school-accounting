<?php

//READ student NOTE use for family and teacher
$app->get("/owner_students/{student_id}", function($student_id) use ($app) {
    $school = School::find($_SESSION['school_id']);
    $student = Student::find($student_id);

    if ($student) {
      $notes_array = explode("|", $student->getNotes());
      $assigned_teachers = $student->getTeachers();
      $this_month=intval(date('m',strtotime('this month')));
      $this_months_year=intval(date('Y',strtotime('this month')));
      $last_month=intval(date('m',strtotime('last month')));
      $last_months_year=intval(date('Y',strtotime('last month')));

      return $app['twig']->render('owner_student.html.twig', array(
        'school' => $school,
        'student' => $student,
        'assigned_teachers' => $assigned_teachers,
        'notes_array' => $notes_array,
        'courses'=>$school->getCourses(), 'enrolled_courses'=>$student->getCourses(),
        'teachers' => $school->getTeachers(),
        'lessons' => $school->getLessons(),
        'assigned_lessons' => $student->getLessons(),
        'this_month' => $this_month,
        'this_months_year'=>$this_months_year,
        'last_month'=>$last_month,
        'last_months_year'=>$last_months_year
      ));
    } else {
        // student is not found
        return $app->redirect("/owner_students");
    }
})->before($is_logged_in);


//JOIN student to course
$app->post("/owner_students/{student_id}/enroll", function($student_id) use ($app) {
    $course_id = $_POST['course_id'] ? $_POST['course_id'] : '';

    if ($course_id) {
        $student = Student::find($student_id);
        $course = $student->findCourseById($course_id);

        if (!$course) {
            if ($student->addCourse($course_id)) {
                //add success message
            } else {
                // add error message
            }
        } else {
            // already enrolled
            // add error message
        }
    }
    return $app->redirect("/owner_students/" . $student_id);
})->before($is_logged_in);


//UPDATE student notes
$app->patch("/owner_students/{student_id}/add_notes", function($student_id) use ($app) {
    $selected_student = Student::find($student_id);
    $new_notes = $_POST['new_notes'] ? $_POST['new_notes'] : '';

    if ($new_notes) {
        $updated_notes =  date('l jS \of F Y ') . "---->"  . $new_notes  . "|" . $selected_student->getNotes();
        $selected_student->updateNotes($updated_notes);
        // add success message
    } else {
      // add error
    }
    return $app->redirect("/owner_students/" . $student_id);
})->before($is_logged_in);


//UPDATE student service NOTE UNTESTED UNTESTED UNTESTED
// $app->update("/owner_students/student_student_update_service/{id}, function($id) use($app)" {
//
//     $school=School::find($_SESSION['school_id']);
//     $selected_service = Service::find($id);
//     $selected_student = $selected_service->getStudents()[0];
//     $notes_array = explode("|", $selected_student->getNotes());
//     $assigned_teachers = $selected_student->getTeachers();
//     $this_month=intval(date('m',strtotime('this month')));
//     $this_months_year=intval(date('Y',strtotime('this month')));
//     $last_month=intval(date('m',strtotime('last month')));
//     $last_months_year=intval(date('Y',strtotime('last month')));
//
//     return $app['twig']->render('owner_student.html.twig', array(
//       'school' => $school,
//       'student' => $selected_student,
//       'assigned_teachers' => $assigned_teachers,
//       'notes_array' => $notes_array,
//       'courses'=>$school->getCourses(), 'enrolled_courses'=>$selected_student->getCourses(),
//       'teachers' => $school->getTeachers(),
//       'lessons' => $school->getLessons(),
//       'assigned_lessons' => $selected_student->getLessons(),
//       'this_month' => $this_month,
//       'this_months_year'=>$this_months_year,
//       'last_month'=>$last_month,
//       'last_months_year'=>$last_months_year
//     ));
// });
