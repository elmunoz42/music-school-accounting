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
            $GLOBALS['DB']->exec("UPDATE teachers SET notes = '{$new_note}' WHERE id = {$this->getId()};");
            $this->setNotes($new_note);
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

        // JOIN methods
        // NOTE UNTESTED
       function addStudent($student_id)
       {
           $GLOBALS['DB']->exec("INSERT INTO students_teachers (student_id, teacher_id) VALUES ({$student_id}, {$this->getId()});");
       }
       // NOTE UNTESTED
        function addCourse($course_id)
        {
            $GLOBALS['DB']->exec("INSERT INTO courses_teachers (teacher_id, course_id) VALUES ({$this->getId()}, {$course_id});");
        }
        // NOTE UNTESTED
        function addAccount($account_id)
        {
            $GLOBALS['DB']->exec("INSERT INTO accounts_teachers (teacher_id, account_id) VALUES ({$this->getId()}, {$account_id});");
        }
        // NOTE UNTESTED
        function addLesson($lesson_id)
        {
            $GLOBALS['DB']->exec("INSERT INTO lessons_teachers (teacher_id, lesson_id) VALUES ({$this->getId()}, {$lesson_id});");
        }
        // NOTE UNTESTED
        function addService($service_id)
        {
            $GLOBALS['DB']->exec("INSERT INTO services_teachers (teacher_id, service_id) VALUES ({$this->getId()}, {$service_id})");
        }

        // NOTE UNTESTED
        function getStudents()
        {
           $students = array();
           $query = $GLOBALS['DB']->query("SELECT students.* FROM
           teachers JOIN students_teachers ON teachers.id = students_teachers.teacher_id
                    JOIN students ON students_teachers.student_id = students.id
                    WHERE teachers.id = {$this->getId()};");

          if(!empty($query)){
              foreach($query as $student) {
                  $student_name = $student['student_name'];
                  $id = $student['id'];
                  $new_student = new Student($student_name, $id);
                  array_push($students, $new_student);
              }
          }
          return $students;
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
        function getAccounts()
        {
            $query = $GLOBALS['DB']->query("SELECT accounts.* FROM teachers JOIN accounts_teachers ON (teachers.id = accounts_teachers.teacher_id) JOIN accounts ON (accounts_teachers.account_id = accounts.id) WHERE teachers.id = {$this->getId()};");
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

    }


 ?>
