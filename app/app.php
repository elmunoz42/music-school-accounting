<?php

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

    use Herrera\Pdo\PdoServiceProvider;

    session_start();
    if (empty($_SESSION['school_id']))
    {
           $_SESSION['school_id'] = null;
    }
    if (empty($_SESSION['teacher_id']))
    {
           $_SESSION['teacher_id'] = null;
    }
    if (empty($_SESSION['client_id']))
    {
           $_SESSION['client_id'] = null;
    }

    $app = new Silex\Application();

    $app['debug']=true;

    $server = 'mysql:host=localhost:8889;dbname=crm_music';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

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
        'twig.path' => __DIR__.'/../web/views'
    ));

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();
    //LOGIN
    $app->get("/", function() use ($app) {

        return $app['twig']->render('index.html.twig');

    });

    // OWNER STORY ROUTES
    // ROOT
    $app->get("/owner_login", function() use ($app) {

        // NOTE This is going to create the school object from the Login using FIND
        // $input_school_name = "SPMS";
        // $input_manager_name = "Carlos Munoz Kampff";
        // $input_phone_number = "617-780-8362";
        // $input_email = "info@starpowermusic.net";
        // $input_business_address = "PO 6267";
        // $input_city = "Alameda";
        // $input_state = "CA";
        // $input_country = "USA";
        // $input_zip = "94706";
        // $input_type = "music";
        // $school = new School($input_school_name,$input_manager_name,$input_phone_number,$input_email,$input_business_address,$input_city,$input_state,$input_country,$input_zip,$input_type);
        // $school->save();
        $school = School::find(1); // NOTE placeholder for login
        $_SESSION['school_id'] = intval($school->getId());
        // $school2 = School::find($school->getId());

        // This directs to owner main page and sends in keys with values only relating to that school: School Object, teachers, students, courses, accounts, services
        return $app['twig']->render('owner_main.html.twig', array('school'=> $school, 'teachers' => $school->getTeachers(), 'students' => $school->getStudents(), 'courses' => $school->getCourses(), 'accounts' => $school->getAccounts(), 'services' => $school->getServices(), 'lessons' => $school->getLessons()));
    });

    //READ teachers
    $app->get("/owner_teachers", function() use ($app) {
        $school=School::find($_SESSION['school_id']);

        return $app['twig']->render('owner_teachers.html.twig', array('school' => $school, 'teachers' => $school->getTeachers()));

    });


    //CREATE teacher
    $app->post("/owner_teachers", function() use ($app) {

        $school=School::find($_SESSION['school_id']);

        $new_teacher_name = $_POST['teacher_name'];
        $new_teacher_instrument = $_POST['teacher_instrument'];
        $new_teacher = new Teacher($new_teacher_name, $new_teacher_instrument);
        $new_teacher->setNotes(date('l jS \of F Y h:i:s A') . " of first entry.");
        $new_teacher->save();

        $school->addTeacher($new_teacher->getId());
        return $app['twig']->render('owner_teachers.html.twig', array('school' => $school, 'teachers' => $school->getTeachers()));

    });

    //READ teacher
    $app->get("/owner_teachers/{id}", function($id) use ($app) {

        $school=School::find($_SESSION['school_id']);

        $teacher = Teacher::find($id);
        $courses = $teacher->getCourses();
        $notes_array = explode("|", $teacher->getNotes());
        $students_teachers = $teacher->getStudents();
        return $app['twig']->render('owner_teacher.html.twig', array('school' => $school, 'teacher' => $teacher, 'students_teachers' => $students_teachers, 'notes_array' => $notes_array, 'students' => $school->getStudents(), 'courses' => $courses));
    });

    //JOIN teacher with student
    $app->post("/owner_teachers/{id}", function($id) use ($app) {
        $school=School::find($_SESSION['school_id']);
        $teacher = Teacher::find($id);
        echo $teacher->getName();
        $student = Student::find($_POST['student_id']);
        echo $student->getName();
        $notes_array = explode("|", $teacher->getNotes());
        $teacher->addStudent($_POST['student_id']);
        $students_teachers = $teacher->getStudents();
        var_dump($teacher->getStudents());
        return $app['twig']->render('owner_teacher.html.twig', array('school' => $school, 'teacher' => $teacher, 'students_teachers' => $students_teachers, 'notes_array' => $notes_array, 'students' => $school->getStudents()));
        // return $app->redirect("/owner_teachers/".$id);
    });

    //UPDATE teacher notes
    $app->patch("/owner_teachers/{id}", function($id) use ($app) {

        $school=School::find($_SESSION['school_id']);

        $selected_teacher = Teacher::find($id);
        $new_notes = $_POST['new_notes'];
        $updated_notes =  date('l jS \of F Y ') . "---->"  . $new_notes  . "|" .$selected_teacher->getNotes();
        $selected_teacher->updateNotes($updated_notes);
        $notes_array = explode("|", $updated_notes);
        $students_teachers = $selected_teacher->getStudents();
        return $app['twig']->render('owner_teacher.html.twig', array('school' => $school, 'teacher' => $selected_teacher, 'students_teachers' => $students_teachers,  'notes_array' => $notes_array, 'students' => $school->getStudents()));
    });

    //DELETE JOIN remove teacher from school
    $app->delete("/owner_teachers/teacher_termination/{id}", function($id) use ($app) {

        $school=School::find($_SESSION['school_id']);

        $teacher = Teacher::find($id);
        // refactor to remove teacher from school not entire database
        // $teacher->delete(); NOTE CHECK IF WORKS
        $school->removeTeacher($id);
        return $app['twig']->render('owner_teachers.html.twig', array('school' => $school, 'teachers' => $school->getTeachers()));
    });

    //READ students
    $app->get("/owner_students", function() use ($app) {

        $school=School::find($_SESSION['school_id']);

        return $app['twig']->render('owner_students.html.twig', array('school' => $school, 'students' => $school->getStudents(), 'teachers' => $school->getTeachers()));
    });

    //CREATE students
    $app->post("/owner_students", function() use ($app) {
        $school=School::find($_SESSION['school_id']);

        $new_student_name = $_POST['student_name'];
        $new_student = new Student($new_student_name);
        $new_student->setNotes(date('l jS \of F Y h:i:s A') . " of first entry.");
        $new_student->save();
        $school->addStudent($new_student->getId());

        return $app['twig']->render('owner_students.html.twig', array('school' => $school, 'students' => $school->getStudents(), 'teachers' => $school->getTeachers()));

    });

    //READ student
    $app->get("/owner_students/{id}", function($id) use ($app) {

        $school=School::find($_SESSION['school_id']);
        $selected_student = Student::find($id);
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
            'last_months_year'=>$last_months_year
            ));
    });

    //JOIN student to course
    $app->post("/owner_students/{id}", function($id) use ($app) {

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
    });

    //UPDATE student notes
    $app->patch("/owner_students/{id}", function($id) use ($app) {

        $school=School::find($_SESSION['school_id']);
        $selected_student = Student::find($id);
        $new_notes = $_POST['new_notes'];
        $updated_notes =  date('l jS \of F Y ') . "---->"  . $new_notes  . "|" .$selected_student->getNotes();
        $selected_student->updateNotes($updated_notes);
        $notes_array = explode("|", $updated_notes);
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
        $school=School::find($_SESSION['school_id']);
        $school->removeStudent($id);

        // NOTE CHECK IF WORKS
        // $student = Student::find($id);
        // $student->delete();

        return $app->redirect("/owner_students");
    });

    // JOIN Add (Schedule) Services to student - from student page
    $app->post('/owner_sessions_for_student', function() use($app) {

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

    });

    // GET student sessions
    $app->get('/owner_sessions_for_student/{id}', function($id) use($app) {

        $school = School::find($_SESSION['school_id']);
        $student = Student::find($id);
        $account = $student->getAccounts()[0];
        $teacher = $student->getTeachers()[0];
        // $date = date('l jS \of F Y '); // TODO incorporate into UI
        $services = $student->getServices();

        return $app['twig']->render('owner_student_schedule_lessons.html.twig', array('school'=>$school, 'student'=>$student, 'account'=>$account, 'teacher'=>$teacher, 'services'=>$services, 'assigned_teachers'=>$student->getTeachers()));

    });

    // GET session
    $app->get('/owner_sessions/{id}', function($id) use($app) {

        $school = School::find($_SESSION['school_id']);
        $service = Service::find($id);
        $notes_array = explode("|", $service->getNotes());

        return $app['twig']->render('owner_session.html.twig', array('school'=>$school, 'service'=>$service, 'notes_array'=>$notes_array));

    });

    // Update session NOTE: NEEDS TO BE CREATED
    $app->patch('/owner_sessions/{id}', function($id) use($app) {

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

    });


    //READ accounts
    $app->get("/owner_accounts", function() use ($app) {

        $school=School::find($_SESSION['school_id']);

        return $app['twig']->render('owner_clients.html.twig', array('school' => $school, 'accounts' => $school->getAccounts()));

    });

    // CREATE account
    $app->post("/owner_accounts", function() use ($app) {

        $school=School::find($_SESSION['school_id']);

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
        var_dump($new_account);
        $school->addAccount($new_account->getId());

        return $app['twig']->render('owner_clients.html.twig', array('school' => $school, 'accounts' => $school->getAccounts(), 'notes_array'=>$notes_array));
    });

    // READ account
    $app->get('/owner_accounts/{id}', function($id) use ($app) {

        $school=School::find($_SESSION['school_id']);
        $selected_account = Account::find($id);
        $selected_students = $selected_account->getStudents();
        $selected_teachers = $selected_account->getTeachers();
        $selected_courses = $selected_account->getCourses();
        $selected_lessons = $selected_account->getLessons();
        $notes_array = explode("|", $selected_account->getNotes());
        $last_month = intval(date('m',strtotime('last month')));
        $last_months_year = intval(date('Y',strtotime('last month')));

        return $app['twig']->render('owner_client.html.twig', array('school'=>$school,
        'account'=>$selected_account,
        'accounts'=>$school->getAccounts(),
        'selected_students'=>$selected_students, 'selected_teachers'=>$selected_teachers,
        'selected_courses'=>$selected_courses,
        'notes_array'=>$notes_array,
        'services'=>$selected_account->getServices(),
        'selected_lessons'=>$selected_lessons,
        'last_month'=>$last_month,
        'last_months_year'=>$last_months_year));

    });

    //UPDATE account notes
    $app->patch("/owner_accounts/{id}", function($id) use ($app) {

        $school=School::find($_SESSION['school_id']);

        $selected_account = Account::find($id);
        $selected_students = $selected_account->getStudents();
        $selected_teachers = $selected_account->getTeachers();
        $selected_courses = $selected_account->getCourses();
        $selected_lessons = $selected_account->getLessons();
        $new_notes = $_POST['new_notes'];
        $updated_notes =  date('l jS \of F Y ') . "---->"  . $new_notes  . "|" .$selected_account->getNotes();
        $selected_account->updateNotes($updated_notes);
        $notes_array = explode("|", $updated_notes);

        return $app['twig']->render('owner_client.html.twig', array('school'=>$school,
        'account'=>$selected_account,
        'accounts'=>$school->getAccounts(),
        'selected_students'=>$selected_students, 'selected_teachers'=>$selected_teachers,
        'selected_courses'=>$selected_courses,
        'notes_array'=>$notes_array,
        'selected_lessons'=>$selected_lessons));
    });

    // JOIN add student to account
    $app->post('/owner_add_student_to_account', function() use($app) {
        $school=School::find($_SESSION['school_id']);
        $selected_account = Account::find($_POST['account_id']);
        $student=new Student($_POST['student_name']);
        $student->save();
        $student_id = $student->getId();
        $school->addStudent($student_id);
        $selected_account->addStudent($student_id);
        $notes_array = explode("|", $selected_account->getNotes());
        $selected_students = $selected_account->getStudents();
        $selected_teachers = $selected_account->getTeachers();
        $selected_courses = $selected_account->getCourses();
        $selected_lessons = $selected_account->getLessons();

        return $app['twig']->render('owner_client.html.twig', array('school'=>$school,
        'account'=>$selected_account,
        'accounts'=>$school->getAccounts(),
        'notes_array'=>$notes_array,
        'selected_students'=>$selected_students, 'selected_teachers'=>$selected_teachers,
        'selected_courses'=>$selected_courses,
        'selected_lessons'=>$selected_lessons));
    });

    // READ courses
    $app->get("/owner_courses", function() use ($app) {

        $school=School::find($_SESSION['school_id']);

        return $app['twig']->render('owner_courses.html.twig', array('school' => $school, 'courses' => $school->getCourses()));
    });

    // CREATE new course
    $app->post("/owner_courses", function() use ($app) {

        $school=School::find($_SESSION['school_id']);
        $course_title = $_POST['course_title'];
        $new_course = new Course($course_title);
        $new_course->save();
        $school->addCourse($new_course->getId());
        return $app['twig']->render('owner_courses.html.twig', array('school' => $school, 'courses' => $school->getCourses()));
    });

    //READ course
    $app->get("/owner_courses/{id}", function($id) use ($app){

        $school=School::find($_SESSION['school_id']);
        $course = Course::find($id);


        return $app['twig']->render('owner_course.html.twig', array(
            'school'=>$school,
            'course' => $course,
            'courses' => $school->getCourses(),
            'enrolled_students'=>$course->getStudents(), 'students'=>$school->getStudents(),
            'lessons' => $school->getLessons() ));
    });

    //REDIRECT post to course
    $app->post("/owner_courses/redirect", function() use ($app) {
        $school=School::find($_SESSION['school_id']);
        $course = Course::find($_POST['course_select']);
        $id = $course->getId();

        return $app['twig']->render('owner_course.html.twig', array(
            'school'=>$school,
            'course' => $course,
            'courses' => $school->getCourses(),
            'enrolled_students'=>$course->getStudents(), 'students'=>$school->getStudents(),
            'lessons' => $school->getLessons() ));
    });

    //JOIN add a lesson to a course
    $app->post("/add_lesson_to_course", function() use($app) {
        $school=School::find($_SESSION['school_id']);
        $course = Course::find($_POST['course_id']);
        $title = $_POST['title'];
        $description = $_POST['description'];
        $content = $_POST['content'];
        $lesson = new Lesson($title, $description, $content);
        $lesson->save();
        $lesson_id = $lesson->getId();
        $school->addLesson($lesson_id);
        $course->addLesson($lesson_id);

        return $app['twig']->render('owner_course.html.twig', array(
            'school'=>$school,
            'course' => $course,
            'courses' => $school->getCourses(),
            'enrolled_students'=>$course->getStudents(),
            'students'=>$school->getStudents(),
            'lessons' => $school->getLessons() ));

    });
    //JOIN students to course
    $app->post("/owner_courses/{id}", function($id) use ($app){

        $school=School::find($_SESSION['school_id']);
        $course = Course::find($id);
        $selected_student = Student::find($_POST['student_id']);

        $selected_student->addCourse($id);

        return $app['twig']->render('owner_course.html.twig', array(
            'school'=>$school,
            'course' => $course,
            'courses' => $school->getCourses(),
            'enrolled_students'=>$course->getStudents(), 'students'=>$school->getStudents(),
            'lessons' => $school->getLessons() ));
    });

    //CREATE a Lesson NOTE GO BACK TO COURSES THOUGH
    $app->post("/owner_lessons/{id}", function($id) use ($app) {

        $school=School::find($_SESSION['school_id']);
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

    });

    //READ lesson
    $app->get("/owner_lessons/{id}", function($id) use ($app){
        $school = School::find($_SESSION['school_id']);

        $lesson = Lesson::find($id);

        return $app['twig']->render('owner_lesson.html.twig', array(
            'school'=>$school,
            'lesson'=>$lesson));
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



    return $app;
 ?>
