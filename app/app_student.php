<?php

//READ student NOTE use for family and teacher
$app->get("/student/{student_id}", function($student_id) use ($app) {

    if ($_SESSION['role'] == 'teacher') {
        $teacher = Teacher::find($_SESSION['role_id']);

        if ($teacher) {
            if (!$teacher->findStudentById($student_id)){
                // if student is not assigend to this teacher, redirect
                // add error
                return $app->redirect($_SESSION['location_uri']);
            }
        }
    }

    if ($_SESSION['role'] == 'client') {
        $client = Account::find($_SESSION['role_id']);

        if ($client) {
            if (!$client->findStudentById($student_id)) {
                // if student is not assigend to this account, redirect
                // add error
                return $app->redirect($_SESSION['location_uri']);
            }
        }
    }


    $month = date("m");
    $year = date("Y");

    // if month & year parameters are passed, update $month and $year
    if (!empty($_GET['month'])) {
      $month = filter_input(INPUT_GET, 'month', FILTER_VALIDATE_INT);
      if ($month === false) {
        $month = date("m");
      }
    }

    if (!empty($_GET['year'])) {
      $year = filter_input(INPUT_GET, 'year', FILTER_VALIDATE_INT);
      if ($year === false) {
        $year = date("Y");
      }
    }


    $school = School::find($_SESSION['school_id']);
    $student = Student::find($student_id);


    if ($student) {
      $notes_array = explode("|", $student->getNotes());
      $assigned_teachers = $student->getTeachers();

      $datestamp = mktime(0, 0, 0, $month, 1, $year);

      $services = $student->getServicesForMonth($month, $year);


      return $app['twig']->render('student.html.twig', array(
        'role' => $_SESSION['role'],
        'student' => $student,
        'services' => $services,
        'teachers' => $assigned_teachers,
        'notes_array' => $notes_array,
        'courses'=>$school->getCourses(), 'enrolled_courses'=>$student->getCourses(),
        'datestamp' => $datestamp
      ));
    } else {
        // student is not found
        return $app->redirect("/students");
    }
})
->before($is_logged_in)
// ->before($client_only)
->after($save_location_uri);


//JOIN student to course
$app->post("/student/{student_id}/enroll", function($student_id) use ($app) {
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
    return $app->redirect("/student/" . $student_id);
})
->before($is_logged_in)
->before($client_only);


//UPDATE student notes
$app->patch("/student/{student_id}/add_notes", function($student_id) use ($app) {
    $selected_student = Student::find($student_id);
    $new_notes = $_POST['new_notes'] ? $_POST['new_notes'] : '';

    if ($new_notes) {
        $updated_notes =  date('l jS \of F Y ') . "---->"  . $new_notes  . "|" . $selected_student->getNotes();
        $selected_student->updateNotes($updated_notes);
        // add success message
    } else {
      // add error
    }
    return $app->redirect("/student/" . $student_id);
})
->before($is_logged_in)
->before($client_only);


//DELETE student from school
$app->delete("/student/student_termination/{id}", function($id) use ($app) {
    $school=School::find($_SESSION['school_id']);
    $school->removeStudent($id);

    // NOTE CHECK IF WORKS
    // $student = Student::find($id);
    // $student->delete();

    return $app->redirect("/students");
})
->before($is_logged_in)
->before($owner_only);


// UPDATE student
$app->post("/student/{student_id}/update", function($student_id) use ($app) {
    $new_student_name = $_POST['student_name'] ? $_POST['student_name'] : '';
    if ($new_student_name) {
        $student = Student::find($student_id);
        if ($student) {
            if ($student->updateName($new_student_name)) {
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
    return $app->redirect("/students");
})
->before($is_logged_in)
->before($client_only);
