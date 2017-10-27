<?php

//READ teacher
$app->get("/owner_teachers/{teacher_id}", function($teacher_id) use ($app) {
    $school = School::find($_SESSION['school_id']);
    $teacher = Teacher::find($teacher_id);

    if ($teacher) {
        $courses = $teacher->getCourses();
        $notes_array = explode("|", $teacher->getNotes());
        $students_teachers = $teacher->getStudents();

        return $app['twig']->render('owner_teacher.html.twig', array('school' => $school, 'teacher' => $teacher, 'students_teachers' => $students_teachers, 'notes_array' => $notes_array, 'students' => $school->getStudents(), 'courses' => $courses));
    } else {
      // teacher is not found
      return $app->redirect("/owner_teachers");
    }
})->before($is_logged_in);


//JOIN teacher with student
$app->post("/owner_teacher/{teacher_id}/assign", function($teacher_id) use ($app) {
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
        return $app->redirect("/owner_teachers/" . $teacher_id);
    }
})->before($is_logged_in);


//UPDATE teacher notes
$app->patch("/owner_teachers/{teacher_id}/add_notes", function($teacher_id) use ($app) {
    $teacher = Teacher::find($teacher_id);

    $new_notes = $_POST['new_notes'] ? $_POST['new_notes'] : '';
    $updated_notes =  date('l jS \of F Y ') . "---->"  . $new_notes  . "|" .$teacher->getNotes();
    $teacher->updateNotes($updated_notes);

    return $app->redirect("/owner_teachers/" . $teacher_id);
})->before($is_logged_in);

//DELETE JOIN remove teacher from school
$app->delete("/owner_teachers/teacher_termination/{teacher_id}", function($teacher_id) use ($app) {
    $school = School::find($_SESSION['school_id']);
    $teacher = Teacher::find($teacher_id);

    // refactor to remove teacher from school not entire database
    // $teacher->delete(); NOTE CHECK IF WORKS
    if ($school->removeTeacher($teacher_id)) {
        // add success message
        return $app->redirect("/owner_teachers");
    } else {
        // add error message
        return $app->redirect("/owner_teachers");
    }
})->before($is_logged_in);



$app->post("/owner_teacher/{teacher_id}/update", function($teacher_id) use ($app) {
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
    return $app->redirect("/owner_teachers");
});
