<?php

// LOGIN
$app->get("/owner_login", function() use ($app) {

    if (isLoggedIn()){
        $role = $_SESSION['role'];
        $user_id = $_SESSION['user_id'];

        switch($role) {
            case 'owner':
                return $app->redirect('owner_main');
                break;
            case 'teacher':
                return $app->redirect('owner_teacher/' . $user_id);
                break;
            case 'client':
                return $app->redirect('owner_teacher/' . $user_id);
                break;
            default:
                // unexpected case
                return $app['twig']->render('owner_login.html.twig', array('errors'=> $errors));
        }
    }
    return $app['twig']->render('owner_login.html.twig', array('errors'=> $errors));
});

$app->post("/owner_login", function() use ($app) {
    $errors = [];
    $email_address = isset($_POST['email_address']) ? $_POST['email_address'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    if (!$email_address) {
        $errors[] = "Username cannot be blank.";
    }

    if (!$password) {
      $errors[] = "Password cannot be blank";
    }

    if (empty($errors)) {
        $owner = Owner::findOwnerByEmailAddress($email_address);

        if ($owner) {
            if (password_verify($password, $owner->getPassword())) {


                $schools = School::findSchoolsByOwnerId($owner->getId());

                $_SESSION['school_id'] = $schools[0]->getId();
                $_SESSION['user_id'] = $owner->getId();
                $_SESSION['role'] = $owner->getRole();

                $user_id = $_SESSION['user_id'];
                $role = $_SESSION['role'];

                switch($role) {
                    case 'owner':
                        return $app->redirect('owner_main');
                        break;
                    case 'teacher':
                        $teacher = Teacher::findTeacherByUserId($user_id);
                        return $app->redirect('owner_teacher/' . $teacher->getId());
                        break;
                    case 'client':
                        $account = Account::findAccountByUserId($user_id);
                        return $app->redirect('owner_account/' . $account->getId());
                        break;
                    default:
                        // unexpected case
                        return $app['twig']->render('owner_login.html.twig', array('errors'=> $errors));
                }

            } else {
                $errors[] = "Email or Password didn't match with existing account";
            }
        } else {
            $errors[] = "Email or Password didn't match with existing account";
        }
    }
    return $app['twig']->render('owner_login.html.twig', array('errors'=> $errors));
});


//
//
// // TEACHER STORY ROUTES
// // ROOT
// $app->get("/login_teacher", function() use ($app) {
//     // NOTE This is going to create the school object from the Login using FIND
//     $input_school_name = "SPMS";
//     $input_manager_name = "Carlos Munoz Kampff";
//     $input_phone_number = "617-780-8362";
//     $input_email = "info@starpowermusic.net";
//     $input_business_address = "PO 6267";
//     $input_city = "Alameda";
//     $input_state = "CA";
//     $input_country = "USA";
//     $input_zip = "94706";
//     $input_type = "music";
//     $school = new School($input_school_name,$input_manager_name,$input_phone_number,$input_email,$input_business_address,$input_city,$input_state,$input_country,$input_zip,$input_type);
//     $school->save();
//     $_SESSION['school_id'] = intval($school->getId());
//
//     // NOTE This is going to create the teacher object from the Login using FIND
//     $input_name2 = "Stina";
//     $input_instrument2 = "Sax";
//     $new_teacher2_test = new Teacher($input_name2, $input_instrument2);
//     $new_teacher2_test->save();
//     $school->addTeacher($new_teacher2_test);
//     $_SESSION['teacher_id'] = intval($new_teacher2_test->getId());
//
//     // This directs to teacher main page and sends in keys with values only relating to that school: School Object, teachers, students, courses, accounts, services
//     return $app['twig']->render('teacher_main.html.twig', array('school_name'=> $school->getName(), 'teacher' => $teacher, 'students' => $teacher->getStudents(), 'courses' => $teacher->getCourses(), 'services' => $teacher->getServices()));
// });



// CLIENT STORY ROUTES
// ROOT
// $app->get("/login_client", function() use ($app) {
//
//     // NOTE This is going to create the school object from the Login using FIND
//     $input_school_name = "SPMS";
//     $input_manager_name = "Carlos Munoz Kampff";
//     $input_phone_number = "617-780-8362";
//     $input_email = "info@starpowermusic.net";
//     $input_business_address = "PO 6267";
//     $input_city = "Alameda";
//     $input_state = "CA";
//     $input_country = "USA";
//     $input_zip = "94706";
//     $input_type = "music";
//     $school = new School($input_school_name,$input_manager_name,$input_phone_number,$input_email,$input_business_address,$input_city,$input_state,$input_country,$input_zip,$input_type);
//     $school->save();
//     $_SESSION['school_id'] = intval($school->getId());
//
//     // NOTE This is going to create the client object from the Login using FIND
//     $input_family_name = "Bobsters";
//     $input_parent_one_name = "Lobster";
//     $input_parent_two_name = "Momster";
//     $input_street_address = "Under the sea";
//     $input_phone_number = "555555555";
//     $input_email_address = "fdsfsda@fdasfads";
//     $input_notes = "galj";
//     $input_billing_history = "fdjfdas";
//     $input_outstanding_balance = 31;
//     $new_account = new Account($input_family_name, $input_parent_one_name, $input_street_address, $input_phone_number, $input_email_address);
//     $new_account->setParentTwoName($input_parent_two_name);
//     $new_account->setNotes($input_notes);
//     $new_account->setBillingHistory($input_billing_history);
//     $new_account->setOutstandingBalance($input_outstanding_balance);
//
//     $new_account->save();
//     $school->addAccount($new_account->getId());
//
//     $_SESSION['client_id'] = intval($new_account->getId());
//
//     // This directs to teacher main page and sends in keys with values only relating to that school: School Object, teachers, students, courses, accounts, services
//     return $app['twig']->render('client_main.html.twig', array('school_name'=> $school->getName(), 'client' => $new_account, 'students'=>$new_account->getStudents(), 'services'=>$new_account->getServices()));
// });
