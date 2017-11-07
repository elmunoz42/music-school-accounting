<?php

//READ teacher
$app->get("/teacher/{teacher_id}", function($teacher_id) use ($app) {

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
    $teacher = Teacher::find($teacher_id);

    if ($teacher) {
        $all_courses = $school->getCourses();
        $courses = $teacher->getCourses();
        $notes_array = explode("|", $teacher->getNotes());
        $students_teachers = $teacher->getStudents();
        $datestamp = mktime(0, 0, 0, $month, 1, $year);
        $services = $teacher->getServicesForMonth($month, $year);

        return $app['twig']->render('teacher.html.twig',
            array(
                'role' => $_SESSION['role'],
                'school' => $school,
                'teacher' => $teacher,
                'students_teachers' => $students_teachers,
                'notes_array' => $notes_array,
                'students' => $school->getStudents(),
                'all_courses' => $all_courses,
                'courses' => $teacher->getCourses(),
                'services' => $services,
                'datestamp' => $datestamp
            )
        );
    } else {
      // teacher is not found
      return $app->redirect("/teachers");
    }
})
->before($is_logged_in)
->after($save_location_uri);


//JOIN teacher with student
$app->post("/teacher/{teacher_id}/assign", function($teacher_id) use ($app) {
    $student_id = $_POST['student_id'] ? $_POST['student_id'] : '';

    if ($student_id) {

        $teacher = Teacher::find($teacher_id);
        $student = $teacher->findStudentById($student_id);

        if (!$student) {
            if ($teacher->addStudent($student_id)) {
              // add success message
            } else {
              // add error message
            }
        } else {
            // already assigned
            // add error message
        }
        return $app->redirect("/teacher/" . $teacher_id);
    }
})
->before($is_logged_in)
->before($teacher_only);


//UPDATE teacher notes
$app->patch("/teacher/{teacher_id}/add_notes", function($teacher_id) use ($app) {
    $teacher = Teacher::find($teacher_id);

    $new_notes = $_POST['new_notes'] ? $_POST['new_notes'] : '';
    $updated_notes =  date('l jS \of F Y ') . "---->"  . $new_notes  . "|" .$teacher->getNotes();
    $teacher->updateNotes($updated_notes);

    return $app->redirect("/teacher/" . $teacher_id);
})
->before($is_logged_in)
->before($teacher_only);


//DELETE JOIN remove teacher from school
$app->delete("/teacher/teacher_termination/{teacher_id}", function($teacher_id) use ($app) {
    $school = School::find($_SESSION['school_id']);
    $teacher = Teacher::find($teacher_id);

    // refactor to remove teacher from school not entire database
    // $teacher->delete(); NOTE CHECK IF WORKS
    if ($school->removeTeacher($teacher_id)) {
        // add success message
        return $app->redirect("/teachers");
    } else {
        // add error message
        return $app->redirect("/teachers");
    }
})
->before($is_logged_in)
->before($owner_only);


// update teacher info
$app->post("/teacher/{teacher_id}/update", function($teacher_id) use ($app) {
    $new_teacher_name = $_POST['teacher_name'] ? $_POST['teacher_name'] : '';
    $new_instrument = $_POST['instrument'] ? $_POST['instrument'] : '';

    if ($new_teacher_name && $new_instrument) {
        $teacher = Teacher::find($teacher_id);
        if ($teacher) {
            if ($teacher->updateName($new_teacher_name) && $teacher->updateInstrument($new_instrument)) {
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
    return $app->redirect("/teachers");
})
->before($is_logged_in)
->before($teacher_only);


//JOIN teacher to course
$app->post("/teacher/{teacher_id}/enroll", function($teacher_id) use ($app) {
    $course_id = $_POST['course_id'] ? $_POST['course_id'] : '';

    if ($course_id) {
        $teacher = Teacher::find($teacher_id);
        $course = $teacher->findCourseById($course_id);

        if (!$course) {
            if ($teacher->addCourse($course_id)) {
                //add success message
            } else {
                // add error message
            }
        } else {
            // already enrolled
            // add error message
        }
    }
    return $app->redirect("/teacher/" . $teacher_id);
})
->before($is_logged_in)
->before($only_teacher);
