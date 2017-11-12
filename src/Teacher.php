<?php
    class Teacher
    {
        private $teacher_name;
        private $instrument;
        private $notes;
        private $id;

        function __construct($teacher_name, $instrument, $id = null, $notes = null)
        {
            $this->teacher_name = $teacher_name;
            $this->instrument = $instrument;
            $this->id = $id;
            $this->notes = $notes;
        }

        function setName($new_teacher_name)
        {
            $this->teacher_name = (string) $new_teacher_name;
        }

        function getName()
        {
            return $this->teacher_name;
        }
        function setInstrument ($new_teacher_instrument)
        {
            $this->instrument = (string) $new_teacher_instrument;
        }

        function getInstrument()
        {
            return $this->instrument;
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
            $stmt = $GLOBALS['DB']->prepare("INSERT INTO teachers (teacher_name, instrument, notes) VALUES (:teacher_name, :instrument, :notes)");

            $stmt->bindParam(':teacher_name', $this->getName(), PDO::PARAM_STR);
            $stmt->bindParam(':instrument', $this->getInstrument(), PDO::PARAM_STR);
            $stmt->bindParam(':notes', $this->getNotes(), PDO::PARAM_STR);

            if ($stmt->execute()) {
                $this->id = $GLOBALS['DB']->lastInsertId();
                return true;
            } else {
                return false;
            }
        }

        static function find($teacher_id)
        {
            $stmt = $GLOBALS['DB']->prepare("SELECT teachers.* FROM teachers JOIN schools_teachers ON (teachers.id = schools_teachers.teacher_id) JOIN schools ON (schools_teachers.school_id = schools.id) WHERE teachers.id = :teacher_id AND schools.id = :school_id");

            $stmt->bindParam(':teacher_id', $teacher_id, PDO::PARAM_STR);
            $stmt->bindParam(':school_id', $_SESSION['school_id'], PDO::PARAM_STR);

            if ($stmt->execute()) {
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($result) {
                    $teacher_name =  $result['teacher_name'];
                    $instrument = $result['instrument'];
                    $id = $result['id'];
                    $notes = $result['notes'];

                    return new Teacher($teacher_name, $instrument, $id, $notes);
                } else {
                    // teacher is not belong to the school
                    return false;
                }
            } else {
                // sql failed for some reason
                return false;
            }
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM teachers;");
        }

        static function getAll()
        {
            $returned_teachers = $GLOBALS['DB']->query("SELECT * FROM teachers;");
            $teachers = array();
            if (empty($returned_teachers)){
               return "returned teachers is empty.";
            } else {
              foreach($returned_teachers as $teacher){
                  $teacher_name = $teacher['teacher_name'];
                  $instrument = $teacher['instrument'];
                  $notes = $teacher['notes'];
                  $id = $teacher['id'];
                  $new_teacher = new Teacher($teacher_name, $instrument, $id);
                  $new_teacher->setNotes($notes);
                  array_push($teachers, $new_teacher);
              }
              return $teachers;
            }

        }

        function updateNotes($new_note)
        {
            $stmt = $GLOBALS['DB']->prepare("UPDATE teachers SET notes = :new_note WHERE id = :id");
            $stmt->bindParam(':new_note', $new_note, PDO::PARAM_STR);
            $stmt->bindParam(':id', $this->getId(), PDO::PARAM_STR);
            return $stmt->execute();
        }

        function updateName($teacher_name)
        {
            $stmt = $GLOBALS['DB']->prepare("UPDATE teachers SET teacher_name = :teacher_name WHERE id = :id");
            $stmt->bindParam(':teacher_name', $teacher_name, PDO::PARAM_STR);
            $stmt->bindParam(':id', $this->getId(), PDO::PARAM_STR);

            return $stmt->execute();
        }

        function updateInstrument($instrument)
        {
            $stmt = $GLOBALS['DB']->prepare("UPDATE teachers SET instrument = :instrument WHERE id = :id");
            $stmt->bindParam(':instrument', $instrument, PDO::PARAM_STR);
            $stmt->bindParam(':id', $this->getId(), PDO::PARAM_STR);

            return $stmt->execute();
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM teachers WHERE id = {$this->getId()};");
        }

       function addStudent($student_id)
       {
           $stmt = $GLOBALS['DB']->prepare("
               INSERT INTO students_teachers (student_id, teacher_id)
               VALUES (:student_id, :teacher_id)
           ");
           $stmt->bindParam(':student_id', $student_id, PDO::PARAM_STR);
           $stmt->bindParam(':teacher_id', $this->getId(), PDO::PARAM_STR);

           return $stmt->execute();
       }

        function addCourse($course_id)
        {
            $stmt = $GLOBALS['DB']->prepare("
                INSERT INTO courses_teachers (teacher_id, course_id)
                VALUES (:teacher_id, :course_id)
            ");
            $stmt->bindParam(':course_id', $course_id, PDO::PARAM_STR);
            $stmt->bindParam(':teacher_id', $this->getId(), PDO::PARAM_STR);

            return $stmt->execute();
        }

        function addClient($client_id)
        {
            $stmt = $GLOBALS['DB']->prepare("
                INSERT INTO clients_teachers (teacher_id, client_id)
                VALUES (:teacher_id, :client_id)
            ");
            $stmt->bindParam(':client_id', $client_id, PDO::PARAM_STR);
            $stmt->bindParam(':teacher_id', $this->getId(), PDO::PARAM_STR);

            return $stmt->execute();
        }

        function addLesson($lesson_id)
        {
            $stmt = $GLOBALS['DB']->prepare("
                INSERT INTO lessons_teachers (teacher_id, lesson_id)
                VALUES (:teacher_id, :lesson_id)
            ");
            $stmt->bindParam(':lesson_id', $lesson_id, PDO::PARAM_STR);
            $stmt->bindParam(':teacher_id', $this->getId(), PDO::PARAM_STR);

            return $stmt->execute();
        }

        function addService($service_id)
        {
            $stmt = $GLOBALS['DB']->prepare("
                INSERT INTO services_teachers (teacher_id, service_id)
                VALUES (:teacher_id, :service_id)
            ");
            $stmt->bindParam(':service_id', $service_id, PDO::PARAM_STR);
            $stmt->bindParam(':teacher_id', $this->getId(), PDO::PARAM_STR);

            return $stmt->execute();
        }

        function addUser($user_id)
        {
            $stmt = $GLOBALS['DB']->prepare("
                INSERT INTO users_teachers (user_id, teacher_id)
                VALUES (:user_id, :teacher_id)
            ");
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);
            $stmt->bindParam(':teacher_id', $this->getId(), PDO::PARAM_STR);

            return $stmt->execute();
        }


        // NOTE UNTESTED
        function getStudents()
        {
          $stmt = $GLOBALS['DB']->prepare("
              SELECT students.* FROM teachers
              JOIN students_teachers ON (teachers.id = students_teachers.teacher_id)
              JOIN students ON (students_teachers.student_id = students.id) WHERE teachers.id = :teacher_id
          ");

          $stmt->bindParam(':teacher_id', $this->getId(), PDO::PARAM_STR);

          if ($stmt->execute()) {
              $results = $stmt->fetchAll();
              if ($results) {
                  $students = [];
                  forEach($results as $result) {
                      $student = new Student(
                        $result['student_name'],
                        $result['email_address'],
                        (int) $result['id'],
                        $result['notes']
                      );
                      array_push($students, $student);
                  }
                  return $students;
              } else {
                  return false;
              }
          } else {
              return false;
          }


           $students = array();
           $query = $GLOBALS['DB']->query("SELECT students.* FROM
           teachers JOIN students_teachers ON teachers.id = students_teachers.teacher_id
                    JOIN students ON students_teachers.student_id = students.id
                    WHERE teachers.id = {$this->getId()};");


        }


        function findStudentById($student_id)
        {
            $stmt = $GLOBALS['DB']->prepare("SELECT students.* FROM teachers JOIN students_teachers ON (teachers.id = students_teachers.teacher_id) JOIN students ON (students_teachers.student_id = students.id) WHERE teachers.id = :teacher_id AND students.id = :student_id");

            $stmt->bindParam(':teacher_id', $this->getId(), PDO::PARAM_STR);
            $stmt->bindParam(':student_id', $student_id, PDO::PARAM_STR);

            if ($stmt->execute()) {
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($result) {
                    $student_name =  $result['student_name'];
                    $id = $result['id'];
                    $notes = $result['notes'];

                    return new Student($student_name, $id, $notes);
                } else {
                    // student is not found
                    return false;
                }
            } else {
                // sql failed for some reason
                return false;
            }
        }

        function findTeacherByUserId($user_id)
        {
            $stmt = $GLOBALS['DB']->prepare("
                SELECT teachers.* FROM teachers
                JOIN users_teachers ON (teachers.id = users_teachers.teacher_id)
                JOIN owners ON (users_teachers.user_id = owners.id)
                WHERE owners.id = :user_id
            ");

            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);

            if ($stmt->execute()) {
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($result) {
                    $eacher_name =  $result['teacher_name'];
                    $instrument = $result['instrument'];
                    $id = $result['id'];
                    $notes = $result['notes'];

                    return new Teacher($teacher_name, $instrument, $id, $notes);
                } else {
                    // teacher is not found
                    return false;
                }
            } else {
                // sql failed for some reason
                return false;
            }
        }



        // NOTE UNTESTED
        function getCourses()
        {
            $query = $GLOBALS['DB']->query("SELECT courses.* FROM teachers JOIN courses_teachers ON (teachers.id = courses_teachers.teacher_id) JOIN courses ON (courses_teachers.course_id = courses.id) WHERE teachers.id = {$this->getId()};");
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
        function getClients()
        {
            $query = $GLOBALS['DB']->query("SELECT clients.* FROM teachers JOIN clients_teachers ON (teachers.id = clients_teachers.teacher_id) JOIN clients ON (clients_teachers.client_id = clients.id) WHERE teachers.id = {$this->getId()};");
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
            $query = $GLOBALS['DB']->query("SELECT lessons.* FROM teachers JOIN lessons_teachers ON (teachers.id = lessons_teachers.teacher_id) JOIN lessons ON (lessons_teachers.lesson_id = lessons.id) WHERE teachers.id = {$this->getId()};");
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

        function getServicesForMonth($month = null, $year = null) {
            //if arguments are empty, set today's month and year
            $month = $month ? $month : date('n');
            $year = $year ? $year : date('Y');

            $stmt = $GLOBALS['DB']->prepare("
                SELECT services.* FROM teachers
                JOIN services_teachers ON (teachers.id = services_teachers.teacher_id)
                JOIN services ON (services_teachers.service_id = services.id)
                WHERE teachers.id = :teacher_id
                AND MONTH(date_of_service) = :month
                AND YEAR(date_of_service) = :year
            ");

            $stmt->bindParam(':teacher_id', $this->getId(), PDO::PARAM_STR);
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


        function findCourseById($course_id)
        {
            $stmt = $GLOBALS['DB']->prepare("
                SELECT courses.* FROM teachers
                JOIN courses_teachers ON (teachers.id = courses_teachers.teacher_id)
                JOIN courses ON (courses_teachers.course_id = courses.id)
                WHERE teachers.id = :teacher_id
                AND courses.id = :course_id
            ");

            $stmt->bindParam(':teacher_id', $this->getId(), PDO::PARAM_STR);
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
    }
