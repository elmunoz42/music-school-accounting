<?php

// GET student sessions
$app->get('/student/{student_id}/sessions', function($student_id) use($app) {
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
