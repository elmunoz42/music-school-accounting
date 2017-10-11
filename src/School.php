<?php

    class School
    {
        private $school_name;
        private $manager_name;
        private $phone_number;
        private $email;
        private $business_address;
        private $city;
        private $state;
        private $country;
        private $zip;
        private $type;
        private $id;

        function __construct($school_name, $manager_name, $phone_number, $email, $business_address, $city, $state, $country, $zip, $type, $id = null)
        {
            $this->school_name = $school_name;
            $this->manager_name = $manager_name;
            $this->phone_number = $phone_number;
            $this->email = $email;
            $this->business_address = $business_address;
            $this->city = $city;
            $this->state = $state;
            $this->country = $country;
            $this->zip = $zip;
            $this->type = $type;
            $this->id = $id;
        }

        // Setters
        function setSchoolName($new_school_name)
        {
            $this->school_name = $new_school_name;
        }

        function setManagerName($new_manager_name)
        {
            $this->manager_name= $new_manager_name;
        }

        function setPhoneNumber($new_phone_number)
        {
            $this->phone_number = $new_phone_number;
        }

        function setEmail($new_email)
        {
            $this->email = $new_email;
        }

        function setBusinessAddress($new_address)
        {
            $this->business_address = $new_address;
        }

        function setCity($new_city)
        {
            $this->city = $new_city;
        }

        function setZip($new_zip)
        {
            $this->zip = $new_zip;
        }

        function setState($new_state)
        {
            $this->state = $new_state;
        }

        function setCountry($new_country)
        {
            $this->country = $new_country;
        }

        function setType($new_type)
        {
            $this->type = $new_type;
        }

        // Getters
        function getSchoolName()
        {
            return $this->school_name;
        }

        function getManagerName()
        {
            return $this->manager_name;
        }

        function getPhoneNumber()
        {
            return $this->phone_number;
        }

        function getEmail()
        {
            return $this->email;
        }

        function getBusinessAddress()
        {
            return $this->business_address;
        }

        function getCity()
        {
            return $this->city;
        }

        function getZip()
        {
            return $this->zip;
        }

        function getType()
        {
            return $this->type;
        }

        function getState()
        {
            return $this->state;
        }

        function getCountry()
        {
            return $this->country;
        }

        function getId()
        {
            return $this->id;
        }

        // CRUD functions

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO schools (school_name, manager_name, phone_number, email, business_address, city, state, country, zip, type) VALUES ('{$this->getSchoolName()}','{$this->getManagerName()}','{$this->getPhoneNumber()}','{$this->getEmail()}','{$this->getBusinessAddress()}','{$this->getCity()}','{$this->getState()}','{$this->getCountry()}','{$this->getZip()}','{$this->getType()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
            return true;
        }

        static function getAll()
        {
            $query = $GLOBALS['DB']->query("SELECT * FROM schools");
            $schools = array();
            foreach( $query as $school )
            {
                $school_name = $school['school_name'];
                $manager_name = $school['manager_name'];
                $phone_number = $school['phone_number'];
                $email = $school['email'];
                $business_address = $school['business_address'];
                $city = $school['city'];
                $state = $school['state'];
                $country = $school['country'];
                $zip = $school['zip'];
                $type = $school['type'];
                $id = $school['id'];
                $retrieved_school = new School($school_name, $manager_name, $phone_number, $email, $business_address, $city, $state, $country, $zip, $type, $id);
                array_push($schools, $retrieved_school);
            }
            return $schools;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM schools;");
        }

        static function find($school_id)
        {
            $query = $GLOBALS['DB']->query("SELECT * FROM schools WHERE id = {$school_id};");
            $ret_school = null;
            foreach( $query as $school )
            {
                $school_name = $school['school_name'];
                $manager_name = $school['manager_name'];
                $phone_number = $school['phone_number'];
                $email = $school['email'];
                $business_address = $school['business_address'];
                $city = $school['city'];
                $state = $school['state'];
                $country = $school['country'];
                $zip = $school['zip'];
                $type = $school['type'];
                $id = $school['id'];
                $ret_school = new School($school_name, $manager_name, $phone_number, $email, $business_address, $city, $state, $country, $zip, $type, $id);
            }
            return $ret_school;
        }

        static function findSchoolsByOwnerId($owner_id)
        {
          $stmt = $GLOBALS['DB']->prepare(
              "SELECT schools.* FROM schools JOIN owners_schools ON schools.id = owners_schools.school_id JOIN owners ON owners_schools.owner_id = owners.id WHERE owners.id = :owner_id");
          $stmt->bindParam(':owner_id', $owner_id, PDO::PARAM_STR);
          $stmt->execute();

          if($stmt->execute()) {
              $results = $stmt->fetchAll();
              if ($results) {
                $schools = [];
                forEach($results as $result) {
                    $school = new School(
                        $result['school_name'],
                        $result['manager_name'],
                        $result['phone_number'],
                        $result['email'],
                        $result['business_address'],
                        $result['city'],
                        $result['state'],
                        $result['country'],
                        $result['zip'],
                        $result['type'],
                        $result['id']
                    );
                    array_push($schools, $school);
                }
                return $schools;
              } else {
                return false;
              }
          } else {
            return false;
          }
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM schools WHERE id = {$this->getId()};");
        }

        //Join Methods

        function addOwner($owner_id)
        {
          $stmt = $GLOBALS['DB']->prepare(
            "INSERT INTO owners_schools (owner_id, school_id) VALUES ( :owner_id, :school_id)");
          $stmt->bindParam(':owner_id', $owner_id, PDO::PARAM_STR);
          $stmt->bindParam(':school_id', $this->getId(), PDO::PARAM_STR);

          if($stmt->execute()) {
              return true;
          } else {
              return false;
          }
        }

        function addTeacher($teacher_id)
        {
            $GLOBALS['DB']->exec("INSERT INTO schools_teachers (school_id, teacher_id) VALUES ({$this->getId()}, {$teacher_id});");
        }

        function addCourse($course_id)
        {
            $GLOBALS['DB']->exec("INSERT INTO courses_schools (school_id, course_id) VALUES ({$this->getId()}, {$course_id});");
        }

        function addStudent($student_id)
        {
            $GLOBALS['DB']->exec("INSERT INTO schools_students (school_id, student_id) VALUES ({$this->getId()}, {$student_id});");
        }

        function addAccount($account_id)
        {
            $GLOBALS['DB']->exec("INSERT INTO accounts_schools (school_id, account_id) VALUES ({$this->getId()}, {$account_id});");
        }

        function addLesson($lesson_id)
        {
            $GLOBALS['DB']->exec("INSERT INTO lessons_schools (school_id, lesson_id) VALUES ({$this->getId()}, {$lesson_id});");
        }

        function addService($service_id)
        {
            $GLOBALS['DB']->exec("INSERT INTO schools_services (school_id, service_id) VALUES ({$this->getId()}, {$service_id})");
        }

        function getTeachers()
        {
            $query = $GLOBALS['DB']->query("SELECT teachers.* FROM schools JOIN schools_teachers ON schools.id = schools_teachers.school_id JOIN teachers ON schools_teachers.teacher_id = teachers.id WHERE schools.id = {$this->getId()};");
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

        function getCourses()
        {
            $query = $GLOBALS['DB']->query("SELECT courses.* FROM schools JOIN courses_schools ON schools.id = courses_schools.school_id JOIN courses ON courses_schools.course_id = courses.id WHERE schools.id = {$this->getId()};");
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

        function getStudents()
        {
            $query = $GLOBALS['DB']->query("SELECT students.* FROM schools JOIN schools_students ON (schools.id = schools_students.school_id) JOIN students ON (schools_students.student_id = students.id) WHERE schools.id = {$this->getId()};");
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
            var_dump($students);
        }

        function getAccounts()
        {
            $query = $GLOBALS['DB']->query("SELECT accounts.* FROM schools JOIN accounts_schools ON schools.id = accounts_schools.school_id JOIN accounts ON accounts_schools.account_id = accounts.id WHERE schools.id = {$this->getId()};");
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

        function getLessons()
        {
            $query = $GLOBALS['DB']->query("SELECT lessons.* FROM schools JOIN lessons_schools ON schools.id = lessons_schools.school_id JOIN lessons ON lessons_schools.lesson_id = lessons.id WHERE schools.id = {$this->getId()};");
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
            $query = $GLOBALS['DB']->query("SELECT services.* FROM schools JOIN schools_services ON (schools.id = schools_services.school_id) JOIN services ON (schools_services.service_id = services.id) WHERE schools.id = {$this->getId()};");
            $services = array();
            foreach($query as $service){
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
                $new_service = new Service($description, $duration, $price, $discount, $paid_for, $notes, $date_of_service, $recurrence, $attendance, $id);
                array_push($services, $new_service);
            }
            return $services;
        }

        // NOTE UNTESTED
        function removeTeacher($teacher_id)
        {
            $GLOBALS['DB']->exec("DELETE FROM schools_teachers WHERE teacher_id = {$teacher_id};");
            $GLOBALS['DB']->exec("DELETE FROM accounts_teachers WHERE teacher_id = {$teacher_id};");
            $GLOBALS['DB']->exec("DELETE FROM students_teachers WHERE teacher_id = {$teacher_id};");
            $GLOBALS['DB']->exec("DELETE FROM courses_teachers WHERE teacher_id = {$teacher_id};");

            return true;
        }

        // NOTE UNTESTED
        function removeStudent($student_id)
        {
            $GLOBALS['DB']->exec("DELETE FROM schools_students WHERE student_id = {$student_id};");
            $GLOBALS['DB']->exec("DELETE FROM accounts_students WHERE student_id = {$student_id};");
            $GLOBALS['DB']->exec("DELETE FROM students_teachers WHERE student_id = {$student_id};");
            $GLOBALS['DB']->exec("DELETE FROM courses_students WHERE student_id = {$student_id};");
        }

        static function csvToArray()
        {

            $array_of_rows = array_map('str_getcsv', file('jimi_attendance_march.csv'));

            return $array_of_rows;
        }

        function uploadAccounts()
        {
            $array_of_rows = array_map('str_getcsv', file('.csv'));

            //remove header
            $array_to_upload = array_splice($array_of_rows, 0, 10);

            // teacher ids
            // 1 | Jimi Marks
            // 2 | Emmanuel Mora
            // 3 | Roger Kim
            // 4 | Carlos Munoz Kampff

            //save to server
            foreach ($array_of_rows as $row) {

                $family_name = $row[0];
                $parent_one_name = $row[1];
                $parent_two_name = $row[2];
                $street_address = $row[3];
                $phone_number = $row[4];
                $email_address = $row[5];
                $student_one_name = $row[6];
                $teacher_one_id = $row[7];
                if ($row[8]!=0) {
                    $student_two_name = $row[8];
                }
                if ($row[9]!=0) {
                    $teacher_tow_id = $row[9];
                }
                $family = new Account($family_name, $parent_one_name, $parent_two_name, $street_address, $phone_number, $email_address);
                $family->save();
                $student_one = new Student($student_one_name);
                $family->addStudent($student_one);
                $school->addStudent($student_one);
                if ($row[7]!=0) {
                    $student_one->addTeacher($teacher_one_id);
                    $family->addTeacher($teacher_one_id);
                }
                if ($row[8]!=0) {
                $student_two = new Student($student_two_name);
                $family->addStudent($student_two);
                $school->addStudent($student_two);
                if ($row[9]!=0) {
                    $student_two->addTeacher($teacher_tow_id);
                    $family->addTeacher($teacher_tow_id);
                }
                $school->addAccount($family->getId());
                }
            }
        }

    }

 ?>
