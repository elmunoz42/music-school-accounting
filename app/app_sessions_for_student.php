<?php

// GET student sessions
$app->get('/owner_sessions_for_student/{id}', function($id) use($app) {
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
    $student = Student::find($id);
    $account = $student->getAccounts()[0];
    $teacher = $student->getTeachers()[0];
    $services = $student->getServicesForMonth($month, $year);
    $datestamp = mktime(0, 0, 0, $month, 1, $year);

    return $app['twig']->render(
        'owner_student_schedule_lessons.html.twig',
        array(
            'student' => $student,
            'account' => $account,
            'services' => $services,
            "datestamp" => $datestamp
        )
    );
})->before($is_logged_in);


// JOIN Add (Schedule) Services to student - from student page
$app->post('/owner_sessions_for_student', function() use($app) {
    $student_id = $_POST['student_id'] ? $_POST['student_id'] : "";
    $account_id = $_POST['account_id'] ? $_POST['account_id'] : "";
    $teacher_id = $_POST['teacher_id'] ? $_POST['teacher_id'] : "";
    $repetitions = $_POST['repetitions'] ? $_POST['repetitions'] : "0";
    $description = $_POST['description'] ? $_POST['description'] : "";
    $duration = $_POST['duration'] ? $_POST['duration'] : "";
    $price = $_POST['price'] ? $_POST['price'] : "";
    $discount = $_POST['discount'] ? $_POST['discount'] : "";
    $paid_for = $_POST['paid_for'] === "1" ? "1" : "0";
    $date_of_service = $_POST['date_of_service'] ? $_POST['date_of_service'] : "";
    $recurrence = $_POST['recurrence'] ? $_POST['recurrence'] : "";
    $attendance = $_POST['attendance'] ? $_POST['attendance'] : "";

    $is_all_form_filled = $student_id && $account_id && $teacher_id && isset($repetitions) && $description && $price && $discount && isset($paid_for) && $date_of_service && $recurrence && $attendance;

    if ($is_all_form_filled) {
        $school = School::find($_SESSION['school_id']);
        $student = Student::find($student_id);
        $account = Account::find($account_id);
        $teacher = Teacher::find($teacher_id);

        $this_month = intval(date('m',strtotime('this month')));
        $this_months_year = intval(date('Y',strtotime('this month')));
        $last_month = intval(date('m',strtotime('last month')));
        $last_months_year = intval(date('Y',strtotime('last month')));

        if ($student->addPrivateSessionBatch(
            $repetitions,
            $description,
            $duration,
            $price,
            $discount,
            $paid_for,
            $date_of_service,
            $recurrence,
            $attendance,
            $teacher,
            $school,
            $account
        )) {
            // add success message
        } else {
            // add error message
        }
    } else {
      // add error message
    }

    return $app->redirect("/owner_students/" . $student_id);
})->before($is_logged_in);
