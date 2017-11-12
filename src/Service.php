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

        // 2) create student->setSessionTemplate($teacher_id, $school_id, $client_id, $service_id) NOTE HAS TO DELETE PREVIOUS TEMPLATE!

        // 3) create student->findSessionTemplate($teacher_id);

        // 4) TODO description can serve as a link to the tokbox appointment, since it doesn't serve much of a function.

        function __construct($description, $duration, $price, $discount, $paid_for, $notes, $date_of_service, $recurrence, $attendance, $id = null)
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
            $stmt = $GLOBALS['DB']->prepare("
                INSERT INTO services (description, duration, price, discount, paid_for, notes, date_of_service, recurrence, attendance)
                VALUES (:description, :duration, :price, :discount, :paid_for, :notes, :date_of_service, :recurrence, :attendance)
            ");
            $stmt->bindParam(':description', $this->getDescription(), PDO::PARAM_STR);
            $stmt->bindParam(':duration', $this->getDuration(), PDO::PARAM_STR);
            $stmt->bindParam(':price', $this->getPrice(), PDO::PARAM_STR);
            $stmt->bindParam(':discount', $this->getDiscount(), PDO::PARAM_STR);
            $stmt->bindParam(':paid_for', $this->getPaidFor(), PDO::PARAM_STR);
            $stmt->bindParam(':notes', $this->getNotes(), PDO::PARAM_STR);
            $stmt->bindParam(':date_of_service', $this->getDateOfService(), PDO::PARAM_STR);
            $stmt->bindParam(':recurrence', $this->getRecurrence(), PDO::PARAM_STR);
            $stmt->bindParam(':attendance', $this->getAttendance(), PDO::PARAM_STR);

            if ($stmt->execute()) {
                $this->id = $GLOBALS['DB']->lastInsertId();
                return true;
            } else {
                return false;
            }
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

        // NOTE: 10/10 changed sql logic (it is following other find logic so it should be no problem but I am not checking it...koji)
        static function find($service_id)
        {
            $stmt = $GLOBALS['DB']->prepare("SELECT services.* FROM services JOIN schools_services ON (services.id = schools_services.service_id) JOIN schools ON (schools_services.school_id = schools.id) WHERE services.id = :service_id AND schools.id = :school_id");

            $stmt->bindParam(':service_id', $service_id, PDO::PARAM_STR);
            $stmt->bindParam(':school_id', $_SESSION['school_id'], PDO::PARAM_STR);

            if ($stmt->execute()) {
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($result) {
                    $description =  $result['description'];
                    $duration = $result['duration'];
                    $price = $result['price'];
                    $discount = $result['discount'];
                    $paid_for = $result['paid_for'];
                    $notes = $result['notes'];
                    $date_of_service = $result['date_of_service'];
                    $recurrence = $result['recurrence'];
                    $attendance = $result['attendance'];
                    $id = $result['id'];

                    return new Service(
                        $description,
                        $duration,
                        $price,
                        $discount,
                        $paid_for,
                        $notes,
                        $date_of_service,
                        $recurrence,
                        $attendance,
                        $id
                    );
                } else {
                  // service is not belong to the school
                  return false;
                }
            } else {
                // sql failed for some reason
                return false;
            }
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
        function addClient($client_id)
        {
            $GLOBALS['DB']->exec("INSERT INTO clients_services (service_id, client_id) VALUES ({$this->getId()}, {$client_id});");
        }
        // NOTE UNTESTED
        function addLesson($lesson_id)
        {
            $GLOBALS['DB']->exec("INSERT INTO lessons_services (service_id, lesson_id) VALUES ({$this->getId()}, {$lesson_id});");
        }

        function getTeacher()
        {
            $stmt = $GLOBALS['DB']->prepare("
                SELECT teachers.* FROM services
                JOIN services_teachers ON (services.id = services_teachers.service_id)
                JOIN teachers ON (services_teachers.teacher_id = teachers.id)
                WHERE services.id = :service_id
            ");
            $stmt->bindParam(':service_id', $this->getId(), PDO::PARAM_STR);

            if ($stmt->execute()) {
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($result) {
                    return new Teacher(
                        $result['teacher_name'],
                        $result['instrument'],
                        $result['id'],
                        $result['notes']
                    );
                } else {
                    //result not found
                    return false;
                }
            } else {
                // sql failed for some reason
                return false;
            }
        }

        // NOTE UNTESTED
        function getCourse()
        {
            $stmt = $GLOBALS['DB']->prepare("
                SELECT courses.* FROM services
                JOIN courses_services ON (services.id = courses_services.service_id)
                JOIN courses ON (courses_services.course_id = courses.id)
                WHERE services.id = :service_id
            ");
            $stmt->bindParam(':service_id', $this->getId(), PDO::PARAM_STR);

            if ($stmt->execute()) {
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($result) {
                    return new Course(
                        $result['title'],
                        $result['id']
                    );
                } else {
                    //result not found
                    return false;
                }
            } else {
                // sql failed for some reason
                return false;
            }
        }
        // NOTE UNTESTED
        function getStudent()
        {
            $stmt = $GLOBALS['DB']->prepare("
                SELECT students.* FROM services
                JOIN services_students ON (services.id = services_students.service_id)
                JOIN students ON (services_students.student_id = students.id)
                WHERE services.id = :service_id
            ");
            $stmt->bindParam(':service_id', $this->getId(), PDO::PARAM_STR);

            if ($stmt->execute()) {
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($result) {
                    return new Student(
                        $result['student_name'],
                        $result['email_address'],
                        $result['id'],
                        $result['notes']
                    );
                } else {
                    //result not found
                    return false;
                }
            } else {
                // sql failed for some reason
                return false;
            }
        }

        // NOTE UNTESTED
        function getClients()
        {
            $query = $GLOBALS['DB']->query("SELECT clients.* FROM services JOIN clients_services ON (services.id = clients_services.service_id) JOIN clients ON (clients_services.client_id = clients.id) WHERE services.id = {$this->getId()};");
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
