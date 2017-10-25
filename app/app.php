<?php
    // TODO form validation
    // TODO escape special character function
    // TODO change existing query to prepare
    // TODO authentication using session
    // TODO recreate owner - school relationship
    // TODO add Profile class on Teacher and Clients

    date_default_timezone_set('America/Los_Angeles');
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Student.php";
    require_once __DIR__."/../src/Teacher.php";
    require_once __DIR__."/../src/Course.php";
    require_once __DIR__."/../src/Lesson.php";
    require_once __DIR__."/../src/School.php";
    require_once __DIR__."/../src/Account.php";
    require_once __DIR__."/../src/Image.php";
    require_once __DIR__."/../src/Service.php";
    require_once __DIR__."/../src/Owner.php";
    require_once __DIR__."/../src/function/authentication.php";

    use Herrera\Pdo\PdoServiceProvider;

    session_start();
    if (empty($_SESSION['school_id'])) {
           $_SESSION['school_id'] = null;
    }

    if (empty($_SESSION['teacher_id'])) {
           $_SESSION['teacher_id'] = null;
    }

    if (empty($_SESSION['client_id'])) {
           $_SESSION['client_id'] = null;
    }

    $app = new Silex\Application();

    $app['debug']=true;

    $server = 'mysql:host=localhost:8889;dbname=crm_music';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);
    $GLOBALS['DB']->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // for postgresql
    // $dbopts = parse_url(getenv('DATABASE_URL'));
    // $app->register(new Herrera\Pdo\PdoServiceProvider(),
    // array(
    //     'pdo.dsn' => 'pgsql:dbname='.ltrim($dbopts["path"],'/').';host='.$dbopts["host"] . ';port=' . $dbopts["port"],
    //     'pdo.username' => $dbopts["user"],
    //     'pdo.password' => $dbopts["pass"]
    //     )
    // );
    // $DB = $app['pdo'];

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => [
          __DIR__.'/../web/views',
          __DIR__.'/../web/views/owner',
          __DIR__.'/../web/views/teacher',
          __DIR__.'/../web/views/client',
        ]
    ));

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    //LOGIN
    $app->get("/", function() use ($app) {
        return $app['twig']->render('index.html.twig');
    });

    $app->get("/create_owner", function() use ($app) {
        return $app['twig']->render('create_owner.html.twig');
    });

    //CREATE owner
    $app->post("/create_owner", function() use ($app) {
        // TODO VERIFY
        if ( !empty($_POST['first_name']) && !empty($_POST['last_name']) && !empty($_POST['email_address']) && !empty($_POST['password']) && !empty($_POST['confirm_password']) ) {

            $first_name = $_POST['first_name'];
            $last_name = $_POST['last_name'];
            $email_address = $_POST['email_address'];
            $password = $_POST['password'];
            $role = 'owner';

            $errors = [];

            $owner = Owner::findOwnerByEmailAddress($email_address);

            if (!$owner) {
                $new_owner = new Owner($first_name, $last_name, $email_address, $role);
                $new_owner->createAccount($password);

                if ($new_owner->getId()) {
                    loginOwner($new_owner);
                    return $app->redirect("/create_school");
                } else {
                    return $app->redirect("/create_owner");
                }
            } else {
                $errors[] = "Account already exist";
                return $app['twig']->render(
                    'create_owner.html.twig',
                    array(
                        'errors' => $errors
                    )
                );
            }
        }
    });

    $app->get("/create_school", function() use ($app) {
        if(isLoggedIn()) {
            return $app['twig']->render('create_school.html.twig');
        } else {
            return $app->redirect("/owner_login");
        }
    });

    $app->post("/create_school", function() use ($app) {
        if(isLoggedIn()) {
            $owner_id = $_SESSION['owner_id'];
            $school_name = $_POST['school_name'];
            $manager_name = $_POST['manager_name'];
            $phone_number = $_POST['phone_number'];
            $email = $_POST['email'];
            $business_address = $_POST['business_address'];
            $city = $_POST['city'];
            $state = $_POST['state'];
            $country = $_POST['country'];
            $zip = $_POST['zip'];
            $type = $_POST['type'];

            $new_school = new School($school_name, $manager_name, $phone_number, $email, $business_address, $city, $state, $country, $zip, $type);

            if($new_school->save()) {
                if($new_school->addOwner($owner_id)) {
                    $_SESSION['school_id'] = $new_school->getId();
                    return $app->redirect("/owner_main");
                };
            }
        } else {
            return $app->redirect("/owner_login");
        }
    });

    //READ teachers
    $app->get("/owner_teachers", function() use ($app) {
        if(isLoggedIn()) {

            $school = School::find($_SESSION['school_id']);

            return $app['twig']->render('owner_teachers.html.twig', array('school' => $school, 'teachers' => $school->getTeachers()));
        } else {
            return $app->redirect("/owner_login");
        }
    });




    //CREATE teacher
    $app->post("/owner_teachers", function() use ($app) {
        if (isLoggedIn()) {
            $new_teacher_name = $_POST['teacher_name'] ? $_POST['teacher_name'] : '';
            $new_teacher_instrument = $_POST['teacher_instrument'] ? $_POST['teacher_instrument'] : '';
            // NOTE Carlos changed $_POST['teacher_name'] : '' to $_POST['teacher_instrument'] : ''

            if ($new_teacher_name && $new_teacher_instrument) {
                $school = School::find($_SESSION['school_id']);
                if ($school) {
                    $new_teacher = new Teacher($new_teacher_name, $new_teacher_instrument);
                    $new_teacher->setNotes(date('l jS \of F Y h:i:s A') . " of first entry.");

                    if ($new_teacher->save()) {
                        if ($school->addTeacher($new_teacher->getId())) {
                            // success message
                        } else {
                            //error message
                        }
                    } else {
                        // error message
                    }
                } else {
                    // unknown error
                }
            } else {
                // error message
            }
            return $app->redirect("/owner_teachers");
        } else {
            return $app->redirect("/owner_login");
        }
    });

    // LOGIN
    $app->get("/owner_login", function() use ($app) {
        if(isLoggedIn()) {
            return $app->redirect("/owner_main");
        } else {
            return $app['twig']->render('owner_login.html.twig');
        }
    });

    $app->post("/owner_login", function() use ($app) {
        if(isLoggedIn()) {
            return $app->redirect("/owner_main");
        } else {
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
                        loginOwner($owner);
                        $schools = School::findSchoolsByOwnerId($owner->getId());

                        //TODO for the future changw
                        $_SESSION['school_id'] = $schools[0]->getId();
                        return $app->redirect("/owner_main");
                    } else {
                        $errors[] = "Email or Password didn't match with existing account";
                    }
                } else {
                    $errors[] = "Email or Password didn't match with existing account";
                }
            }
            return $app['twig']->render('owner_login.html.twig', array('errors'=> $errors));
        }
    });

    $app->get("/owner_main", function() use ($app) {
        if(isLoggedIn()) {
            $owner = Owner::findOwnerById($_SESSION['owner_id']);
            if($owner) {
              //TODO FUTURE: if several school exists, show list and choose
              $schools = School::findSchoolsByOwnerId($owner->getId());
              if($schools) {
                  $school = $schools[0];
                  $_SESSION['school_id'] = intval($school->getId());

                  return $app['twig']->render('owner_main.html.twig', array('school'=> $school, 'teachers' => $school->getTeachers(), 'students' => $school->getStudents(), 'courses' => $school->getCourses(), 'accounts' => $school->getAccounts(), 'services' => $school->getServicesForMonth(), 'lessons' => $school->getLessons() ));
              } else {
                  return $app->redirect("/create_school");
              }
            } else {
              //error
            }
        } else {
            // not logged in
            return $app->redirect("/owner_login");
        }
    });

    //READ teacher
    $app->get("/owner_teachers/{teacher_id}", function($teacher_id) use ($app) {
        if (isLoggedIn()) {
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
        } else {
            // not logged in
            return $app->redirect("/owner_login");
        }
    });

    //JOIN teacher with student
    $app->post("/owner_teacher/{teacher_id}/assign", function($teacher_id) use ($app) {
        if (isLoggedIn()) {
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
        } else {
            return $app->redirect("/owner_login");
        }
    });

    //UPDATE teacher notes
    $app->patch("/owner_teachers/{teacher_id}/add_notes", function($teacher_id) use ($app) {
        if(isLoggedIn()) {
            $teacher = Teacher::find($teacher_id);

            $new_notes = $_POST['new_notes'] ? $_POST['new_notes'] : '';
            $updated_notes =  date('l jS \of F Y ') . "---->"  . $new_notes  . "|" .$teacher->getNotes();
            $teacher->updateNotes($updated_notes);

            return $app->redirect("/owner_teachers/" . $teacher_id);
        } else {
            return $app->redirect("/owner_login");
        }
    });

    //DELETE JOIN remove teacher from school
    $app->delete("/owner_teachers/teacher_termination/{teacher_id}", function($teacher_id) use ($app) {
        if (isLoggedIn()) {
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
        } else {
            return $app->redirect("/owner_login");
        }
    });

    //READ students
    $app->get("/owner_students", function() use ($app) {
        if(isLoggedIn()) {
            $school=School::find($_SESSION['school_id']);

            return $app['twig']->render('owner_students.html.twig', array('school' => $school, 'students' => $school->getStudents(), 'teachers' => $school->getTeachers()));
        } else {
          // not logged in
          return $app->redirect("/owner_login");
        }
    });

    //CREATE students
    $app->post("/owner_students", function() use ($app) {
        if(isLoggedIn()) {
            $school=School::find($_SESSION['school_id']);

            $new_student_name = $_POST['student_name'];
            $new_student = new Student($new_student_name);
            $new_student->setNotes(date('l jS \of F Y h:i:s A') . " of first entry.");
            $new_student->save();
            $school->addStudent($new_student->getId());

            return $app['twig']->render('owner_students.html.twig', array('school' => $school, 'students' => $school->getStudents(), 'teachers' => $school->getTeachers()));
        } else {
          // not logged in
          return $app->redirect("/owner_login");
        }
    });

    //READ student NOTE use for family and teacher
    $app->get("/owner_students/{student_id}", function($student_id) use ($app) {
        if (isLoggedIn()) {
            $school = School::find($_SESSION['school_id']);
            $student = Student::find($student_id);

            if ($student) {
              $notes_array = explode("|", $student->getNotes());
              $assigned_teachers = $student->getTeachers();
              $this_month=intval(date('m',strtotime('this month')));
              $this_months_year=intval(date('Y',strtotime('this month')));
              $last_month=intval(date('m',strtotime('last month')));
              $last_months_year=intval(date('Y',strtotime('last month')));

              return $app['twig']->render('owner_student.html.twig', array(
                'school' => $school,
                'student' => $student,
                'assigned_teachers' => $assigned_teachers,
                'notes_array' => $notes_array,
                'courses'=>$school->getCourses(), 'enrolled_courses'=>$student->getCourses(),
                'teachers' => $school->getTeachers(),
                'lessons' => $school->getLessons(),
                'assigned_lessons' => $student->getLessons(),
                'this_month' => $this_month,
                'this_months_year'=>$this_months_year,
                'last_month'=>$last_month,
                'last_months_year'=>$last_months_year
              ));
            } else {
                // student is not found
                return $app->redirect("/owner_students");
            }
        } else {
            return $app->redirect("/owner_login");
        }
    });

    //JOIN student to course
    $app->post("/owner_students/{id}", function($id) use ($app) {
        if(isLoggedIn()) {
            $school=School::find($_SESSION['school_id']);
            $selected_student = Student::find($id);
            $course_id = $_POST['course_id'];
            $selected_student->addCourse($course_id);
            $notes_array = explode("|", $selected_student->getNotes());
            $assigned_teachers = $selected_student->getTeachers();
            $this_month=intval(date('m',strtotime('this month')));
            $this_months_year=intval(date('Y',strtotime('this month')));
            $last_month=intval(date('m',strtotime('last month')));
            $last_months_year=intval(date('Y',strtotime('last month')));
            return $app['twig']->render('owner_student.html.twig', array(
              'school' => $school,
              'student' => $selected_student,
              'assigned_teachers' => $assigned_teachers,
              'notes_array' => $notes_array,
              'courses'=>$school->getCourses(), 'enrolled_courses'=>$selected_student->getCourses(),
              'teachers' => $school->getTeachers(),
              'lessons' => $school->getLessons(),
              'assigned_lessons' => $selected_student->getLessons(),
              'this_month' => $this_month,
              'this_months_year'=>$this_months_year,
              'last_month'=>$last_month,
              'last_months_year'=>$last_months_year));
        } else {
          // not logged in
          return $app->redirect("/owner_login");
        }
    });

    //UPDATE student notes
    $app->patch("/owner_students/{student_id}/add_notes", function($student_id) use ($app) {
        if(isLoggedIn()) {
            $selected_student = Student::find($student_id);
            $new_notes = $_POST['new_notes'] ? $_POST['new_notes'] : '';

            if ($new_notes) {
                $updated_notes =  date('l jS \of F Y ') . "---->"  . $new_notes  . "|" . $selected_student->getNotes();
                $selected_student->updateNotes($updated_notes);
                // add success message
            } else {
              // add error
            }
            return $app->redirect("/owner_students/" . $student_id);
        } else {
            return $app->redirect("/owner_login");
        }
    });

    //UPDATE student service NOTE UNTESTED UNTESTED UNTESTED
    // $app->update("/owner_students/student_student_update_service/{id}, function($id) use($app)" {
    //
    //     $school=School::find($_SESSION['school_id']);
    //     $selected_service = Service::find($id);
    //     $selected_student = $selected_service->getStudents()[0];
    //     $notes_array = explode("|", $selected_student->getNotes());
    //     $assigned_teachers = $selected_student->getTeachers();
    //     $this_month=intval(date('m',strtotime('this month')));
    //     $this_months_year=intval(date('Y',strtotime('this month')));
    //     $last_month=intval(date('m',strtotime('last month')));
    //     $last_months_year=intval(date('Y',strtotime('last month')));
    //
    //     return $app['twig']->render('owner_student.html.twig', array(
    //       'school' => $school,
    //       'student' => $selected_student,
    //       'assigned_teachers' => $assigned_teachers,
    //       'notes_array' => $notes_array,
    //       'courses'=>$school->getCourses(), 'enrolled_courses'=>$selected_student->getCourses(),
    //       'teachers' => $school->getTeachers(),
    //       'lessons' => $school->getLessons(),
    //       'assigned_lessons' => $selected_student->getLessons(),
    //       'this_month' => $this_month,
    //       'this_months_year'=>$this_months_year,
    //       'last_month'=>$last_month,
    //       'last_months_year'=>$last_months_year
    //     ));
    // });

    //DELETE student from school
    $app->delete("/owner_students/student_termination/{id}", function($id) use ($app) {
        if(isLoggedIn()) {
            $school=School::find($_SESSION['school_id']);
            $school->removeStudent($id);

            // NOTE CHECK IF WORKS
            // $student = Student::find($id);
            // $student->delete();

            return $app->redirect("/owner_students");
        } else {
            return $app->redirect("/owner_login");
        }
    });

    // JOIN Add (Schedule) Services to student - from student page
    $app->post('/owner_sessions_for_student', function() use($app) {
        if(isLoggedIn()) {
            $school = School::find($_SESSION['school_id']);
            $student = Student::find($_POST['student_id']);
            $account = Account::find($_POST['account_id']);
            $teacher = Teacher::find($_POST['teacher_id']);
            $notes = "Scheduled on " . date('l jS \of F Y ');
            $this_month=intval(date('m',strtotime('this month')));
            $this_months_year=intval(date('Y',strtotime('this month')));
            $last_month=intval(date('m',strtotime('last month')));
            $last_months_year=intval(date('Y',strtotime('last month')));


            $student->addPrivateSessionBatch($_POST['repetitions'], $_POST['description'], $_POST['duration'], $_POST['price'], $_POST['discount'], $_POST['paid_for'], $notes, $_POST['date_of_service'], $_POST['recurrence'], $_POST['attendance'], $teacher, $school, $account);

            $services = $student->getServices();

            return $app['twig']->render('owner_student_schedule_lessons.html.twig', array('school'=>$school, 'student'=>$student, 'account'=>$account, 'teacher'=>$teacher, 'services'=>$services, 'assigned_teachers'=>$student->getTeachers(),
            'this_month' => $this_month,
            'this_months_year'=>$this_months_year,
            'last_month'=>$last_month,
            'last_months_year'=>$last_months_year));
        } else {
          // not logged in
          return $app->redirect("/owner_login");
        }
    });

    // GET student sessions
    $app->get('/owner_sessions_for_student/{id}', function($id) use($app) {
        if(isLoggedIn()) {
          $school = School::find($_SESSION['school_id']);
          $student = Student::find($id);
          $account = $student->getAccounts()[0];
          $teacher = $student->getTeachers()[0];
          // $date = date('l jS \of F Y '); // TODO incorporate into UI
          $services = $student->getServices();

          return $app['twig']->render('owner_student_schedule_lessons.html.twig', array('school'=>$school, 'student'=>$student, 'account'=>$account, 'teacher'=>$teacher, 'services'=>$services, 'assigned_teachers'=>$student->getTeachers()));
        } else {
          // not logged in
          return $app->redirect("/owner_login");
        }
    });

    // GET session
    $app->get('/owner_sessions/{service_id}', function($service_id) use($app) {
        if (isLoggedIn()) {
            $school = School::find($_SESSION['school_id']);
            $service = Service::find($service_id);

            if ($service) {
                $notes_array = explode("|", $service->getNotes());
                return $app['twig']->render(
                    'owner_session.html.twig', array(
                        'school'=>$school, 'service'=>$service, 'notes_array'=>$notes_array
                    )
                );
            } else {
                // NOTE: which page the user should be redirected to??
                // session is not found
                return $app->redirect("/owner_main");
            }
        } else {
            return $app->redirect("/owner_login");
        }
    });

    // Update session NOTE: NEEDS TO BE CREATED
    $app->patch('/owner_sessions/{id}', function($id) use($app) {
        if(isLoggedIn()) {
            $school = School::find($_SESSION['school_id']);
            $service = Service::find($id);
            $service->updateDateOfService($_POST['date_of_service']);
            $service->updateRecurrence($_POST['recurrence']);
            $service->updateAttendance($_POST['attendance']);
            $service->updateDuration($_POST['duration']);
            $new_notes = $_POST['new_notes'];
            $updated_notes =  date('l jS \of F Y ') . "---->"  . $new_notes  . "|" . $service->getNotes();
            $service->updateNotes($updated_notes);
            $notes_array = explode("|", $updated_notes);

            return $app['twig']->render('owner_session.html.twig', array('school'=>$school, 'service'=>$service, 'notes_array'=>$notes_array));
        } else {
          // not logged in
          return $app->redirect("/owner_login");
        }
    });

    //READ accounts
    $app->get("/owner_accounts", function() use ($app) {
        if(isLoggedIn()) {
            $school = School::find($_SESSION['school_id']);

            return $app['twig']->render('owner_accounts.html.twig', array('school' => $school, 'accounts' => $school->getAccounts()));
        } else {
            return $app->redirect("/owner_login");
        }
    });

    // CREATE account
    $app->post("/owner_accounts", function() use ($app) {
        if (isLoggedIn()) {
            $school = School::find($_SESSION['school_id']);

            $family_name = $_POST['family_name'];
            $parent_one_name = $_POST['parent_one_name'];
            $street_address = $_POST['street_address'];
            $phone_number = $_POST['phone_number'];
            $email_address = $_POST['email_address'];
            $new_account = new Account($family_name, $parent_one_name, $street_address, $phone_number, $email_address);
            $parent_two_name = $_POST['parent_two_name'];
            $notes = $_POST['notes'];
            $notes_array = explode("|", $new_account->getNotes());
            $billing_history = $_POST['billing_history'];
            $outstanding_balance = intval($_POST['outstanding_balance']);
            $new_account->setParentTwoName($parent_two_name);
            $new_account->setNotes($notes);
            $new_account->setBillingHistory($billing_history);
            $new_account->setOutstandingBalance($outstanding_balance);
            $new_account->save();
            $school->addAccount($new_account->getId());

            return $app['twig']->render('owner_accounts.html.twig', array('school' => $school, 'accounts' => $school->getAccounts(), 'notes_array'=>$notes_array));
        } else {
          // not logged in
          return $app->redirect("/owner_login");
        }
    });

    // READ account
    $app->get('/owner_accounts/{account_id}', function($account_id) use ($app) {
        if (isLoggedIn()) {
            $school = School::find($_SESSION['school_id']);
            $account = Account::find($account_id);

            if ($account) {
                $students = $account->getStudents();
                $teachers = $account->getTeachers();
                $courses = $account->getCourses();
                $lessons = $account->getLessons();
                $notes_array = explode("|", $account->getNotes());
                $last_month = intval(date('m',strtotime('last month')));
                $last_months_year = intval(date('Y',strtotime('last month')));

                return $app['twig']->render('owner_account.html.twig', array(
                    'school'=>$school,
                    'account'=>$account,
                    'accounts'=>$school->getAccounts(),
                    'selected_students'=>$students, 'selected_teachers'=>$teachers,
                    'selected_courses'=>$courses,
                    'notes_array'=>$notes_array,
                    'services'=>$account->getServices(),
                    'selected_lessons'=>$lessons,
                    'last_month'=>$last_month,
                    'last_months_year'=>$last_months_year
                ));
            } else {
                // account is not found
                return $app->redirect("/owner_accounts");
            }
        } else {
            return $app->redirect("/owner_login");
        }
    });

    //UPDATE account notes
    $app->patch("/owner_accounts/{account_id}/add_notes", function($account_id) use ($app) {
        if(isLoggedIn()) {
            $selected_account = Account::find($account_id);

            $new_notes = $_POST['new_notes'] ? $_POST['new_notes'] : '';

            if($new_notes) {
                $updated_notes =  date('l jS \of F Y ') . "---->"  . $new_notes  . "|" . $selected_account->getNotes();
                $selected_account->updateNotes($updated_notes);
                // add success message
            } else {
              // add error
            }
            return $app->redirect("/owner_accounts/" . $account_id);
        } else {
            return $app->redirect("/owner_login");
        }
    });

    //search client
    $app->post("/owner_accounts/search", function() use ($app) {
        if (isLoggedIn()) {
            $search_input = $_POST['search_input'] ? $_POST['search_input'] : '';

            if ($search_input) {
                $accounts = Account::search($search_input);

                if ($accounts) {
                    return $app['twig']->render('owner_accounts_search.html.twig', array('accounts' => $accounts));
                } else {
                    // no results
                    // add error message
                }
            } else {
              // input is empty
              // add error message
            }
            return  $app->redirect("/owner_accounts");
        } else {
            return $app->redirect("/owner_login");
        }
    });

    //UPDATE account
    $app->post("/owner_account/{account_id}/update", function($account_id) use ($app) {
        if (isLoggedIn()) {
            $account = Account::find($account_id);

            $family_name = $_POST['family_name'] ? $_POST['family_name'] : '';
            $parent_one_name = $_POST['parent_one_name'] ? $_POST['parent_one_name'] : '';
            $parent_two_name = $_POST['parent_two_name'] ? $_POST['parent_two_name'] : '';
            $street_address = $_POST['street_address'] ? $_POST['street_address'] : '';
            $phone_number = $_POST['phone_number'] ? $_POST['phone_number'] : '';
            $email_address = $_POST['email_address'] ? $_POST['email_address'] : '';

            if ($account->updateFamilyName($family_name) && $account->updateParentOneName($parent_one_name) && $account->updateParentTwoName($parent_two_name) && $account->updateSteetAddress($street_address) && $account->updatePhoneNumber($phone_number) && $account->updateEmailAddress($email_address)) {
                // add success message
                return $app->redirect("/owner_accounts");
            } else {
                // add error message
                return $app->redirect("/owner_accounts");
            }

        } else {
            return $app->redirect("/owner_login");
        }
    });

    //DELETE account
    $app->delete("/owner_account/{account_id}/delete", function($account_id) use ($app) {
        if (isLoggedIn()) {
            $school = School::find($_SESSION['school_id']);
            $account = Account::find($account_id);
            $students = $account->getStudents();

            if ($account->deleteStudents($students)) {

                if ($account->delete()) {
                    // add success message
                    return $app->redirect("/owner_accounts");
                } else {
                    // add error message
                    return $app->redirect("/owner_accounts");
                }
            } else {
                // add error message
                return $app->redirect("/owner_accounts");
            }
        } else {
            return $app->redirect("/owner_login");
        }
    });

    // JOIN add student to account
    $app->post('/owner_add_student_to_account', function() use($app) {
        if (isLoggedIn()) {
            $account_id = $_POST['account_id'] ? $_POST['account_id'] : '';
            $student_name = $_POST['student_name'] ? $_POST['student_name'] : '';

            if ($account_id && $student_name) {
                $selected_account = Account::find($account_id);
                $school = School::find($_SESSION['school_id']);

                if ($selected_account && $school) {
                    $student = new Student($student_name);
                    $student->save();

                    $student_id = $student->getId();
                    $school->addStudent($student_id);

                    $selected_account->addStudent($student_id);

                    return $app->redirect("/owner_accounts/" . $account_id);
                } else {
                  // error message
                  return $app->redirect("/owner_accounts/" . $account_id);
                }
            } else {
                // error message
                return $app->redirect("/owner_accounts/" . $account_id);
            }
        } else {
            return $app->redirect("/owner_login");
        }
    });

    // READ courses
    $app->get("/owner_courses", function() use ($app) {
        if(isLoggedIn()) {
            $school = School::find($_SESSION['school_id']);

            return $app['twig']->render('owner_courses.html.twig', array('school' => $school, 'courses' => $school->getCourses()));
        } else {
            return $app->redirect("/owner_login");
        }
    });

    // CREATE new course
    $app->post("/owner_courses", function() use ($app) {
        if(isLoggedIn()) {
            $school=School::find($_SESSION['school_id']);
            $course_title = $_POST['course_title'];
            $new_course = new Course($course_title);
            $new_course->save();
            $school->addCourse($new_course->getId());
            return $app['twig']->render('owner_courses.html.twig', array('school' => $school, 'courses' => $school->getCourses()));
        } else {
          // not logged in
          return $app->redirect("/owner_login");
        }
    });

    //READ course
    $app->get("/owner_courses/{course_id}", function($course_id) use ($app){
        if (isLoggedIn()) {
            $school = School::find($_SESSION['school_id']);
            $course = Course::find($course_id);

            if ($course) {
                return $app['twig']->render('owner_course.html.twig', array(
                    'school'=> $school,
                    'course' => $course,
                    'courses' => $school->getCourses(),
                    'enrolled_students'=>$course->getStudents(), 'students'=>$school->getStudents(),
                    'lessons' => $course->getLessons()
                ));
            } else {
                // course is not found
                return $app->redirect("/owner_courses");
            }
        } else {
            return $app->redirect("/owner_login");
        }
    });

    $app->post("/owner_courses/{course_id}/update", function($course_id) use ($app) {
        if (isLoggedIn()) {
            $new_title = $_POST['title'] ? $_POST['title'] : '';
            if ($new_title) {
                $course = Course::find($course_id);
                if ($course) {
                    if ($course->updateTitle($new_title)) {
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
            return $app->redirect("/owner_courses");
        } else {
            return $app->redirect("/owner_login");
        }
    });


    //REDIRECT post to course
    $app->post("/owner_courses/redirect", function() use ($app) {
        if(isLoggedIn()) {
            $school=School::find($_SESSION['school_id']);
            $course = Course::find($_POST['course_select']);
            $id = $course->getId();

            return $app['twig']->render('owner_course.html.twig', array(
              'school'=>$school,
              'course' => $course,
              'courses' => $school->getCourses(),
              'enrolled_students'=>$course->getStudents(), 'students'=>$school->getStudents(),
              'lessons' => $school->getLessons() ));
        } else {
          // not logged in
          return $app->redirect("/owner_login");
        }
    });

    $app->delete("/owner_courses/{course_id}/delete", function($course_id) use ($app) {
      if (isLoggedIn()) {
          $school = School::find($_SESSION['school_id']);
          $course = Course::find($course_id);

          if ($course->deleteCourse()) {
              // add success message
              return $app->redirect("/owner_courses");
          } else {
              // add error message
              return $app->redirect("/owner_courses");
          }
      } else {
          return $app->redirect("/owner_login");
      }
    });

    //JOIN add a lesson to a course
    $app->post("/add_lesson_to_course", function() use($app) {
        if (isLoggedIn()) {

            $course_id = $_POST['course_id'] ? $_POST['course_id'] : '';
            $title = $_POST['title'] ? $_POST['title'] : '';
            $description = $_POST['description'] ? $_POST['description'] : '';
            $content = $_POST['content'] ? $_POST['content'] : '';

            $school = School::find($_SESSION['school_id']);
            $course = Course::find($_POST['course_id']);

            $lesson = new Lesson($title, $description, $content);
            $lesson->save();
            $lesson_id = $lesson->getId();
            $school->addLesson($lesson_id);
            $course->addLesson($lesson_id);

            return $app->redirect("/owner_courses/" . $course_id);
        } else {
          // not logged in
          return $app->redirect("/owner_login");
        }
    });
    //JOIN students to course
    $app->post("/owner_courses/{id}", function($id) use ($app){
        if(isLoggedIn()) {
            $school = School::find($_SESSION['school_id']);
            $course = Course::find($id);
            $selected_student = Student::find($_POST['student_id']);

            $selected_student->addCourse($id);

            return $app['twig']->render('owner_course.html.twig', array(
              'school'=>$school,
              'course' => $course,
              'courses' => $school->getCourses(),
              'enrolled_students'=>$course->getStudents(), 'students'=>$school->getStudents(),
              'lessons' => $school->getLessons() ));
        } else {
          // not logged in
          return $app->redirect("/owner_login");
        }
    });

    //CREATE a Lesson NOTE GO BACK TO COURSES THOUGH
    $app->post("/owner_lessons/{id}", function($id) use ($app) {
        if (isLoggedIn()) {
            $school = School::find($_SESSION['school_id']);
            $course = Course::find($id);
            $title = $_POST['title'];
            $description = $_POST['description'];
            $content = $_POST['content'];
            $lesson = new Lesson($title,$description,$content,$input_id);
            $lesson->save();
            $lesson_id = $lesson->getId();
            $course->addLesson($lesson_id);

            return $app['twig']->render('owner_course.html.twig', array(
              'school'=>$school,
              'course' => $course,
              'enrolled_students'=>$course->getStudents(), 'students'=>$school->getStudents(),
              'lessons' => $school->getLessons() ));
        } else {
          // not logged in
          return $app->redirect("/owner_login");
        }
    });

    //READ lesson
    $app->get("/owner_lesson/{lesson_id}", function($lesson_id) use ($app){
        if (isLoggedIn()) {
            $school = School::find($_SESSION['school_id']);
            $lesson = Lesson::find($lesson_id);

            if ($lesson) {
              return $app['twig']->render('owner_lesson.html.twig', array(
                  'school'=>$school,
                  'lesson'=>$lesson
              ));
            } else {
                // lesson is not found
                return $app->redirect("/owner_courses");
            }
        } else {
            return $app->redirect("/owner_login");
        }
    });

    //DELETE Lesson
    $app->delete("/owner_lesson/{lesson_id}/delete", function($lesson_id) use ($app) {
        if (isLoggedIn()) {
            $course_id = $_POST['course_id'] ? $_POST['course_id'] : '';

            if ($course_id) {
                $lesson = Lesson::find($lesson_id);

                if ($lesson->delete()) {
                    // add success message
                    return $app->redirect("/owner_courses/" . $course_id);
                } else {
                    // add error message
                    return $app->redirect("/owner_courses/" . $course_id);
                }
            }
        } else {
            return $app->redirect("/owner_login");
        }
    });

    //UPDATE Lesson
    $app->post("/owner_lesson/{lesson_id}/update", function($lesson_id) use ($app) {
        if (isLoggedIn()) {
            $lesson = Lesson::find($lesson_id);

            $course_id = $_POST['course_id'] ? $_POST['course_id'] : '';
            $title = $_POST['title'] ? $_POST['title'] : '';
            $description = $_POST['description'] ? $_POST['description'] : '';
            $content = $_POST['content'] ? $_POST['content'] : '';

            if ($lesson->updateTitle($title) && $lesson->updateDescription($description) && $lesson->updateContent($content)) {
                // add success message
                return $app->redirect("/owner_courses/" . $course_id);
            } else {
                // add error message
                return $app->redirect("/owner_courses/" . $course_id);
            }

        } else {
            return $app->redirect("/owner_login");
        }
    });

    // TEACHER STORY ROUTES
    // ROOT
    $app->get("/login_teacher", function() use ($app) {
        // NOTE This is going to create the school object from the Login using FIND
        $input_school_name = "SPMS";
        $input_manager_name = "Carlos Munoz Kampff";
        $input_phone_number = "617-780-8362";
        $input_email = "info@starpowermusic.net";
        $input_business_address = "PO 6267";
        $input_city = "Alameda";
        $input_state = "CA";
        $input_country = "USA";
        $input_zip = "94706";
        $input_type = "music";
        $school = new School($input_school_name,$input_manager_name,$input_phone_number,$input_email,$input_business_address,$input_city,$input_state,$input_country,$input_zip,$input_type);
        $school->save();
        $_SESSION['school_id'] = intval($school->getId());

        // NOTE This is going to create the teacher object from the Login using FIND
        $input_name2 = "Stina";
        $input_instrument2 = "Sax";
        $new_teacher2_test = new Teacher($input_name2, $input_instrument2);
        $new_teacher2_test->save();
        $school->addTeacher($new_teacher2_test);
        $_SESSION['teacher_id'] = intval($new_teacher2_test->getId());

        // This directs to teacher main page and sends in keys with values only relating to that school: School Object, teachers, students, courses, accounts, services
        return $app['twig']->render('teacher_main.html.twig', array('school_name'=> $school->getName(), 'teacher' => $teacher, 'students' => $teacher->getStudents(), 'courses' => $teacher->getCourses(), 'services' => $teacher->getServices()));
    });

    //READ student
    $app->get("/teacher_students/{id}", function($id) use($app) {

        $school=School::find($_SESSION['school_id']);
        $teacher=Teacher::find($_SESSION['teacher_id']);
        $student=Student::find($id);

        return $app['twig']->render('teacher_student.html.twig', array('school_name'=>$school->getName(), 'teacher' => $teacher, 'student'=>$student, 'lessons'=>$student->getLessons(), 'courses'=>$student->getCourses(), 'services'=>$student->getServices() ));

    });

    //READ course
    $app->get("/teacher_courses/{id}", function($id) use ($app) {

        $school=School::find($_SESSION['school_id']);
        $teacher=Teacher::find($_SESSION['teacher_id']);
        $course=Course::find($id);
        $lessons=$course->getLessons();

        return $app['twig']->render('teacher_course.html.twig', array('school'=>$school->getName(), 'course'=>$course, 'teacher'=>$teacher, 'course_teachers'=>$course->getTeachers(),'lessons'=> $lessons ));

    });

    // CREATE lesson
    $app->post("/teacher_lessons/{id}", function($id) use ($app) {

        $school=School::find($_SESSION['school_id']);
        $course = Course::find($id);
        $title = $_POST['title'];
        $description = $_POST['description'];
        $content = $_POST['content'];
        $lesson = new Lesson($title,$description,$content,$input_id);
        $lesson->save();
        $lesson_id = $lesson->getId();
        $course->addLesson($lesson_id);
        $teacher->addLesson($lesson_id);
        $lessons=$course->getLessons();

        return $app['twig']->render('teacher_course.html.twig', array('school'=>$school->getName(), 'course'=>$course, 'teacher'=>$teacher, 'course_teachers'=>$course->getTeachers(),'lessons'=> $lessons ));

    });


    // CLIENT STORY ROUTES
    // ROOT
    $app->get("/login_client", function() use ($app) {

        // NOTE This is going to create the school object from the Login using FIND
        $input_school_name = "SPMS";
        $input_manager_name = "Carlos Munoz Kampff";
        $input_phone_number = "617-780-8362";
        $input_email = "info@starpowermusic.net";
        $input_business_address = "PO 6267";
        $input_city = "Alameda";
        $input_state = "CA";
        $input_country = "USA";
        $input_zip = "94706";
        $input_type = "music";
        $school = new School($input_school_name,$input_manager_name,$input_phone_number,$input_email,$input_business_address,$input_city,$input_state,$input_country,$input_zip,$input_type);
        $school->save();
        $_SESSION['school_id'] = intval($school->getId());

        // NOTE This is going to create the client object from the Login using FIND
        $input_family_name = "Bobsters";
        $input_parent_one_name = "Lobster";
        $input_parent_two_name = "Momster";
        $input_street_address = "Under the sea";
        $input_phone_number = "555555555";
        $input_email_address = "fdsfsda@fdasfads";
        $input_notes = "galj";
        $input_billing_history = "fdjfdas";
        $input_outstanding_balance = 31;
        $new_account = new Account($input_family_name, $input_parent_one_name, $input_street_address, $input_phone_number, $input_email_address);
        $new_account->setParentTwoName($input_parent_two_name);
        $new_account->setNotes($input_notes);
        $new_account->setBillingHistory($input_billing_history);
        $new_account->setOutstandingBalance($input_outstanding_balance);

        $new_account->save();
        $school->addAccount($new_account->getId());

        $_SESSION['client_id'] = intval($new_account->getId());

        // This directs to teacher main page and sends in keys with values only relating to that school: School Object, teachers, students, courses, accounts, services
        return $app['twig']->render('client_main.html.twig', array('school_name'=> $school->getName(), 'client' => $new_account, 'students'=>$new_account->getStudents(), 'services'=>$new_account->getServices()));
    });
    //UPDATE service payments
    $app->get("/payments", function() use($app) {

        $school = School::find($_SESSION['school_id']);
        $client = Account::find($_SESSION['client_id']);

        return $app['twig']->render('client_payment', array('school_name'=> $school->getName(), 'client' => $new_account));

    });

    // UPDATE student
    $app->post("/owner_student/{student_id}/update", function($student_id) use ($app) {
        if (isLoggedIn()) {
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
            return $app->redirect("/owner_students");
        } else {
            return $app->redirect("/owner_login");
        }
    });

    $app->post("/owner_teacher/{teacher_id}/update", function($teacher_id) use ($app) {
        if (isLoggedIn()) {
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
        } else {
            return $app->redirect("/owner_login");
        }
    });


    $app->get("logout", function() use ($app) {
        logout();
        return $app->redirect("/");
    });

    return $app;
 ?>
