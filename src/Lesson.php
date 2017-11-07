<?php
//CREATE TABLE lesson (title VARCHAR(255), description VARCHAR(255), content TEXT, id serial PRIMARY KEY);
    class Lesson
    {
        private $title;
        private $description;
        private $content;
        private $id;

        function __construct($title, $description, $content, $id = null)
        {
            $this->title = (string) $title;
            $this->description = (string) $description;
            $this->content = (string) $content;
            $this->id = (int) $id;
        }

        // getters and setters

        function setTitle($new_title)
        {
            $this->title = (string) $new_title;
        }

        function getTitle()
        {
            return $this->title;
        }

        function setDescription($new_description)
        {
            $this->description = (string) $new_description;
        }

        function getDescription()
        {
            return $this->description;
        }

        function setContent($new_content)
        {
            $this->content = (string) $new_content;
        }

        function getContent()
        {
            return $this->content;
        }

        function getId()
        {
            return $this->id;
        }

        function save()
        {
        $GLOBALS['DB']->exec("INSERT INTO lessons (title, description, content) VALUES ('{$this->getTitle()}', '{$this->getDescription()}', '{$this->getContent()}');");
        $this->id = (int) $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $retrieved_lessons = $GLOBALS['DB']->query("SELECT * FROM lessons;");
            $lessons = array();
            foreach( $retrieved_lessons as $lesson )
            {
                $title_re = $lesson['title'];
                $description_re = $lesson['description'];
                $content_re = $lesson['content'];
                $id_re = $lesson['id'];
                $instant_lesson = new Lesson($title_re, $description_re, $content_re, $id_re);
                array_push($lessons, $instant_lesson);
            }
            return $lessons;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM lessons;");
        }

        static function find($lesson_id)
        {
            $stmt = $GLOBALS['DB']->prepare("SELECT lessons.* FROM lessons JOIN lessons_schools ON (lessons.id = lessons_schools.lesson_id) JOIN schools ON (lessons_schools.school_id = schools.id) WHERE lessons.id = :lesson_id AND schools.id = :school_id");

            $stmt->bindParam(':lesson_id', $lesson_id, PDO::PARAM_STR);
            $stmt->bindParam(':school_id', $_SESSION['school_id'], PDO::PARAM_STR);

            if ($stmt->execute()) {
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                if($result) {
                    $title =  $result['title'];
                    $description = $result['description'];
                    $content = $result['content'];
                    $id = $result['id'];

                    return new Lesson($title, $description, $content, $id);
                } else {
                    // lesson is not belong to the school
                    return false;
                }
            } else {
                // sql failed for some reason
                return false;
            }
        }

        function delete()
        {
          $stmt = $GLOBALS['DB']->prepare("DELETE FROM lessons WHERE id = :id");
          $stmt->bindParam(':id', $this->getId(), PDO::PARAM_STR);

          return $stmt->execute();
        }

        function updateTitle($title)
        {
            $stmt = $GLOBALS['DB']->prepare("UPDATE lessons SET title = :title WHERE id = :id");
            $stmt->bindParam(':title', $title, PDO::PARAM_STR);
            $stmt->bindParam(':id', $this->getId(), PDO::PARAM_STR);
            return $stmt->execute();
        }

        function updateDescription($description)
        {
            $stmt = $GLOBALS['DB']->prepare("UPDATE lessons SET description = :description WHERE id = :id");
            $stmt->bindParam(':description', $description, PDO::PARAM_STR);
            $stmt->bindParam(':id', $this->getId(), PDO::PARAM_STR);
            return $stmt->execute();
        }

        function updateContent($content)
        {
            $stmt = $GLOBALS['DB']->prepare("UPDATE lessons SET content = :content WHERE id = :id");
            $stmt->bindParam(':content', $content, PDO::PARAM_STR);
            $stmt->bindParam(':id', $this->getId(), PDO::PARAM_STR);
            return $stmt->execute();
        }

        // Join methods INSERTS
        // NOTE UNTESTED
        function addTeacher($teacher_id)
        {
            $GLOBALS['DB']->exec("INSERT INTO lessons_teachers (lesson_id, teacher_id) VALUES ({$this->getId()}, {$teacher_id});");
        }
        // NOTE UNTESTED
        function addCourse($course_id)
        {
            $GLOBALS['DB']->exec("INSERT INTO courses_lessons (lesson_id, course_id) VALUES ({$this->getId()}, {$course_id});");
        }
        // NOTE UNTESTED
        function addStudent($student_id)
        {
            $GLOBALS['DB']->exec("INSERT INTO lessons_students (lesson_id, student_id) VALUES ({$this->getId()}, {$student_id});");
        }
        // NOTE UNTESTED
        function addClient($client_id)
        {
            $GLOBALS['DB']->exec("INSERT INTO clients_lessons (lesson_id, client_id) VALUES ({$this->getId()}, {$client_id});");
        }

        // Join statements QUERY
        // NOTE UNTESTED
        function getTeachers()
        {
            $query = $GLOBALS['DB']->query("SELECT teachers.* FROM lessons JOIN lessons_teachers ON (lessons.id = lessons_teachers.lesson_id) JOIN teachers ON (lessons_teachers.teacher_id = teachers.id) WHERE lessons.id = {$this->getId()};");
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
            $query = $GLOBALS['DB']->query("SELECT courses.* FROM lessons JOIN courses_lessons ON (lessons.id = courses_lessons.lesson_id) JOIN courses ON (courses_lessons.course_id = courses.id) WHERE lessons.id = {$this->getId()};");
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
            $query = $GLOBALS['DB']->query("SELECT students.* FROM lessons JOIN lessons_students ON (lessons.id = lessons_students.lesson_id) JOIN students ON (lessons_students.student_id = students.id) WHERE lessons.id = {$this->getId()};");
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
        function getClients()
        {
            $query = $GLOBALS['DB']->query("SELECT clients.* FROM lessons JOIN clients_lessons ON (lessons.id = clients_lessons.lesson_id) JOIN clients ON (clients_lessons.client_id = clients.id) WHERE lessons.id = {$this->getId()};");
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

    }
 ?>
