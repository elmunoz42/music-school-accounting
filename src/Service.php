<?php

    class Service
    {
        private $description;
        private $duration;
        private $price;
        private $discount;
        private $paid_for;
        private $notes;
        private $date_of_service;
        private $recurrence;
        private $attendance;
        private $id;

        // TODO CREATE TEMPLATE JOIN TABLE USED FOR REFERENCE.
        // 1) students_services_template

        // 2) create student->setSessionTemplate($teacher_id, $school_id, $account_id, $service_id) NOTE HAS TO DELETE PREVIOUS TEMPLATE!

        // 3) create student->findSessionTemplate($teacher_id);

        // 4) TODO description can serve as a link to the tokbox appointment, since it doesn't serve much of a function. 

        function __construct($description, $duration, $price, $discount, $paid_for, $notes, $date_of_service, $recurrence, $attendance,$id = null)
        {
            $this->description = $description;
            $this->duration = (int) $duration; //in minutes
            $this->price = number_format((float) $price, 2); // stored as decimal(10,2)
            $this->discount = number_format((float) $discount, 2); // stored as decimal(10,2) portion of whole price remaining f.e. 90 => 90% discounted price.
            $this->paid_for = intval($paid_for); // convert to TINIINT 1s and 0s for server!!!
            $this->notes = (string) $notes;
            $this->date_of_service = (string) $date_of_service;
            $this->recurrence = (string) $recurrence; // "Wednesdays|3:00pm|40min"

            $this->attendance = (string) $attendance; // use codes and translate to numbers
            $this->id = (int) $id;
        }


        // getters and setters
        function setDescription($new_description)
        {
            $this->description = (string) $new_description;
        }
        function getDescription()
        {
            return $this->description;
        }
        function setDuration($new_duration)
        {
            $this->duration = (int) $new_duration;
        }
        function getDuration()
        {
            return $this->duration;
        }
        function setPrice($new_price)
        {
            $this->price = number_format((float) $new_price,2);
        }
        function getPrice()
        {
            return $this->price;
        }
        function setDiscount($new_discount)
        {
            $this->discount = number_format((float) $new_discount, 2);
        }
        function getDiscount()
        {
            return $this->discount;
        }
        function setPaidFor($new_paid_for)
        {
            $this->paid_for = $new_paid_for;
        }
        function getPaidFor()
        {
            return $this->paid_for;
        }
        function setNotes($new_note)
        {
            $this->notes = (string) $new_note;
        }
        function getNotes()
        {
            return $this->notes;
        }
        function setDateOfService($new_date_of_service)
        {
            $this->date_of_service = (string) $new_date_of_service;
        }
        function getDateOfService()
        {
            return $this->date_of_service;
        }
        function setRecurrence($new_recurrence)
        {
            $this->recurrence = (string) $new_recurrence;
        }
        function getRecurrence()
        {
            return $this->recurrence;
        }
        function setAttendance($new_attendance)
        {
            $this->attendance = (string) $new_attendance;
        }
        function getAttendance()
        {
            return $this->attendance;
        }
        function getId()
        {
            return (int) $this->id;
        }

        // CRUD Methods
        // Create
        function save()
        {
            $description = $this->getDescription();
            $duration = $this->getDuration();
            $price = $this->getPrice();
            $discount = $this->getDiscount();
            $paid_for = $this->getPaidFor();
            $notes = $this->getNotes();
            $date_of_service = $this->GetDateOfService();
            $recurrence = $this->getRecurrence();
            $attendance = $this->getAttendance();

            $GLOBALS['DB']->exec("INSERT INTO services (description, duration, price, discount, paid_for, notes, date_of_service, recurrence, attendance) VALUES ('{$description}', {$duration}, {$price}, {$discount}, {$paid_for}, '{$notes}', '{$date_of_service}', '{$recurrence}', '{$attendance}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        // Retrieve
        static function getAll()
        {
            $returned_services = $GLOBALS['DB']->query("SELECT * FROM services;");
            $services = array();
            foreach($returned_services as $service){
                $description = $service['description'];
                $duration = $service['duration'];
                $price = $service['price'];
                $discount = $service['discount'];
                $paid_for = $service['paid_for'];
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

        // Tested :-)
        static function find($service_id)
        {
            $returned_services = $GLOBALS['DB']->query("SELECT * FROM services WHERE id = {$service_id};");
            $re_service = null;
            foreach($returned_services as $service){
                $description = $service['description'];
                $duration = $service['duration'];
                $price = $service['price'];
                $discount = $service['discount'];
                $paid_for = (bool) $service['paid_for'];
                $notes = $service['notes'];
                $date_of_service = $service['date_of_service'];
                $recurrence = $service['recurrence'];
                $attendance = $service['attendance'];
                $id = (int) $service['id'];
                $re_service = new Service($description, $duration, $price, $discount, $paid_for, $notes, $date_of_service, $recurrence, $attendance, $id);
            }
            return $re_service;
        }

        // Update functions
        function updateDescription($update)
        {
            $GLOBALS['DB']->exec("UPDATE services SET description = '{$update}' WHERE id = {$this->getId()};");
            $this->setDescription($update);
        }
        function updateDuration($update)
        {
            $GLOBALS['DB']->exec("UPDATE services SET duration = {$update} WHERE id = {$this->getId()};");
            $this->setDuration($update);
        }
        function updatePrice($update)
        {
            $GLOBALS['DB']->exec("UPDATE services SET price = {$update} WHERE id = {$this->getId()};");
            $this->setPrice($update);
        }
        function updateDiscount($update)
        {
            $GLOBALS['DB']->exec("UPDATE services SET discount = {$update} WHERE id = {$this->getId()};");
            $this->setDiscount($update);
        }
        function updatePaidFor($update)
        {
            $GLOBALS['DB']->exec("UPDATE services SET paid_for = {$update} WHERE id = {$this->getId()};");
            $this->setPaidFor($update);
        }
        function updateNotes($update)
        {
            $GLOBALS['DB']->exec("UPDATE services SET notes = '{$update}' WHERE id = {$this->getId()};");
            $this->setNotes($update);
        }
        function updateDateOfService($update)
        {
            $GLOBALS['DB']->exec("UPDATE services SET date_of_service = '{$update}' WHERE id = {$this->getId()};");
            $this->setDateOfService($update);
        }
        function updateRecurrence($update)
        {
            $GLOBALS['DB']->exec("UPDATE services SET recurrence = '{$update}' WHERE id = {$this->getId()};");
            $this->setRecurrence($update);
        }
        function updateAttendance($update)
        {
            $GLOBALS['DB']->exec("UPDATE services SET attendance = '{$update}' WHERE id = {$this->getId()};");
            $this->setAttendance($update);
        }

        // Delete
        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM services;");
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM services WHERE id = {$this->getId()};");
        }

        // JOIN methods NOTE UNTESTED
        function addTeacher($teacher_id)
        {
            $GLOBALS['DB']->exec("INSERT INTO services_teachers (service_id, teacher_id) VALUES ({$this->getId()}, {$teacher_id});");
        }
        // NOTE UNTESTED
        function addCourse($course_id)
        {
            $GLOBALS['DB']->exec("INSERT INTO courses_services (service_id, course_id) VALUES ({$this->getId()}, {$course_id});");
        }
        // NOTE UNTESTED
        function addStudent($student_id)
        {
            $GLOBALS['DB']->exec("INSERT INTO services_students (service_id, student_id) VALUES ({$this->getId()}, {$student_id});");
        }
        // NOTE UNTESTED
        function addAccount($account_id)
        {
            $GLOBALS['DB']->exec("INSERT INTO accounts_services (service_id, account_id) VALUES ({$this->getId()}, {$account_id});");
        }
        // NOTE UNTESTED
        function addLesson($lesson_id)
        {
            $GLOBALS['DB']->exec("INSERT INTO lessons_services (service_id, lesson_id) VALUES ({$this->getId()}, {$lesson_id});");
        }
        // NOTE UNTESTED
        function getTeachers()
        {
            $query = $GLOBALS['DB']->query("SELECT teachers.* FROM services JOIN services_teachers ON (services.id = services_teachers.service_id) JOIN teachers ON (services_teachers.teacher_id = teachers.id) WHERE services.id = {$this->getId()};");
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
        function getCourses()
        {
            $query = $GLOBALS['DB']->query("SELECT courses.* FROM services JOIN courses_services ON (services.id = courses_services.service_id) JOIN courses ON (courses_services.course_id = courses.id) WHERE services.id = {$this->getId()};");
            $courses = array();
            foreach ($query as $course )
            {
                $title = $course['title'];
                $id = $course['id'];
                $returned_course = new Course($title, $id);
                array_push($courses, $returned_course);
            }
            return $courses;
        }
        // NOTE UNTESTED
        function getStudents()
        {
            $query = $GLOBALS['DB']->query("SELECT students.* FROM services JOIN services_students ON (services.id = services_students.service_id) JOIN students ON (services_students.student_id = students.id) WHERE services.id = {$this->getId()};");
            $students = array();
            if(!empty($query)){
                foreach($query as $student) {
                    $student_name = $student['student_name'];
                    $id = intval($student['id']);
                    $new_student = new Student($student_name, $id);
                    $new_student->setNotes($student['notes']);
                    array_push($students, $new_student);
                }
            }
            return $students;
        }
        // NOTE UNTESTED
        function getAccounts()
        {
            $query = $GLOBALS['DB']->query("SELECT accounts.* FROM services JOIN accounts_services ON (services.id = accounts_services.service_id) JOIN accounts ON (accounts_services.account_id = accounts.id) WHERE services.id = {$this->getId()};");
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
            $query = $GLOBALS['DB']->query("SELECT lessons.* FROM services JOIN lessons_services ON (services.id = lessons_services.service_id) JOIN lessons ON (lessons_services.lesson_id = lessons.id) WHERE services.id = {$this->getId()};");
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
