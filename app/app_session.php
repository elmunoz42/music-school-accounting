<?php

// GET session
$app->get('/owner_session/{service_id}', function($service_id) use($app) {
    $school = School::find($_SESSION['school_id']);
    $service = Service::find($service_id);

    if ($service) {
        $notes_array = explode("|", $service->getNotes());
        return $app['twig']->render(
            'owner_session.html.twig', array(
                'role' => $_SESSION['role'],
                'school'=>$school,
                'service'=>$service,
                'notes_array'=>$notes_array
            )
        );
    } else {
        // NOTE: which page the user should be redirected to??
        // session is not found
        return $app->redirect("/owner_main");
    }
})
->before($is_logged_in)
->after($save_location_uri);


// Update session NOTE: NEEDS TO BE CREATED
$app->patch('/owner_session/{service_id}/update', function($service_id) use($app) {

    $service = Service::find($service_id);
    $student_id = $_POST['student_id'] ? $_POST['student_id'] : '';

    $date_of_service = $_POST['date_of_service'] ? $_POST['date_of_service'] : '';
    $teacher_id = $_POST['teacher_id'] ? $_POST['teacher_id'] : '';
    $description = $_POST['description'] ? $_POST['description'] : '';
    $repetitions = $_POST['repetitions'] ? $_POST['repetitions'] : '';
    $price = $_POST['price'] ? $_POST['price'] : '';
    $discount = $_POST['discount'] ? $_POST['discount'] : '';
    $start_date = $_POST['start_date'] ? $_POST['start_date'] : '';
    $start_time = $_POST['start_time'] ? $_POST['start_time'] : '';
    $recurrence = $_POST['recurrence'] ? $_POST['recurrence'] : '';
    $attendance = $_POST['attendance'] ? $_POST['attendance'] : '';
    $duration = $_POST['duration'] ? $_POST['duration'] : '';
    $new_notes = $_POST['note'] ? $_POST['note'] : '';


    $date_of_service = '';
    if ($start_date && $start_time) {
      // concatanate and create date format
      $date_of_service = date("Y-m-d", strtotime($start_date)) . 'T' . $start_time;
    }

    if ($service) {
      if (isset($date_of_service) && $date_of_service != $service->getDateOfService()) {
        $service->updateDateOfService($date_of_service);
      }

      if (isset($repetitions) && $repetitions != $service->getDateOfService()) {
        $service->updateDateOfService($date_of_service);
      }
      if (!empty($description) && ($description != $service->getDescription())) $service->updateDescription($description);
      if (!empty($price) && $price != $service->getPrice()) $service->updatePrice($price);
      if (!empty($discount) && $discount != $service->getDiscount()) $service->updateDiscount($discount);
      if (!empty($recurrence) && $recurrence != $service->getRecurrence()) $service->updateRecurrence($recurrence);
      if (!empty($attendance) && $attendance != $service->getAttendance()) $service->updateAttendance($attendance);
      if (!empty($duration) && $duration != $service->getDuration()) $service->updateDuration($duration);
      if (!empty($new_notes)) {
        // $updated_notes =  date('l jS \of F Y ') . "---->"  . $new_notes  . "|" . $service->getNotes();
        $updated_notes =  date('y-m-d') . ': '  . $new_notes;
        $service->updateNotes($updated_notes);
      }
    }

    if ($student_id) {
      return $app->redirect("/owner_student/" . $student_id);
    } else {
      return $app->redirect("/owner_main");
    }

})
->before($is_logged_in)
->before($teacher_only);


// AJAX: Update paid_for status
$app->post('/owner_session_update_paid_for', function() use($app) {
    $paid_status = $_POST['paid_status'];
    $service_id = (int)$_POST['service_id'];
    $service = Service::find($service_id);

    if ($paid_status === "true") {
        $paid_status = "false";
        $service->updatePaidFor("0");
    } else {
        $paid_status = "true";
        $service->updatePaidFor("1");
    }
    return $app->json($paid_status);
})
->before($is_logged_in)
->before($owner_only);



// JOIN Add (Schedule) Services to student - from student page
$app->post('/student/{student_id}/add_session', function($student_id) use($app) {
    $student_id = $_POST['student_id'] ? $_POST['student_id'] : "";
    $account_id = $_POST['account_id'] ? $_POST['account_id'] : "";
    $teacher_id = $_POST['teacher_id'] ? $_POST['teacher_id'] : "";
    $repetitions = $_POST['repetitions'] ? $_POST['repetitions'] : "0";
    $description = $_POST['description'] ? $_POST['description'] : "";
    $duration = $_POST['duration'] ? $_POST['duration'] : "";
    $price = $_POST['price'] ? $_POST['price'] : "";
    $discount = $_POST['discount'] ? $_POST['discount'] : "";
    $paid_for =  "0";
    $start_date = $_POST['start_date'] ? $_POST['start_date'] : '';
    $start_time = $_POST['start_time'] ? $_POST['start_time'] : '';
    $recurrence = $_POST['recurrence'] ? $_POST['recurrence'] : "";
    $attendance = $_POST['attendance'] ? $_POST['attendance'] : "";

    $date_of_service = '';

    if ($start_date && $start_time) {
      // concatanate and create date format
      $date_of_service = date("Y-m-d", strtotime($start_date)) . 'T' . $start_time;
    }

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

    return $app->redirect("/owner_student/" . $student_id);
})
->before($is_logged_in)
->before($teacher_only);
