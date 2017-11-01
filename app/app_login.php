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

                if ($schools) {
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
                            $_SESSION['role_id'] = $teacher->getId();
                            return $app->redirect('owner_teacher/' . $teacher->getId());
                            break;
                        case 'client':
                            $account = Account::findAccountByUserId($user_id);
                            $_SESSION['role_id'] = $account->getId();
                            return $app->redirect('owner_account/' . $account->getId());
                            break;
                        default:
                            // unexpected case
                            return $app['twig']->render('owner_login.html.twig',
                            array(
                                'role' => $_SESSION['role'],
                                'errors'=> $errors
                            )
                        );
                    }
                } else {
                    $errors[] = "Unexcepted error happened";
                }
            } else {
                $errors[] = "Email or Password didn't match with existing account";
            }
        } else {
            $errors[] = "Email or Password didn't match with existing account";
        }
    }
    return $app['twig']->render('owner_login.html.twig', array('role' => $_SESSION['role'], 'errors'=> $errors));
});
