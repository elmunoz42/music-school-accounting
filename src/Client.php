<?php
class Client
{
    private $family_name;
    private $parent_one_name;
    private $parent_two_name;
    private $street_address;
    private $phone_number;
    private $email_address;
    private $notes;
    private $billing_history;
    private $outstanding_balance;
    private $id;

    function __construct($family_name, $parent_one_name, $street_address, $phone_number, $email_address, $id = null, $parent_two_name = null, $notes = null, $billing_history = null, $outstanding_balance = null)
    {
        $this->family_name = $family_name;
        $this->parent_one_name = $parent_one_name;
        $this->street_address = $street_address;
        $this->phone_number = $phone_number;
        $this->email_address = $email_address;
        $this->id = $id;
        $this->parent_two_name = $parent_two_name;
        $this->notes = $notes;
        $this->billing_history = $billing_history;
        $this->outstanding_balance = $outstanding_balance;
    }

    // getters
    function getFamilyName()
    {
        return $this->family_name;
    }

    function getParentOneName()
    {
        return $this->parent_one_name;
    }

    function getParentTwoName()
    {
        return $this->parent_two_name;
    }

    function getStreetAddress()
    {
        return $this->street_address;
    }

    function getPhoneNumber()
    {
        return $this->phone_number;
    }

    function getEmailAddress()
    {
        return $this->email_address;
    }

    function getNotes()
    {
        return $this->notes;
    }

    function getBillingHistory()
    {
        return $this->billing_history;
    }

    function getOutstandingBalance()
    {
        return $this->outstanding_balance;
    }
    function getId()
    {
        return  $this->id;
    }

    // setters
    function setFamilyName($new_family_name)
    {
        $this->family_name = $new_family_name;
    }

    function setParentOneName($new_parent_one_name)
    {
        $this->parent_one_name = $new_parent_one_name;
    }

    function setParentTwoName($new_parent_two_name)
    {
        $this->parent_two_name = $new_parent_two_name;
    }

    function setStreetAddress($new_street_address)
    {
        $this->street_address = $new_street_address;
    }

    function setPhoneNumber($new_phone_number)
    {
      $this->phone_number = $new_phone_number;
    }

    function setEmailAddress($new_email_address)
    {
      $this->email_address = $new_email_address;
    }

    function setNotes($new_note)
    {
      $this->notes = $new_note . $this->notes;
    }

    function setBillingHistory($new_billing_history)
    {
      $this->billing_history = $new_billing_history . $this->billing_history;
    }

    function setOutstandingBalance($new_outstanding_balance)
    {
      $this->outstanding_balance = $new_outstanding_balance;
    }

    function setId()
    {
        $this->id = $id;
    }

