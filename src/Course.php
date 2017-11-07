<?php

    class Course
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

        function updateTitle($new_title)
        {
            $stmt = $GLOBALS['DB']->prepare("UPDATE courses SET title = :title WHERE id = :id");
            $stmt->bindParam(':title', $new_title, PDO::PARAM_STR);
            $stmt->bindParam(':id', $this->getId(), PDO::PARAM_STR);
            return $stmt->execute();
        }

        static function find($course_id)
        {
            $stmt = $GLOBALS['DB']->prepare("SELECT courses.* FROM courses JOIN courses_schools ON (courses.id = courses_schools.course_id) JOIN schools ON (courses_schools.school_id = schools.id) WHERE courses.id = :course_id AND schools.id = :school_id");

            $stmt->bindParam(':course_id', $course_id, PDO::PARAM_STR);
            $stmt->bindParam(':school_id', $_SESSION['school_id'], PDO::PARAM_STR);

            if ($stmt->execute()) {
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($result) {
                    $title = $result['title'];
                    $id = $result['id'];

                    return new Course($title, $id);
                } else {
                    // course is not belong to the school
                    return false;
                }
            } else {
                // sql failed for some reason
                return false;
            }
        }

        function deleteCourse()
        {
            $stmt = $GLOBALS['DB']->prepare("DELETE FROM courses WHERE id = :id");
            $stmt->bindParam(':id', $this->getId(), PDO::PARAM_STR);

            return $stmt->execute();
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
        function addClient($client_id)
        {
            $GLOBALS['DB']->exec("INSERT INTO clients_courses (course_id, client_id) VALUES ({$this->getId()}, {$client_id});");
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
        function getClients()
        {
            $query = $GLOBALS['DB']->query("SELECT clients.* FROM courses JOIN clients_courses ON (courses.id = clients_courses.course_id) JOIN clients ON (clients_courses.client_id = clients.id) WHERE courses.id = {$this->getId()};");
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
            $stmt = $GLOBALS['DB']->prepare("
                SELECT lessons.* FROM courses
                JOIN courses_lessons ON courses.id = courses_lessons.course_id
                JOIN lessons ON courses_lessons.lesson_id = lessons.id
                WHERE courses.id = :course_id
            ");
            $stmt->bindParam(':course_id', $this->getId(), PDO::PARAM_STR);

            if ($stmt->execute()) {
                $results = $stmt->fetchAll();
                if ($results) {
                    $lessons = [];
                    forEach($results as $result) {
                        $lesson = new Lesson(
                            $result['title'],
                            $result['description'],
                            $result['content'],
                            $result['id']
                        );
                        array_push($lessons, $lesson);
                    }
                    return $lessons;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
    }
 ?>
