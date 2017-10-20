<?php
class Account
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
    //NOTE create STATUS key.

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
    //   $GLOBALS['DB']->exec("INSERT INTO accounts (family_name, parent_one_name, parent_two_name, street_address, phone_number, email_address, notes, billing_history, outstanding_balance) VALUES ('{$this->getFamilyName()}', '{$this->getParentOneName()}', '{$this->getParentTwoName()}', '{$this->getStreetAddress()}', '{$this->getPhoneNumber()}', '{$this->getEmailAddress()}', '{$this->getNotes()}', '{$this->getBillingHistory()}', {$this->getOutstandingBalance()});");
    //   $this->id = $GLOBALS['DB']->lastInsertId();
    // }
    function save()
    {
      $GLOBALS['DB']->exec("INSERT INTO accounts (family_name, parent_one_name, parent_two_name, street_address, phone_number, email_address, notes, billing_history, outstanding_balance) VALUES ('{$this->getFamilyName()}', '{$this->getParentOneName()}', '{$this->getParentTwoName()}', '{$this->getStreetAddress()}', '{$this->getPhoneNumber()}', '{$this->getEmailAddress()}', '{$this->getNotes()}', '{$this->getBillingHistory()}', {$this->getOutstandingBalance()});");
      $this->id = $GLOBALS['DB']->lastInsertId();
    }

    static function getAll()
    {
        $returned_accounts = $GLOBALS['DB']->query("SELECT * FROM accounts;");
        $accounts = array();

        if (!empty($returned_accounts)) {
            foreach($returned_accounts as $account){
                $family_name = $account['family_name'];
                $parent_one_name = $account['parent_one_name'];
                $parent_two_name = $account['parent_two_name'];
                $street_address = $account['street_address'];
                $phone_number = $account['phone_number'];
                $email_address = $account['email_address'];
                $notes = $account['notes'];
                $billing_history = $account['billing_history'];
                $outstanding_balance = intval($account['outstanding_balance']);
                $id = $account['id'];
                $new_account = new Account($family_name, $parent_one_name,  $street_address, $phone_number, $email_address, $id);
                $new_account->setParentTwoName($parent_two_name);
                $new_account->setNotes($notes);
                $new_account->setBillingHistory($billing_history);
                $new_account->setOutstandingBalance($outstanding_balance);
                array_push($accounts, $new_account);
            }
        }

        return $accounts;
    }

    static function deleteAll()
    {
        $GLOBALS['DB']->exec("DELETE FROM accounts;");
    }

    static function find($account_id)
    {
        $stmt = $GLOBALS['DB']->prepare("SELECT accounts.* FROM accounts JOIN accounts_schools ON (accounts.id = accounts_schools.account_id) JOIN schools ON (accounts_schools.school_id = schools.id) WHERE accounts.id = :account_id AND schools.id = :school_id");

        $stmt->bindParam(':account_id', $account_id, PDO::PARAM_STR);
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

                return new Account(
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
                // account is not belong to the school
                return false;
            }
        } else {
            // sql failed for some reason
            return false;
        }
    }

    function delete()
    {
        $GLOBALS['DB']->exec("DELETE FROM accounts WHERE id = {$this->getId()};");
    }

    function updateFamilyName($family_name)
    {
        $stmt = $GLOBALS['DB']->prepare("UPDATE accounts SET family_name = :family_name WHERE id = :id");
        $stmt->bindParam(':family_name', $family_name, PDO::PARAM_STR);
        $stmt->bindParam(':id', $this->getId(), PDO::PARAM_STR);

        return $stmt->execute();
    }

    function updateParentOneName($parent_one_name)
    {
        $stmt = $GLOBALS['DB']->prepare("UPDATE accounts SET parent_one_name = :parent_one_name WHERE id = :id");
        $stmt->bindParam(':parent_one_name', $parent_one_name, PDO::PARAM_STR);
        $stmt->bindParam(':id', $this->getId(), PDO::PARAM_STR);

        return $stmt->execute();
    }

    function updateParentTwoName($parent_two_name)
    {
        $stmt = $GLOBALS['DB']->prepare("UPDATE accounts SET parent_two_name = :parent_two_name WHERE id = :id");
        $stmt->bindParam(':parent_two_name', $parent_two_name, PDO::PARAM_STR);
        $stmt->bindParam(':id', $this->getId(), PDO::PARAM_STR);

        return $stmt->execute();
    }

    function updateSteetAddress($street_address)
    {
        $stmt = $GLOBALS['DB']->prepare("UPDATE accounts SET street_address = :street_address WHERE id = :id");
        $stmt->bindParam(':street_address', $street_address, PDO::PARAM_STR);
        $stmt->bindParam(':id', $this->getId(), PDO::PARAM_STR);

        return $stmt->execute();
    }

    function updatePhoneNumber($phone_number)
    {
        $stmt = $GLOBALS['DB']->prepare("UPDATE accounts SET phone_number = :phone_number WHERE id = :id");
        $stmt->bindParam(':phone_number', $phone_number, PDO::PARAM_STR);
        $stmt->bindParam(':id', $this->getId(), PDO::PARAM_STR);

        return $stmt->execute();
    }

    function updateEmailAddress($email_address)
    {
        $stmt = $GLOBALS['DB']->prepare("UPDATE accounts SET email_address = :email_address WHERE id = :id");
        $stmt->bindParam(':email_address', $email_address, PDO::PARAM_STR);
        $stmt->bindParam(':id', $this->getId(), PDO::PARAM_STR);

        return $stmt->execute();
    }

    function updateNotes($update)
    {
        $GLOBALS['DB']->exec("UPDATE accounts SET notes = '{$update}' WHERE id = {$this->getId()};");
        $this->setNotes($update);
    }

    function updateBillingHistory($update)
    {
        $GLOBALS['DB']->exec("UPDATE accounts SET billing_history = '{$update}' WHERE id = {$this->getId()};");
        $this->setBillingHistory($update);
    }

    function updateOutstandingBalance($update)
    {
        $GLOBALS['DB']->exec("UPDATE accounts SET outstanding_balance = {$update} WHERE id = {$this->getId()};");
        $this->setOutstandingBalance($update);
    }

    // NOTE UNTESTED
    // Join functions
    function addTeacher($teacher_id)
    {
        $GLOBALS['DB']->exec("INSERT INTO accounts_teachers (account_id, teacher_id) VALUES ({$this->getId()}, {$teacher_id});");
    }
    // NOTE UNTESTED
    function addCourse($course_id)
    {
        $GLOBALS['DB']->exec("INSERT INTO courses_accounts (account_id, course_id) VALUES ({$this->getId()}, {$course_id});");
    }
    // NOTE UNTESTED
    function addStudent($student_id)
    {
        $GLOBALS['DB']->exec("INSERT INTO accounts_students (account_id, student_id) VALUES ({$this->getId()}, {$student_id});");
    }
    // NOTE UNTESTED
    function addLesson($lesson_id)
    {
        $GLOBALS['DB']->exec("INSERT INTO lessons_accounts (account_id, lesson_id) VALUES ({$this->getId()}, {$lesson_id});");
    }
    // NOTE UNTESTED
    function addService($service_id)
    {
        $GLOBALS['DB']->exec("INSERT INTO accounts_services (account_id, service_id) VALUES ({$this->getId()}, {$service_id})");
    }
    // NOTE UNTESTED
    function getTeachers()
    {
        $query = $GLOBALS['DB']->query("SELECT teachers.* FROM accounts JOIN accounts_teachers ON (accounts.id = accounts_teachers.account_id) JOIN teachers ON (accounts_teachers.teacher_id = teachers.id) WHERE accounts.id = {$this->getId()};");
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
        $query = $GLOBALS['DB']->query("SELECT courses.* FROM accounts JOIN accounts_courses ON (accounts.id = accounts_courses.account_id) JOIN courses ON (accounts_courses.course_id = courses.id) WHERE accounts.id = {$this->getId()};");
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
        $query = $GLOBALS['DB']->query("SELECT students.* FROM accounts JOIN accounts_students ON (accounts.id = accounts_students.account_id) JOIN students ON (accounts_students.student_id = students.id) WHERE accounts.id = {$this->getId()};");
        $students = array();
        foreach($query as $student) {
                $student_name = $student['student_name'];
                $id = intval($student['id']);
                $new_student = new Student($student_name, $id);
                $new_student->setNotes($student['notes']);
                array_push($students, $new_student);
        }
        return $students;
    }
    // NOTE UNTESTED
    function getLessons()
    {
        $query = $GLOBALS['DB']->query("SELECT lessons.* FROM accounts JOIN accounts_lessons ON (accounts.id = accounts_lessons.account_id) JOIN lessons ON (accounts_lessons.lesson_id = lessons.id) WHERE accounts.id = {$this->getId()};");
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
        $query = $GLOBALS['DB']->query("SELECT accounts.* FROM services JOIN accounts_services ON (services.id = accounts_services.service_id) JOIN accounts ON (accounts_services.account_id = accounts.id) WHERE services.id = {$this->getId()};");
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




}
?>
