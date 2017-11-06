<?php
$app->get("/owner_main", function() use ($app) {


    $owner = Owner::findOwnerById($_SESSION['user_id']);

    if ($owner) {
        //TODO FUTURE: if several school exists, show list and choose

        switch($_SESSION['role']) {
            case 'teacher':
                return $app->redirect('/owner_teacher/' . $_SESSION['role_id']);
                break;
            case 'client':
                return $app->redirect('/owner_account/' . $_SESSION['role_id']);
                break;
            default:
                //do nothing
        }

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
->after($save_location_uri);


$app->get("/all_sessions", function() use ($app) {

  $options['month'] = date("m");
  $options['year'] = date("Y");

  // if month & year parameters are passed, update $month and $year
  if (!empty($_GET['month'])) {
      $options['month'] = filter_input(INPUT_GET, 'month', FILTER_VALIDATE_INT);
      if ($options['month'] === false) {
          $options['month'] = date("m");
      }
  }

  if (!empty($_GET['year'])) {
      $options['year'] = filter_input(INPUT_GET, 'year', FILTER_VALIDATE_INT);
      if ($options['year'] === false) {
          $options['year'] = date("Y");
      }
  }

  if (!empty($_GET['teacher'])) {
    $options['teacher'] = $_GET['teacher'];
  }

  if (!empty($_GET['student'])) {
      $options['student'] = $_GET['student'];
  }

  if (!empty($_GET['account'])) {
      $options['account'] = $_GET['account'];
  }

  if (!empty($_GET['attendance'])) {
      $options['attendance'] = $_GET['attendance'];
  }

  if (!empty($_GET['paidFor'])) {
      $options['paidFor'] = $_GET['paidFor'];
  }

  $owner = Owner::findOwnerById($_SESSION['user_id']);
  $datestamp = mktime(0, 0, 0, $options['month'], 1, $options['year']);


  if ($owner) {

      switch($_SESSION['role']) {
          case 'teacher':
              return $app->redirect('/owner_teacher/' . $_SESSION['role_id']);
              break;
          case 'client':
              return $app->redirect('/owner_account/' . $_SESSION['role_id']);
              break;
          default:
              //do nothing
      }

      $schools = School::findSchoolsByOwnerId($owner->getId());

      if ($schools) {
          $school = $schools[0];
          $_SESSION['school_id'] = intval($school->getId());

          return $app['twig']->render('all_sessions_list.html.twig',
              array(
                'role' => $_SESSION['role'],
                'school'=> $school,
                'teachers' => $school->getTeachers(),
                'students' => $school->getStudents(),
                'courses' => $school->getCourses(),
                'accounts' => $school->getAccounts(),
                'services' => $school->getServicesForMonth($options),
                'lessons' => $school->getLessons(),
                'datestamp' => $datestamp
              )
          );
      } else {
          return $app->redirect("/create_school");
      }
    } else {
        return $app->redirect("/owner_login");
    }
});
