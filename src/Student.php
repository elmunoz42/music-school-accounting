<?php
    class Student
    {
        private $student_name;
        private $notes;
        private $id;

        function __construct($student_name, $id = null)
        {
            $this->student_name = $student_name;
            $this->id = (Int)$id;
        }

        function setName($new_student_name)
        {
            $this->name = (string) $new_student_name;
        }

        function getName()
        {
            return $this->student_name;
        }

        function setNotes($new_note)
        {
            $this->notes = $new_note . $this->notes;

        }

        function getNotes()
        {
            return $this->notes;
        }

        function getId()
        {
            return $this->id;
        }

        function save()
        {

          $GLOBALS['DB']->exec("INSERT INTO students (student_name, notes) VALUES ('{$this->getName()}', '{$this->getNotes()}');");
          $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM students;");

        }

        static function deleteJoin()
        {
            $GLOBALS['DB']->exec("DELETE FROM students_courses;");
            $GLOBALS['DB']->exec("DELETE FROM services_students;");
        }

        static function getAll()
        {
            $returned_students = $GLOBALS['DB']->query("SELECT * FROM students;");
            $students = array();
            foreach($returned_students as $student){
                $name = $student['student_name'];
                $notes = $student['notes'];
                $id = $student['id'];
                $new_student = new Student($name, $id);
                $new_student->setNotes($notes);
                array_push($students, $new_student);

          }
          return $students;
        }

        function updateNotes($new_note)
        {
            $GLOBALS['DB']->exec("UPDATE students SET notes = '{$new_note}' WHERE id = {$this->getId()};");
            $this->setNotes($new_note);
        }

        function updateName($student_name)
        {
            $stmt = $GLOBALS['DB']->prepare("UPDATE students SET student_name = :student_name WHERE id = :id");
            $stmt->bindParam(':student_name', $student_name, PDO::PARAM_STR);
            $stmt->bindParam(':id', $this->getId(), PDO::PARAM_STR);
            return $stmt->execute();
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM students WHERE id = {$this->getId()};");
        }

        static function find($search_id)
        {
           $found_student = null;
           $students = Student::getAll();
           foreach($students as $student){
               $student_id = $student->getId();
               if ( $student_id == $search_id){
                   $found_student = $student;
               }
           }
           return $found_student;
        }

        function getTeachers()
        {
            $query = $GLOBALS['DB']->query("SELECT teachers.* FROM
            students JOIN students_teachers ON students.id = students_teachers.student_id
                     JOIN teachers ON students_teachers.teacher_id = teachers.id
                     WHERE students.id = {$this->getId()};");
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

        function addTeacher($teacher_id)
        {

            $GLOBALS['DB']->exec("INSERT INTO students_teachers (student_id, teacher_id) VALUES ({$this->getId()}, {$teacher_id});");
        }

        function addCourse($course_id)
        {
            $today = date('Y-m-d h:i:s');
            // $today = '2017-3-6 10:10:10';

            $GLOBALS['DB']->exec("INSERT INTO courses_students (course_id, student_id, date_of_join) VALUES ({$course_id}, {$this->getId()}, '{$today}');");

            //
            // $check_duplication = false;
            // $query = $GLOBALS['DB']->query("SELECT * FROM courses_students WHERE course_id = {$course_id} AND student_id = {$this->id};");
            // var_dump($query);
            // $retrieved = $query->fetchAll(PDO::FETCH_ASSOC);
            //
            //
            // foreach($retrieved as $registration){
            //     $student_id = $registration['student_id'];
            //     $courseid = $registration['course_id'];
            //
            //     if($student_id == $this->id && $courseid  == $course_id){
            //         $check_duplication = true;
            //     }
            // }
            //
            // if($check_duplication == false ){
            //     $GLOBALS['DB']->exec("INSERT INTO courses_students (course_id, student_id, date_of_enrollment) VALUES ({$course_id}, {$this->id}, '{$today}');");
            // };
        }

        function getCourses()
        {
            $returned_courses = $GLOBALS['DB']->query("SELECT courses.* FROM
            students JOIN courses_students ON (students.id = courses_students.student_id)
                    JOIN courses ON (courses_students.course_id = courses.id)
            WHERE students.id = {$this->getId()};");
            $courses = array();
            foreach ($returned_courses as $course )
            {
                $title = $course['title'];
                $id = $course['id'];
                $returned_course = new Course($title, $id);
                array_push($courses, $returned_course);
            }
            return $courses;
        }

        function getDateOfEnrollment($course_id)
        {
            $query = $GLOBALS['DB']->query("SELECT date_of_join FROM courses_students WHERE student_id = {$this->id} AND course_id = {$course_id};");
            $returned_date = $query->fetchAll(PDO::FETCH_ASSOC);
            return $returned_date[0]['date_of_join'];

        }

        //Join Statements NOTE UNTESTED
        // NOTE UNTESTED
        function addAccount($account_id)
        {
            $GLOBALS['DB']->exec("INSERT INTO accounts_students (student_id, account_id) VALUES ({$this->getId()}, {$account_id});");
        }
        // NOTE UNTESTED
        function addLesson($lesson_id)
        {
            $GLOBALS['DB']->exec("INSERT INTO lessons_students (student_id, lesson_id) VALUES ({$this->getId()}, {$lesson_id});");
        }
        // Tested
        function addService($service_id)
        {
            $GLOBALS['DB']->exec("INSERT INTO services_students (service_id, student_id) VALUES ({$service_id},{$this->getId()})");
        }

        // NOTE where should student practiced live?
        // AppSheet ==> Timestamp	Student	Date of Lesson	Attended	Skills we worked on	Song/s we are working on	Student Practiced

        // NOTE maybe there should be a different Join table for student_services_templates.

        // NOTE UNTESTED
        function addPrivateSession($description, $price, $discount, $paid_for, $notes, $date_of_service, $recurrence, $attendance, $duration,  $student_notes, $teacher, $school, $account)
        {
            $new_service = new Service($description, $duration, $price, $discount, $paid_for, $notes, $date_of_service, $recurrence, $attendance);
            $new_service->save();
            $id = $new_service->getId();
            $school->addService($id);
            $account->addService($id);
            $teacher->addService($id);
            $this->addService($id);
        }

        // NOTE UNTESTED
        function addPrivateSessionBatch($repetitions, $description, $duration, $price, $discount, $paid_for, $notes, $date_of_service, $recurrence, $attendance, $teacher, $school, $account)
        {

        //$date_of_service = "2017-03-12 03:30:00";

            $dates = array();
            for ($x = 1; $x <= intval($repetitions); $x++) {

                $new_service = new Service($description, $duration, $price, $discount, $paid_for, $notes, $date_of_service, $recurrence, $attendance);
                $new_service->save();
                $id = $new_service->getId();
                $school->addService($id);
                $account->addService($id);
                $teacher->addService($id);
                $this->addService($id);

                $date_of_service = date('Y-m-d h:i:s', strtotime($date_of_service. ' +  7 days'));

            }
        }

        // NOTE UNTESTED
        function getAccounts()
        {
            $query = $GLOBALS['DB']->query("SELECT accounts.* FROM students JOIN accounts_students ON (students.id = accounts_students.student_id) JOIN accounts ON (accounts_students.account_id = accounts.id) WHERE students.id = {$this->getId()};");
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
        function getLessons()
        {
            $query = $GLOBALS['DB']->query("SELECT lessons.* FROM students JOIN lessons_students ON (students.id = lessons_students.student_id) JOIN lessons ON (lessons_students.lesson_id = lessons.id) WHERE students.id = {$this->getId()};");
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

        // NOTE UNTESTED
        function getServices()
        {
            $query = $GLOBALS['DB']->query("SELECT services.* FROM students JOIN services_students ON (students.id = services_students.student_id) JOIN services ON (services_students.service_id = services.id) WHERE students.id = {$this->getId()};");
            $services = array();
            foreach($query as $service){
                $description = $service['description'];
                $duration = $service['duration'];
                $price = number_format((float) $service['price'], 2);
                $discount = number_format((float)$service['discount'], 2);
                $paid_for = (bool) $service['paid_for'];
                $notes = $service['notes'];
                $date_of_service = $service['date_of_service'];
                $recurrence = $service['recurrence'];
                $attendance = $service['attendance'];
                $id = (int) $service['id'];
                $new_service = new Service($description, $duration, $price, $discount, $paid_for, $notes, $date_of_service, $recurrence, $attendance, $id);
                array_push($services, $new_service);
            }
            return $services;
        }

        // NOTE Koji this our first spec: We want to be able to see the services/sessions a student had in a time period.
        // NOTE This command WORKS!!! as a SQL command in phpMyAdmin: SELECT services.* FROM students JOIN services_students ON (students.id = services_students.student_id) JOIN services ON (services_students.service_id = services.id) WHERE students.id = 2 AND MONTH(date_of_service) = 9 AND YEAR(date_of_service) = 2017
        // NOTE UNTESTED
        function getServicesForMonth($month, $year){
            $query = $GLOBALS['DB']->query("SELECT services.* FROM students JOIN services_students ON (students.id = services_students.student_id) JOIN services ON (services_students.service_id = services.id) WHERE students.id = {$this->getId()} AND MONTH(date_of_service) = {$month} AND YEAR(date_of_service) = {$year};");
            $services = array();
            foreach($query as $service){
                $description = $service['description'];
                $duration = $service['duration'];
                $price = number_format((float) $service['price'], 2);
                $discount = number_format((float)$service['discount'], 2);
                $paid_for = (bool) $service['paid_for'];
                $notes = $service['notes'];
                $date_of_service = $service['date_of_service'];
                $recurrence = $service['recurrence'];
                $attendance = $service['attendance'];
                $id = (int) $service['id'];
                $new_service = new Service($description, $duration, $price, $discount, $paid_for, $notes, $date_of_service, $recurrence, $attendance, $id);
                array_push($services, $new_service);
            }
            return $services;
        }
    }


 ?>
