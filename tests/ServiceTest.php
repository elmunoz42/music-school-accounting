<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
    require_once "src/Service.php";
    require_once "src/Student.php";
    require_once "src/Teacher.php";
    $server = 'mysql:host=localhost:8889;dbname=crm_music_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);
    class ServiceTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Service::deleteAll();
            Teacher::deleteAll();
            Student::deleteAll();
        }
        // test 1
        function test_ServiceConstructor()
        {
            // Arrange
            $input_description = "Music Lesson";
            $input_duration = 40;
            $input_price = (float) 40;
            $input_discount = (float) 95;
            $input_payed_for = 1;
            $input_notes = "Teacher was tardy.";
            $input_date_of_service = '2017-02-27 01:02:03';
            $input_recurrence = "Wednesdays|3:00pm";
            $input_attendance = "Attended";
            $test_service = new Service ($input_description, $input_duration, $input_price, $input_discount, $input_payed_for, $input_notes, $input_date_of_service, $input_recurrence, $input_attendance);
            // Act
            $result1 = $test_service->getDescription();
            $result2 = $test_service->getDuration();
            $result3 = $test_service->getPrice();
            $result4 = $test_service->getDiscount();
            $result5 = $test_service->getPaidFor();
            $result6 = $test_service->getNotes();
            $result7 = $test_service->getDateOfService();
            $result8 = $test_service->getRecurrence();
            $result9 = $test_service->getAttendance();

            // Assert
            $this->assertEquals($input_description, $result1);
            $this->assertEquals($input_duration, $result2);
            $this->assertEquals($input_price, $result3);
            $this->assertEquals($input_discount, $result4);
            $this->assertEquals($input_payed_for, $result5);
            $this->assertEquals($input_notes, $result6);
            $this->assertEquals($input_date_of_service, $result7);
            $this->assertEquals($input_recurrence, $result8);
            $this->assertEquals($input_attendance, $result9);
        }
        // test 2
        function test_SaveGetAll()
        {
            // Arrange
            $input_description = "Music Lesson";
            $input_duration = 40;
            $input_price = 40;
            $input_discount = 95;
            $input_payed_for = 1;
            $input_notes = "Teacher was tardy.";
            $input_date_of_service = '2017-02-27 01:02:03';
            $input_recurrence = "Wednesdays|3:00pm";
            $input_attendance = "Attended";
            $test_service = new Service ($input_description, $input_duration, $input_price, $input_discount, $input_payed_for, $input_notes, $input_date_of_service, $input_recurrence, $input_attendance);
            $test_service->save();
            $test_service->getId();
            // Act
            $result = Service::getAll();
            // Assert
            $this->assertEquals($test_service, $result[0]);
        }
        // test 3
        function test_deleteAll()
        {
            // Arrange
            $input_description = "Music Lesson";
            $input_duration = 40;
            $input_price = 40;
            $input_discount = 95;
            $input_payed_for = 1;
            $input_notes = "Teacher was tardy.";
            $input_date_of_service = '2017-02-27 01:02:03';
            $input_recurrence = "Wednesdays|3:00pm";
            $input_attendance = "Attended";
            $test_service = new Service ($input_description, $input_duration, $input_price, $input_discount, $input_payed_for, $input_notes, $input_date_of_service, $input_recurrence, $input_attendance);
            $test_service->save();
            $test_service->getId();
            // Act
            Service::deleteAll();
            $result = Service::getAll();
            // Assert
            $this->assertEquals(array(), $result);
        }
        function test_updateDescription()
        {
            // Arrange
            $input_description = "Music Lesson";
            $input_duration = 40;
            $input_price = 40;
            $input_discount = 95;
            $input_payed_for = 1;
            $input_notes = "Teacher was tardy.";
            $input_date_of_service = '2017-02-27 01:02:03';
            $input_recurrence = "Wednesdays|3:00pm";
            $input_attendance = "Attended";
            $test_service = new Service ($input_description, $input_duration, $input_price, $input_discount, $input_payed_for, $input_notes, $input_date_of_service, $input_recurrence, $input_attendance);
            $test_service->save();
            $test_service->getId();
            $test_service->updateDescription("Golf Lesson");
            // Act
            $result = Service::getAll();
            // Assert
            $this->assertEquals($test_service, $result[0]);
        }
        function test_updateDuration()
        {
            // Arrange
            $input_description = "Music Lesson";
            $input_duration = 40;
            $input_price = 40;
            $input_discount = 95;
            $input_payed_for = 1;
            $input_notes = "Teacher was tardy.";
            $input_date_of_service = '2017-02-27 01:02:03';
            $input_recurrence = "Wednesdays|3:00pm";
            $input_attendance = "Attended";
            $test_service = new Service ($input_description, $input_duration, $input_price, $input_discount, $input_payed_for, $input_notes, $input_date_of_service, $input_recurrence, $input_attendance);
            $test_service->save();
            $test_service->getId();
            $test_service->updateDuration(90);
            // Act
            $result = Service::getAll();
            // Assert
            $this->assertEquals($test_service, $result[0]);
        }
        function test_updatePrice()
        {
            // Arrange
            $input_description = "Music Lesson";
            $input_duration = 40;
            $input_price = 40;
            $input_discount = 95;
            $input_payed_for = 1;
            $input_notes = "Teacher was tardy.";
            $input_date_of_service = '2017-02-27 01:02:03';
            $input_recurrence = "Wednesdays|3:00pm";
            $input_attendance = "Attended";
            $test_service = new Service ($input_description, $input_duration, $input_price, $input_discount, $input_payed_for, $input_notes, $input_date_of_service, $input_recurrence, $input_attendance);
            $test_service->save();
            $test_service->getId();
            $test_service->updatePrice(50);
            // Act
            $result = Service::getAll();
            // Assert
            $this->assertEquals($test_service, $result[0]);
        }
        function test_updateDiscount()
        {
            // Arrange
            $input_description = "Music Lesson";
            $input_duration = 40;
            $input_price = 40;
            $input_discount = 95;
            $input_payed_for = 1;
            $input_notes = "Teacher was tardy.";
            $input_date_of_service = '2017-02-27 01:02:03';
            $input_recurrence = "Wednesdays|3:00pm";
            $input_attendance = "Attended";
            $test_service = new Service ($input_description, $input_duration, $input_price, $input_discount, $input_payed_for, $input_notes, $input_date_of_service, $input_recurrence, $input_attendance);
            $test_service->save();
            $test_service->getId();
            $test_service->updateDiscount(92);
            // Act
            $result = Service::getAll();
            // Assert
            $this->assertEquals($test_service, $result[0]);
        }
        function test_updatePaidFor()
        {
            // Arrange
            $input_description = "Music Lesson";
            $input_duration = 40;
            $input_price = 40;
            $input_discount = 95;
            $input_payed_for = 1;
            $input_notes = "Teacher was tardy.";
            $input_date_of_service = '2017-02-27 01:02:03';
            $input_recurrence = "Wednesdays|3:00pm";
            $input_attendance = "Attended";
            $test_service = new Service ($input_description, $input_duration, $input_price, $input_discount, $input_payed_for, $input_notes, $input_date_of_service, $input_recurrence, $input_attendance);
            $test_service->save();
            $test_service->getId();
            $test_service->updatePaidFor(0);
            // Act
            $result = Service::getAll();
            // Assert
            $this->assertEquals($test_service, $result[0]);
        }

        function test_findService()
        {
            // Arrange
            $input_description = "Music Lesson";
            $input_duration = 40;
            $input_price = 40;
            $input_discount = 95;
            $input_payed_for = 1;
            $input_notes = "Teacher was tardy.";
            $input_date_of_service = '2017-02-27 01:02:03';
            $input_recurrence = "Wednesdays|3:00pm";
            $input_attendance = "Attended";
            $test_service = new Service ($input_description, $input_duration, $input_price, $input_discount, $input_payed_for, $input_notes, $input_date_of_service, $input_recurrence, $input_attendance);
            $test_service->save();
            $test_service->getId();
            // Act
            $result = Service::find($test_service->getId());
            // Assert
            $this->assertEquals($test_service, $result);
        }

    }
 ?>
