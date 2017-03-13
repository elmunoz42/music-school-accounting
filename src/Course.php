<?php

    class   Course
    {
        private $title;
        private $id;

        function __construct($title, $id = Null )
        {
            $this->title = $title;
            $this->id = $id;
        }

        // getters and setters
        function setTitle($new_title)
        {
            $this->title = $new_title;
        }

        function getTitle()
        {
            return $this->title;
        }

        function getId()
        {
            return $this->id;
        }

        // CRUD
        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO courses (title) VALUES ('{$this->getTitle()}');");

            $this->id = $GLOBALS['DB']->LastInsertId();
        }

        static function getAll()
        {
            $returned_courses = $GLOBALS['DB']->query("SELECT * FROM courses;");
            $courses = array();
            foreach( $returned_courses as $course)
            {
                $new_title = $course['title'];
                $new_id = $course['id'];
                $new_course = new Course($new_title, $new_id);
                array_push($courses, $new_course);
            }
            return $courses;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM courses");
        }

        function update($new_title)
        {
            $GLOBALS['DB']->exec("UPDATE courses SET title = '{$new_title}';");

            $this->setTitle($new_title);

        }

        static function find($search_id)
        {
            $query = $GLOBALS['DB']->query("SELECT * FROM courses WHERE id = {$search_id};");
            $courses = array();
            foreach( $query as $course){
                $id = $course['id'];
                $title = $course['title'];
                $found_course = new Course($title, $id);
            }
            return $found_course;
        }

        function deleteCourse()
        {
            $GLOBALS['DB']->exec("DELETE FROM courses WHERE id = '{$this->getId()}';");
        }

        // NOTE UNTESTED
        function addTeacher($teacher_id)
        {
            $GLOBALS['DB']->exec("INSERT INTO courses_teachers (course_id, teacher_id) VALUES ({$this->getId()}, {$teacher_id});");
        }
        // NOTE UNTESTED
        function addStudent($student_id)
        {
            $GLOBALS['DB']->exec("INSERT INTO courses_students (course_id, student_id) VALUES ({$this->getId()}, {$student_id});");
        }
        // NOTE UNTESTED
        function addAccount($account_id)
        {
            $GLOBALS['DB']->exec("INSERT INTO accounts_courses (course_id, account_id) VALUES ({$this->getId()}, {$account_id});");
        }
        // NOTE UNTESTED
        function addLesson($lesson_id)
        {
            $GLOBALS['DB']->exec("INSERT INTO courses_lessons (course_id, lesson_id) VALUES ({$this->getId()}, {$lesson_id});");
        }
        // NOTE UNTESTED
        function addService($service_id)
        {
            $GLOBALS['DB']->exec("INSERT INTO courses_services (course_id, service_id) VALUES ({$this->getId()}, {$service_id})");
        }
        // NOTE UNTESTED
        function getAccounts()
        {
            $query = $GLOBALS['DB']->query("SELECT accounts.* FROM courses JOIN accounts_courses ON (courses.id = accounts_courses.course_id) JOIN accounts ON (accounts_courses.account_id = accounts.id) WHERE courses.id = {$this->getId()};");
            $accounts = array();
            foreach ($query as $account)
            {
                $id = $account['id'];
                $family_name = $account['family_name'];
                $parent_one_name = $account['parent_one_name'];
                $parent_two_name = $account['parent_two_name'];
                $street_address = $account['street_address'];
                $phone_number = $account['phone_number'];
                $email_address = $account['email_address'];
                $notes = $account['notes'];
                $billing_history = $account['billing_history'];
                $outstanding_balance = intval($account['outstanding_balance']);
                $new_account = new Account($family_name, $parent_one_name,  $street_address, $phone_number, $email_address, $id);
                $new_account->setParentTwoName($parent_two_name);
                $new_account->setNotes($notes);
                $new_account->setBillingHistory($billing_history);
                $new_account->setOutstandingBalance($outstanding_balance);
                array_push($accounts, $new_account);
            }
            return $accounts;
        }
        // NOTE UNTESTED
        function getStudents()
        {
            $students = $GLOBALS['DB']->query("SELECT students.* FROM
            courses  JOIN courses_students ON (courses.id = courses_students.course_id)
                    JOIN students ON ( courses_students.student_id = students.id)
            WHERE courses.id = {$this->getId()};");

            $return_students = array();
            foreach($students as $student){
                $id = $student['id'];
                $student_name = $student['student_name'];
                $notes = $student['notes'];
                $new_student = new Student($student_name, $id);
                $new_student->setNotes($notes);
                array_push($return_students, $new_student);
            }
            return $return_students;
        }

        // NOTE UNTESTED
        function getTeachers()
        {
            $query = $GLOBALS['DB']->query("SELECT teachers.* FROM courses JOIN courses_teachers ON (courses.id = courses_teachers.course_id) JOIN teachers ON (courses_teachers.teacher_id = teachers.id) WHERE courses.id = {$this->getId()};");
            $teachers = array();
            foreach ($query as $teacher) {
                $teacher_name = $teacher['teacher_name'];
                $instrument = $teacher['instrument'];
                $notes= $teacher['notes'];
                $id = $teacher['id'];
                $found_teacher = new Teacher($teacher_name, $instrument, $id);
                $found_teacher->setNotes($notes);
                array_push($teachers, $found_teacher);
            }
            return $teachers;
        }
        // NOTE UNTESTED
        function getLessons()
        {
            $query = $GLOBALS['DB']->query("SELECT lessons.* FROM courses JOIN courses_lessons ON (courses.id = courses_lessons.course_id) JOIN lessons ON (courses_lessons.lesson_id = lessons.id) WHERE courses.id = {$this->getId()};");
            $lessons = array();
            foreach ($query as $lesson )
            {
                $title = $lesson['title'];
                $description = $lesson['description'];
                $content = $lesson['content'];
                $id = $lesson['id'];
                $returned_lesson = new Lesson($title, $description, $content, $id);
                array_push($lessons, $returned_lesson);
            }
            return $lessons;
        }

    }
 ?>