    // function save()
    // {
    //   $GLOBALS['DB']->exec("INSERT INTO clients (family_name, parent_one_name, parent_two_name, street_address, phone_number, email_address, notes, billing_history, outstanding_balance) VALUES ('{$this->getFamilyName()}', '{$this->getParentOneName()}', '{$this->getParentTwoName()}', '{$this->getStreetAddress()}', '{$this->getPhoneNumber()}', '{$this->getEmailAddress()}', '{$this->getNotes()}', '{$this->getBillingHistory()}', {$this->getOutstandingBalance()});");
    //   $this->id = $GLOBALS['DB']->lastInsertId();
    // }
    function save()
    {
      $stmt = $GLOBALS['DB']->prepare("
          INSERT INTO clients (family_name, parent_one_name, parent_two_name, street_address, phone_number, email_address, notes, billing_history, outstanding_balance)
          VALUES (:family_name, :parent_one_name, :parent_two_name, :street_address, :phone_number, :email_address, :notes, :billing_history, :outstanding_balance)
      ");
      $stmt->bindParam(':family_name', $this->getFamilyName(), PDO::PARAM_STR);
      $stmt->bindParam(':parent_one_name', $this->getParentOneName(), PDO::PARAM_STR);
      $stmt->bindParam(':parent_two_name', $this->getParentTwoName(), PDO::PARAM_STR);
      $stmt->bindParam(':street_address', $this->getStreetAddress(), PDO::PARAM_STR);
      $stmt->bindParam(':phone_number', $this->getPhoneNumber(), PDO::PARAM_STR);
      $stmt->bindParam(':email_address', $this->getEmailAddress(), PDO::PARAM_STR);
      $stmt->bindParam(':notes', $this->getNotes(), PDO::PARAM_STR);
      $stmt->bindParam(':billing_history', $this->getBillingHistory(), PDO::PARAM_STR);
      $stmt->bindParam(':outstanding_balance', $this->getOutstandingBalance(), PDO::PARAM_STR);

      if ($stmt->execute()) {
          $this->id = $GLOBALS['DB']->lastInsertId();
          return true;
      } else {
          return false;
      }
    }

    static function getAll()
    {
        $returned_clients = $GLOBALS['DB']->query("SELECT * FROM clients;");
        $clients = array();

        if (!empty($returned_clients)) {
            foreach($returned_clients as $client){
                $family_name = $client['family_name'];
                $parent_one_name = $client['parent_one_name'];
                $parent_two_name = $client['parent_two_name'];
                $street_address = $client['street_address'];
                $phone_number = $client['phone_number'];
                $email_address = $client['email_address'];
                $notes = $client['notes'];
                $billing_history = $client['billing_history'];
                $outstanding_balance = intval($client['outstanding_balance']);
                $id = $client['id'];
                $new_client = new Client($family_name, $parent_one_name,  $street_address, $phone_number, $email_address, $id);
                $new_client->setParentTwoName($parent_two_name);
                $new_client->setNotes($notes);
                $new_client->setBillingHistory($billing_history);
                $new_client->setOutstandingBalance($outstanding_balance);
                array_push($clients, $new_client);
            }
        }

        return $clients;
    }

    static function deleteAll()
    {
        $GLOBALS['DB']->exec("DELETE FROM clients;");
    }

    static function find($client_id)
    {
        $stmt = $GLOBALS['DB']->prepare("SELECT clients.* FROM clients JOIN clients_schools ON (clients.id = clients_schools.client_id) JOIN schools ON (clients_schools.school_id = schools.id) WHERE clients.id = :client_id AND schools.id = :school_id");

        $stmt->bindParam(':client_id', $client_id, PDO::PARAM_STR);
        $stmt->bindParam(':school_id', $_SESSION['school_id'], PDO::PARAM_STR);

        if ($stmt->execute()) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                $family_name = $result['family_name'];
                $parent_one_name = $result['parent_one_name'];
                $parent_two_name = $result['parent_two_name'];
                $street_address = $result['street_address'];
                $phone_number = $result['phone_number'];
                $email_address = $result['email_address'];
                $notes = $result['notes'];
                $billing_history = $result['billing_history'];
                $outstanding_balance = $result['outstanding_balance'];
                $id = $result['id'];
                $parent_two_name = $result['parent_two_name'];
                $notes = $result['notes'];
                $billing_history = $result['billing_history'];
                $outstanding_balance = $result['outstanding_balance'];

                return new Client(
                    $family_name,
                    $parent_one_name,
                    $street_address,
                    $phone_number,
                    $email_address,
                    $id,
                    $parent_two_name,
                    $notes,
                    $billing_history,
                    $outstanding_balance
              );
            } else {
                // client is not belong to the school
                return false;
            }
        } else {
            // sql failed for some reason
            return false;
        }
    }

    static function search($search_input)
    {
        $search_input = '%' . $search_input . '%';
        $stmt = $GLOBALS['DB']->prepare("
                SELECT clients.* FROM clients
                JOIN clients_schools
                ON (clients.id = clients_schools.client_id)
                JOIN schools ON (clients_schools.school_id = schools.id)
                WHERE clients.family_name LIKE :search_input
                OR clients.parent_one_name LIKE :search_input
                OR clients.parent_two_name LIKE :search_input
                OR clients.street_address LIKE :search_input
                OR clients.phone_number LIKE :search_input
                OR clients.email_address LIKE :search_input
                AND schools.id = :school_id
            ");

        $stmt->bindParam(':search_input', $search_input, PDO::PARAM_STR);
        $stmt->bindParam(':school_id', $_SESSION['school_id'], PDO::PARAM_STR);

        if ($stmt->execute()) {
            $results = $stmt->fetchAll();

            if ($results) {
                $clients = [];
                forEach($results as $result) {
                    $client = new Client(
                        $result['family_name'],
                        $result['parent_one_name'],
                        $result['street_address'],
                        $result['phone_number'],
                        $result['email_address'],
                        $result['id'],
                        $result['parent_two_name'],
                        $result['notes'],
                        $result['billing_history'],
                        $result['outstanding_balance']
                    );
                    array_push($clients, $client);
                }
                return $clients;
            } else {
                // any clients are not belong to the school
                return false;
            }
        } else {
            // sql failed for some reason
            return false;
        }
    }

    function delete()
    {
        $stmt = $GLOBALS['DB']->prepare("DELETE FROM clients WHERE id = :id");
        $stmt->bindParam(':id', $this->getId(), PDO::PARAM_STR);

        return $stmt->execute();
    }

    function updateFamilyName($family_name)
    {
        $stmt = $GLOBALS['DB']->prepare("UPDATE clients SET family_name = :family_name WHERE id = :id");
        $stmt->bindParam(':family_name', $family_name, PDO::PARAM_STR);
        $stmt->bindParam(':id', $this->getId(), PDO::PARAM_STR);

        return $stmt->execute();
    }

    function updateParentOneName($parent_one_name)
    {
        $stmt = $GLOBALS['DB']->prepare("UPDATE clients SET parent_one_name = :parent_one_name WHERE id = :id");
        $stmt->bindParam(':parent_one_name', $parent_one_name, PDO::PARAM_STR);
        $stmt->bindParam(':id', $this->getId(), PDO::PARAM_STR);

        return $stmt->execute();
    }

    function updateParentTwoName($parent_two_name)
    {
        $stmt = $GLOBALS['DB']->prepare("UPDATE clients SET parent_two_name = :parent_two_name WHERE id = :id");
        $stmt->bindParam(':parent_two_name', $parent_two_name, PDO::PARAM_STR);
        $stmt->bindParam(':id', $this->getId(), PDO::PARAM_STR);

        return $stmt->execute();
    }

    function updateSteetAddress($street_address)
    {
        $stmt = $GLOBALS['DB']->prepare("UPDATE clients SET street_address = :street_address WHERE id = :id");
        $stmt->bindParam(':street_address', $street_address, PDO::PARAM_STR);
        $stmt->bindParam(':id', $this->getId(), PDO::PARAM_STR);

        return $stmt->execute();
    }

    function updatePhoneNumber($phone_number)
    {
        $stmt = $GLOBALS['DB']->prepare("UPDATE clients SET phone_number = :phone_number WHERE id = :id");
        $stmt->bindParam(':phone_number', $phone_number, PDO::PARAM_STR);
        $stmt->bindParam(':id', $this->getId(), PDO::PARAM_STR);

        return $stmt->execute();
    }

    function updateEmailAddress($email_address)
    {
        $stmt = $GLOBALS['DB']->prepare("UPDATE clients SET email_address = :email_address WHERE id = :id");
        $stmt->bindParam(':email_address', $email_address, PDO::PARAM_STR);
        $stmt->bindParam(':id', $this->getId(), PDO::PARAM_STR);

        return $stmt->execute();
    }

    function updateNotes($new_note)
    {
        $stmt = $GLOBALS['DB']->prepare("UPDATE clients SET notes = :new_note WHERE id = :id");
        $stmt->bindParam(':new_note', $new_note, PDO::PARAM_STR);
        $stmt->bindParam(':id', $this->getId(), PDO::PARAM_STR);
        return $stmt->execute();
    }

    function updateBillingHistory($update)
    {
        $GLOBALS['DB']->exec("UPDATE clients SET billing_history = '{$update}' WHERE id = {$this->getId()};");
        $this->setBillingHistory($update);
    }

    function updateOutstandingBalance($update)
    {
        $GLOBALS['DB']->exec("UPDATE clients SET outstanding_balance = {$update} WHERE id = {$this->getId()};");
        $this->setOutstandingBalance($update);
    }

    // NOTE UNTESTED
    // Join functions
    function addTeacher($teacher_id)
    {
        $GLOBALS['DB']->exec("INSERT INTO clients_teachers (client_id, teacher_id) VALUES ({$this->getId()}, {$teacher_id});");
    }
    // NOTE UNTESTED
    function addCourse($course_id)
    {
        $GLOBALS['DB']->exec("INSERT INTO courses_clients (client_id, course_id) VALUES ({$this->getId()}, {$course_id});");
    }
    // NOTE UNTESTED
    function addStudent($student_id)
    {
        $GLOBALS['DB']->exec("INSERT INTO clients_students (client_id, student_id) VALUES ({$this->getId()}, {$student_id});");
    }
    // NOTE UNTESTED
    function addLesson($lesson_id)
    {
        $GLOBALS['DB']->exec("INSERT INTO lessons_clients (client_id, lesson_id) VALUES ({$this->getId()}, {$lesson_id});");
    }
    // NOTE UNTESTED
    function addService($service_id)
    {
        $GLOBALS['DB']->exec("INSERT INTO clients_services (client_id, service_id) VALUES ({$this->getId()}, {$service_id})");
    }

    function addUser($user_id)
    {
        $stmt = $GLOBALS['DB']->prepare("
            INSERT INTO users_clients (user_id, client_id)
            VALUES (:user_id, :client_id)
        ");
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);
        $stmt->bindParam(':client_id', $this->getId(), PDO::PARAM_STR);

        return $stmt->execute();
    }

    // NOTE UNTESTED
    function getTeachers()
    {
        $query = $GLOBALS['DB']->query("SELECT teachers.* FROM clients JOIN clients_teachers ON (clients.id = clients_teachers.client_id) JOIN teachers ON (clients_teachers.teacher_id = teachers.id) WHERE clients.id = {$this->getId()};");
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
        $query = $GLOBALS['DB']->query("SELECT courses.* FROM clients JOIN clients_courses ON (clients.id = clients_courses.client_id) JOIN courses ON (clients_courses.course_id = courses.id) WHERE clients.id = {$this->getId()};");
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
        $stmt = $GLOBALS['DB']->prepare("
            SELECT students.* FROM clients
            JOIN clients_students ON (clients.id = clients_students.client_id)
            JOIN students ON (clients_students.student_id = students.id) WHERE clients.id = :client_id
        ");

        $stmt->bindParam(':client_id', $this->getId(), PDO::PARAM_STR);

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
    }

    function findStudentById($student_id) {
        $stmt = $GLOBALS['DB']->prepare("SELECT students.* FROM clients JOIN clients_students ON (clients.id = clients_students.client_id) JOIN students ON (clients_students.student_id = students.id) WHERE clients.id = :client_id AND students.id = :student_id");

        $stmt->bindParam(':client_id', $this->getId(), PDO::PARAM_STR);
        $stmt->bindParam(':student_id', $student_id, PDO::PARAM_STR);

        if ($stmt->execute()) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                $student_name =  $result['student_name'];
                $id = $result['id'];
                $email_address = $result['email_address'];
                $notes = $result['notes'];

                return new Student($student_name, $email_address, $id, $notes);
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
    function getLessons()
    {
        $query = $GLOBALS['DB']->query("SELECT lessons.* FROM clients JOIN clients_lessons ON (clients.id = clients_lessons.client_id) JOIN lessons ON (clients_lessons.lesson_id = lessons.id) WHERE clients.id = {$this->getId()};");
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

    // NOTE unstested
    function getServices()
    {
      $stmt = $GLOBALS['DB']->prepare("
        SELECT services.* FROM clients
        JOIN clients_services ON (clients.id = clients_services.client_id)
        JOIN services ON (clients_services.service_id = services.id)
        WHERE clients.id = :client_id"
      );
      $stmt->bindParam(':client_id', $this->getId(), PDO::PARAM_STR);

      if($stmt->execute()) {
          $results = $stmt->fetchAll();
          if ($results) {
            $services = [];
            forEach($results as $service) {
                $service = new Service(
                    $result['description'],
                    $result['price'],
                    $result['discount'],
                    $result['paid_for'],
                    $result['notes'],
                    $result['date_of_service'],
                    $result['recurrence'],
                    $result['attendance'],
                    $result['id']
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


    function deleteStudents($students)
    {
        foreach ($students as $student) {
            $stmt = $GLOBALS['DB']->prepare("DELETE FROM students WHERE id = :id");
            $stmt->bindParam(':id', $student->getId(), PDO::PARAM_STR);

            if (!$stmt->execute()) {
                return false;
            } else {
                continue;
            }
        }
        return true;
    }

    function findClientByUserId($user_id)
    {
        //TODO: check if this function works after relationship table is created
        $stmt = $GLOBALS['DB']->prepare("
            SELECT clients.* FROM clients
            JOIN users_clients ON (clients.id = users_clients.client_id)
            JOIN owners ON (users_clients.user_id = owners.id)
            WHERE owners.id = :user_id
        ");

        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);

        if ($stmt->execute()) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                $client = new Client(
                    $result['family_name'],
                    $result['parent_one_name'],
                    $result['street_address'],
                    $result['phone_number'],
                    $result['email_address'],
                    $result['id'],
                    $result['parent_two_name'],
                    $result['notes'],
                    $result['billing_history'],
                    $result['outstanding_balance']
                );
                return $client;
            } else {
                // client is not found
                return false;
            }
        } else {
            // sql failed for some reason
            return false;
        }
    }
}
