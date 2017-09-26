<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
    require_once "src/Student.php";
    require_once "src/Teacher.php";
    require_once "src/Course.php";
    $server = 'mysql:host=localhost:8889;dbname=crm_music_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);
    class StudentTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Student::deleteAll();
            Teacher::deleteAll();
            Student::deleteJoin();
            Service::deleteAll();
            Account::deleteAll();

        }
        function test_getName()
        {
            // Arrange
            $input_name = "Bobster";
            $new_student = new Student($input_name);
            // Act
            $result = $new_student->getName();
            // Assert
            $this->assertEquals($input_name, $result);
        }
        //3
        function test_getId()
        {
            // Arrange
            $input_name = "Amanda";
            $input_id = 3;
            $new_student = new Student($input_name, $input_id);
            // Act
            $result = $new_student->getId();
            // Assert
            $this->assertEquals( true , is_numeric($result));
        }

        //5
        function test_save()
        {
            // Arrange
            $input_name = "Flavio";
            $input_notes = "Wow!";
            $new_student = new Student($input_name);
            $new_student->setNotes($input_notes);
            $new_student->save();
            // Act
            $result = Student::getAll();
            // Assert
            $this->assertEquals($new_student, $result[0]);
        }
        //6
        function test_notes()
        {
            // Arrange
            $input_name = "Dylan";
            $input_new_note = "had a great time!";
            $new_student_test = new Student($input_name);
            $new_student_test->setNotes($input_new_note);
            // Act
            $result = $new_student_test->getNotes();
            // Assert
            $this->assertEquals($input_new_note, $result);
        }
        // 7
        function test_getAll()
        {
            // Arrange
            $input_name = "Tester";
            $new_student_test = new Student($input_name);
            $new_student_test->save();
            $input_name2 = "Stina";
            $new_student2_test = new Student($input_name2);
            $new_student2_test->save();
            // Act
            $result = Student::getAll();
            // Assert
            $this->assertEquals(array($new_student_test, $new_student2_test), $result);
        }
        //8
        function test_save_notes()
        {
            // Arrange
            $input_name = "Flavio";
            $input_new_note = "Mangia que fa bene. - Nona ";
            $input_id = 1;
            $new_student = new Student($input_name);
            $new_student->setNotes($input_new_note);
            $new_student->save();
            // Act
            $result = Student::getAll();
            // Assert
            $this->assertEquals($new_student, $result[0]);
        }
        //9
        function testUpdateNotes()
        {
            //Arrange
            $input_name = "Test-9io ";
            $input_new_note = "Blah";
            $new_student = new Student($input_name);
            $new_student->setNotes($input_new_note);
            $new_student->save();
            $new_input_notes = "Had a great lesson.";
            //Act
            $new_student->updateNotes($new_input_notes);
            //Assert
            $this->assertEquals("Had a great lesson.Blah", $new_student->getNotes());
        }
        function testDelete()
        {
            //Arrange
            $input_name = "Test-is ";
            $input_new_note = "Blah";
            $new_student = new Student($input_name);
            $new_student->setNotes($input_new_note);
            $new_student->save();
            $input_name2 = "Test-osterone ";
            $input_new_note2 = "das";
            $new_student2 = new Student($input_name2);
            $new_student2->setNotes($input_new_note2);
            $new_student2->save();
            //Act
            $new_student->delete();
            //Assert
            $this->assertEquals([$new_student2], Student::getAll());
        }
        function test_findStudent()
        {
            // Arrange
            $input_name = "Stevo";
            $input_new_note = "Mangia que fa bene. - Nona  ";
            $new_student = new Student($input_name);
            $new_student->setNotes($input_new_note);
            $new_student->save();
            $id = $new_student->getId();
            // Act
            $result = Student::find($id);
            // Assert
            $this->assertEquals($new_student, $result);
        }
        function test_getTeachers()
        {
            // Arrange

            $input_name = "Test-is ";
            $input_instrument = "Horn";
            $input_new_note = "Blah";
            $new_teacher = new Teacher($input_name, $input_instrument);
            $new_teacher->setNotes($input_new_note);
            $new_teacher->save();
            $teacher_id = $new_teacher->getId();

            $input_name = "Stevo";
            $input_new_note = "Mangia que fa bene. - Nona  ";
            $new_student = new Student($input_name);
            $new_student->setNotes($input_new_note);
            $new_student->save();
            $new_student->addTeacher($teacher_id);

            // Act
            $result = $new_student->getTeachers();
            // Assert
            $this->assertEquals([$new_teacher], $result);
        }
        function test_getCourses()
        {
            // Arrange
            $input_name = "Stevo";
            $input_new_note = "Mangia que fa bene. - Nona  ";
            $new_student = new Student($input_name);
            $new_student->setNotes($input_new_note);
            $new_student->save();
            $input_title = "Basket weaving";
            $test_course = new Course($input_title);
            $test_course->save();
            $new_student->addCourse($test_course->getId());
            // Act
            $result = $new_student->getCourses();
            // Assert
            $this->assertEquals($test_course, $result[0]);
        }
        function test_getEnrollmentDate()
        {
            // Arrange
            $input_name = "Stevo";
            $input_instrument = "Ukulele";
            $input_teacher_id = 99;
            $input_new_note = "Mangia que fa bene. - Nona  ";
            $new_student = new Student($input_name, $input_instrument, $input_teacher_id);
            $new_student->setNotes($input_new_note);
            $new_student->save();
            $input_title = "Basket weaving";
            $test_course = new Course($input_title);
            $test_course->save();
            $new_student->addCourse($test_course->getId());
            // Act
            $result = $new_student->getDateOfEnrollment($test_course->getId());
            // Assert
            $this->assertEquals(date("Y-m-d h:i:s"), $result);
        }
        function test_addCourse()
        {
            // Arrange
            $input_name = "Mike";
            $input_instrument = "Banjo";
            $input_teacher_id = 99;
            $input_new_note = "Mangia que fa bene. - Nona  ";
            $new_student = new Student($input_name, $input_instrument, $input_teacher_id);
            $new_student->setNotes($input_new_note);
            $new_student->save();
            $input_title = "Science Fiction Novel";
            $test_course = new Course($input_title);
            $test_course->save();
            $test_course_id = $test_course->getId();
            $new_student->addCourse($test_course->getId());
            // $new_student->enrollInCourse($test_course->getId());
            // Act
            $result = $test_course->getStudents();
            // Assert
            // $this->assertEquals($test_course_id, 33);
            $this->assertEquals(1, count($result));
        }
        function test_updateName()
        {
            // Arrange
            $input_name = "Tester";
            $new_student_test = new Student("");
            $new_student_test->save();
            // Act
            $new_student_test->updateName($input_name);
            $result = Student::getAll();
            // Assert
            $this->assertEquals($input_name, $result[0]->getName());
        }

        function test_addPrivateSessionBatch()
        {
            // Arrange Service
            $service_description = "Test Music Lesson";
            $service_duration = 40;
            $service_price = 40;
            $service_discount = 95;
            $service_payed_for = 1;
            $service_notes = "Teacher was tardy.";
            $service_date_of_service = '2017-02-27 01:02:03';
            $service_recurrence = "Wednesdays|3:00pm";
            $service_attendance = "Attended";
            $service = new Service ($service_description, $service_duration, $service_price, $service_discount, $service_payed_for, $service_notes, $service_date_of_service, $service_recurrence, $service_attendance);
            $service->save();

            // Arrange Student
            $student_name = "Flavio";
            $student_notes = "Wow!";
            $student = new Student($student_name);
            $student->setNotes($student_notes);
            $student->save();

            // Arrange School
            $school = new School("school_name", "manager_name", "phone_number", "email", "business_address", "city", "state", "country", "zip", "type");
            $school->save();

            // Arrange Account
            $account_family_name = "Bobsters";
            $account_parent_one_name = "Lobster";
            $account_parent_two_name = "Momster";
            $account_street_address = "Under the sea";
            $account_phone_number = "555555555";
            $account_email_address = "fdsfsda@fdasfads";
            $account_notes = "happy clients";
            $account_billing_history = "200 for February";
            $account_outstanding_balance = 31;
            $account = new Account($account_family_name, $account_parent_one_name, $account_street_address, $account_phone_number, $account_email_address);
            $account->setParentTwoName($account_parent_two_name);
            $account->setNotes($account_notes);
            $account->setBillingHistory($account_billing_history);
            $account->setOutstandingBalance($account_outstanding_balance);
            $account->save();

            // Arrange Teacher
            $teacher = new Teacher("teacher_name", "instrument");
            $teacher->setNotes("test-note");
            $teacher->save();

            $repetitions = 5;

            // Add to Join
            $student->addPrivateSessionBatch($repetitions, $service_description, $service_duration, $service_price, $service_discount, $service_payed_for, $service_notes, $service_date_of_service, $service_recurrence, $service_attendance, $teacher, $school, $account);

            // Get from Join
            $result = $student->getServices();

            // Assert
            $this->assertEquals($service->getDescription(), $result[0]->getDescription());
        }

        
    }
 ?>
