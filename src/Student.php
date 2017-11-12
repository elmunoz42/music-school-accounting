<?php
    class Student
    {
        private $student_name;
        private $email_address;
        private $notes;
        private $id;

        function __construct($student_name, $email_address, $id = null, $notes = null)
        {
            $this->student_name = $student_name;
            $this->email_address = $email_address;
            $this->id = (Int)$id;
            $this->notes = $notes;
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

        function getEmailAddress()
        {
            return $this->email_address;
        }

        function setEmailAddress($email_address)
        {
            $this->email_address = $email_address;
        }

        function getId()
        {
            return $this->id;
        }

        function save()
        {
            $stmt = $GLOBALS['DB']->prepare("
                INSERT INTO students (student_name, email_address, notes)
                VALUES (:student_name, :email_address, :notes)
            ");
            $stmt->bindParam(':student_name', $this->getName(), PDO::PARAM_STR);
            $stmt->bindParam(':email_address', $this->getEmailAddress(), PDO::PARAM_STR);
            $stmt->bindParam(':notes', $this->getNotes(), PDO::PARAM_STR);

            if ($stmt->execute()) {
                $this->id = $GLOBALS['DB']->lastInsertId();
                return true;
            } else {
                return false;
            }
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

        function updateNotes($new_note)
        {
            $stmt = $GLOBALS['DB']->prepare("UPDATE students SET notes = :new_note WHERE id = :id");
            $stmt->bindParam(':new_note', $new_note, PDO::PARAM_STR);
            $stmt->bindParam(':id', $this->getId(), PDO::PARAM_STR);
            return $stmt->execute();
        }

        function updateName($student_name)
        {
            $stmt = $GLOBALS['DB']->prepare("
                UPDATE students SET student_name = :student_name
                WHERE id = :id
            ");
            $stmt->bindParam(':student_name', $student_name, PDO::PARAM_STR);
            $stmt->bindParam(':id', $this->getId(), PDO::PARAM_STR);
            return $stmt->execute();
        }

        function updateEmailAddress($email_address)
        {
            $stmt = $GLOBALS['DB']->prepare("
                UPDATE students SET email_address = :email_address
                WHERE id = :id
            ");
            $stmt->bindParam(':email_address', $email_address, PDO::PARAM_STR);
            $stmt->bindParam(':id', $this->getId(), PDO::PARAM_STR);
            return $stmt->execute();
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM students WHERE id = {$this->getId()};");
        }

        static function find($student_id)
        {
            $stmt = $GLOBALS['DB']->prepare("SELECT students.* FROM students JOIN schools_students ON (students.id = schools_students.student_id) JOIN schools ON (schools_students.school_id = schools.id) WHERE students.id = :student_id AND schools.id = :school_id");

            $stmt->bindParam(':student_id', $student_id, PDO::PARAM_STR);
            $stmt->bindParam(':school_id', $_SESSION['school_id'], PDO::PARAM_STR);

            if ($stmt->execute()) {
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($result) {
                    $student_name =  $result['student_name'];
                    $email_address = $result['email_address'];
                    $id = $result['id'];
                    $notes = $result['notes'];

                    return new Student($student_name, $email_address, $id, $notes);
                } else {
                    // student is not belong to the school
                    return false;
                }
            } else {
                // sql failed for some reason
                return false;
            }
        }

        function findCourseById($course_id)
        {
            $stmt = $GLOBALS['DB']->prepare("
                SELECT courses.* FROM students
                JOIN courses_students ON (students.id = courses_students.student_id)
                JOIN courses ON (courses_students.course_id = courses.id)
                WHERE students.id = :student_id
                AND courses.id = :course_id
            ");

            $stmt->bindParam(':student_id', $this->getId(), PDO::PARAM_STR);
            $stmt->bindParam(':course_id', $course_id, PDO::PARAM_STR);

            if ($stmt->execute()) {
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($result) {
                    $title =  $result['title'];
                    $id = $result['id'];

                    return new Course($title, $id);
                } else {
                    // course is not found
                    return false;
                }
            } else {
                // sql failed for some reason
                return false;
            }
        }


        function getTeachers()
        {
            $stmt = $GLOBALS['DB']->prepare("
                SELECT teachers.* FROM students
                JOIN students_teachers ON (students.id = students_teachers.student_id)
                JOIN teachers ON (students_teachers.teacher_id = teachers.id)
                WHERE students.id = :student_id
            ");
            $stmt->bindParam(':student_id', $this->getId(), PDO::PARAM_STR);

            if ($stmt->execute()) {
                $results = $stmt->fetchAll();
                if ($results) {
                    $teachers = [];
                    forEach($results as $result) {
                        $teacher = new Teacher(
                            $result['teacher_name'],
                            $result['instrument'],
                            $result['id'],
                            $result['notes']
                        );
                        array_push($teachers, $teacher);
                    }
                    return $teachers;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }

        function addTeacher($teacher_id)
        {

            $GLOBALS['DB']->exec("INSERT INTO students_teachers (student_id, teacher_id) VALUES ({$this->getId()}, {$teacher_id});");
        }

        function addCourse($course_id)
        {
            $today = date('Y-m-d h:i:s');

            $stmt = $GLOBALS['DB']->prepare("
                INSERT INTO courses_students (course_id, student_id, date_of_join)
                VALUES (:course_id, :student_id, :date_of_join)
            ");
            $stmt->bindParam(':course_id', $course_id, PDO::PARAM_STR);
            $stmt->bindParam(':student_id', $this->getId(), PDO::PARAM_STR);
            $stmt->bindParam(':date_of_join', $today, PDO::PARAM_STR);

            return $stmt->execute();

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
        function addClient($client_id)
        {
            $GLOBALS['DB']->exec("INSERT INTO clients_students (student_id, client_id) VALUES ({$this->getId()}, {$client_id});");
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
        function addPrivateSession($description, $price, $discount, $paid_for, $notes, $date_of_service, $recurrence, $attendance, $duration,  $student_notes, $teacher, $school, $client)
        {
            $new_service = new Service($description, $duration, $price, $discount, $paid_for, $notes, $date_of_service, $recurrence, $attendance);
            $new_service->save();
            $id = $new_service->getId();
            $school->addService($id);
            $client->addService($id);
            $teacher->addService($id);
            $this->addService($id);
        }

        // NOTE UNTESTED
        function addPrivateSessionBatch($repetitions, $course, $duration, $price, $discount, $paid_for, $date_of_service, $recurrence, $attendance, $teacher, $school, $client)
        {

        //$date_of_service = "2017-03-12 03:30:00";

            $dates = array();
            for ($x = 1; $x <= intval($repetitions); $x++) {

                $notes = "Scheduled on " . date('Y-m-d h:i:s', strtotime($date_of_service));
                $new_service = new Service($course->getTitle(), $duration, $price, $discount, $paid_for, $notes, $date_of_service, $recurrence, $attendance);
                if ($new_service->save()) {
                    $id = $new_service->getId();
                    $school->addService($id);
                    $client->addService($id);
                    $teacher->addService($id);
                    $this->addService($id);
                    $course->addService($id);
                    $date_of_service = date('Y-m-d h:i:s', strtotime($date_of_service. ' +  7 days'));
                } else {
                    // error
                    return false;
                }
            }
            return true;
        }

        // NOTE UNTESTED
        function getClients()
        {
            $query = $GLOBALS['DB']->query("SELECT clients.* FROM students JOIN clients_students ON (students.id = clients_students.student_id) JOIN clients ON (clients_students.client_id = clients.id) WHERE students.id = {$this->getId()};");
            $clients = array();
            foreach ($query as $client)
            {
                $id = $client['id'];
                $family_name = $client['family_name'];
                $parent_one_name = $client['parent_one_name'];
                $parent_two_name = $client['parent_two_name'];
                $street_address = $client['street_address'];
                $phone_number = $client['phone_number'];
                $email_address = $client['email_address'];
                $notes = $client['notes'];
                $billing_history = $client['billing_history'];
                $outstanding_balance = intval($client['outstanding_balance']);
                $new_client = new Client($family_name, $parent_one_name,  $street_address, $phone_number, $email_address, $id);
                $new_client->setParentTwoName($parent_two_name);
                $new_client->setNotes($notes);
                $new_client->setBillingHistory($billing_history);
                $new_client->setOutstandingBalance($outstanding_balance);
                array_push($clients, $new_client);
            }
            return $clients;
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
        function getServicesForMonth($month = null, $year = null) {
            //if arguments are empty, set today's month and year
            $month = $month ? $month : date('n');
            $year = $year ? $year : date('Y');

            $stmt = $GLOBALS['DB']->prepare("
                SELECT services.* FROM students
                JOIN services_students ON (students.id = services_students.student_id)
                JOIN services ON (services_students.service_id = services.id)
                WHERE students.id = :student_id
                AND MONTH(services.date_of_service) = :month
                AND YEAR(services.date_of_service) = :year
            ");

            $stmt->bindParam(':student_id', $this->getId(), PDO::PARAM_STR);
            $stmt->bindParam(':month', $month, PDO::PARAM_STR);
            $stmt->bindParam(':year', $year, PDO::PARAM_STR);

            if($stmt->execute()) {
                $results = $stmt->fetchAll();
                if ($results) {
                    $services = [];
                    forEach($results as $result) {
                        $service = new Service(
                            $result['description'],
                            $result['duration'],
                            number_format((float) $result['price'], 2),
                            number_format((float) $result['discount'], 2),
                            (bool) $result['paid_for'],
                            $result['notes'],
                            $result['date_of_service'],
                            $result['recurrence'],
                            $result['attendance'],
                            (int) $result['id']
                        );
                        array_push($services, $service);
                    }
                    return $services;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
    }


 ?>
