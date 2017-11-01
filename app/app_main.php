<?php
$app->get("/owner_main", function() use ($app) {
    $owner = Owner::findOwnerById($_SESSION['user_id']);
    if($owner) {
      //TODO FUTURE: if several school exists, show list and choose

      $schools = School::findSchoolsByOwnerId($owner->getId());

      if ($schools) {
          $school = $schools[0];
          $_SESSION['school_id'] = intval($school->getId());

          return $app['twig']->render('owner_main.html.twig',
              array(
                'role' => $_SESSION['role'],
                'school'=> $school,
                'teachers' => $school->getTeachers(),
                'students' => $school->getStudents(),
                'courses' => $school->getCourses(),
                'accounts' => $school->getAccounts(),
                'services' => $school->getServicesForMonth(),
                'lessons' => $school->getLessons()
              )
          );
      } else {
          return $app->redirect("/create_school");
      }
    } else {
        return $app->redirect("/owner_login");
    }
})
->before($is_logged_in)
->before($owner_only)
->after($save_location_uri);
