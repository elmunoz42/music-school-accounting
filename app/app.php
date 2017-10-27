<?php
    date_default_timezone_set('America/Los_Angeles');
    require_once __DIR__."/../vendor/autoload.php";

    use Herrera\Pdo\PdoServiceProvider;
    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    $app = new Silex\Application();
    $app['debug'] = true;
    $app->register(new Silex\Provider\TwigServiceProvider(), array(
      'twig.path' => [
        __DIR__.'/../web/views',
        __DIR__.'/../web/views/owner',
        __DIR__.'/../web/views/teacher',
        __DIR__.'/../web/views/client',
        ]
      ));

    // load Class
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

    // load general setting
    require_once __DIR__.'/./db_setup.php';
    require_once __DIR__.'/./session.php';
    require_once __DIR__.'/./verify.php';


    // load routing
    require_once __DIR__."/./app_account.php";
    require_once __DIR__."/./app_accounts.php";
    require_once __DIR__."/./app_course.php";
    require_once __DIR__."/./app_courses.php";
    require_once __DIR__."/./app_create_school.php";
    require_once __DIR__."/./app_create_user.php";
    require_once __DIR__."/./app_index.php";
    require_once __DIR__."/./app_lesson.php";
    require_once __DIR__."/./app_login.php";
    require_once __DIR__."/./app_main.php";
    require_once __DIR__."/./app_payment.php";
    require_once __DIR__."/./app_session.php";
    require_once __DIR__."/./app_sessions.php";
    require_once __DIR__."/./app_student.php";
    require_once __DIR__."/./app_students.php";
    require_once __DIR__."/./app_teacher.php";
    require_once __DIR__."/./app_teachers.php";

    return $app;
