<?php
class Database
{
    protected $connect;
    private $dbInstance;
    public function __construct($host, $user, $password, $dbname) {                                //установить соединение с базой данных при создании объекта этого класса,    
        $this -> dbInstance = DatabaseSingleton::getInstance($host, $user, $password, $dbname);    //используя Singleton для обеспечения единственного экземпляра соединения 
        $this -> connect = $this -> dbInstance -> getConnect();                                    //с базой данных на протяжении жизненного цикла приложения
    }
    public function getGroups()
    {
        $query = "SELECT * FROM students JOIN direction  
            ON students.course_direction = direction.id_direction";
        $stmt = $this->connect->prepare($query); //Защита от sql-иньекций
        $stmt->execute();                        //Запуск выполнения подготовленного запроса к базе данных
        $result = $stmt->get_result();          //После выполнения запроса получаем результат запроса с помощью метода
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        return $data;
    }
    public function getList($idDirection) 
    {
        $query = "SELECT * FROM students WHERE course_direction = ?";
        $stmt = $this->connect->prepare($query);
        $stmt->bind_param("i", $idDirection); 
        $stmt->execute();
        $result = $stmt->get_result();

        $students = array();
        while ($row = $result->fetch_assoc()) {
            $students[] = $row;
        }

        return $students;
    }
    public function getCourse()
    {
        $query = "SELECT * FROM direction";
        $stmt = $this->connect->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();

        $data_course = array();
        while ($row_course = $result->fetch_assoc()) {
            $data_course[] = $row_course;
        }

        return $data_course;
    }

    public function addGroup($img_student, $name_student, $course_direction, $name_group, $year)
    {
        $query = "INSERT INTO students (img_student, name_student, course_direction, name_group, year) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->connect->prepare($query);
        $stmt->bind_param("ssisi", $img_student, $name_student, $course_direction, $name_group, $year);  //метод подготовленного выражения, используемый для привязки переменных к параметрам в SQL запросе
        if ($stmt->execute()) {
            echo "Data added successfully";
        } else {
            echo "Error adding data: " . $stmt->error;
        }
    }

    public function addCourse($name_direction)
    {
        $query = "INSERT INTO direction (name_direction) VALUES (?)";
        $stmt = $this->connect->prepare($query);
        $stmt->bind_param("s", $name_direction);
        $stmt->execute();
    }
    public function updateGroup($id, $img_student, $name_student, $course_direction, $name_group, $year)
    {
        $query = "UPDATE students SET `img_student` = ?, `name_student` = ?, `course_direction` = ?, `name_group` = ?, `year` = ? WHERE id = ?";
        $stmt = $this->connect->prepare($query);
        $stmt->bind_param("ssisii", $img_student, $name_student, $course_direction, $name_group, $year, $id);
        $stmt->execute();
    }

    public function updateCourse($id_direction, $name_direction)
    {
        $this->connect->begin_transaction(); // Начинаем транзакцию(все последующие операции с базой данных будут представлять одну атомарную операцию, и либо все операции будут успешно завершены, либо ни одна из них не будет выполнена)

        $query1 = "UPDATE direction SET name_direction = ? WHERE id_direction = ?";
        $stmt1 = $this->connect->prepare($query1);
        $stmt1->bind_param("si", $name_direction, $id_direction);
        $result1 = $stmt1->execute();

        if ($result1) {
            $query2 = "UPDATE students SET course_direction = ? WHERE course_direction = ?";
            $stmt2 = $this->connect->prepare($query2);
            $stmt2->bind_param("ii", $id_direction, $id_direction); // Обновляем значения связанных записей
            $result2 = $stmt2->execute();

            if (!$result2) {
                $this->connect->rollback(); // Откатываем транзакцию в случае ошибки
            } else {
                $this->connect->commit(); // Фиксируем транзакцию
            }
        } else {
            $this->connect->rollback(); // Откатываем транзакцию в случае ошибки
        }
    }
    public function getConnect() {
        return $this->connect;
    }

    public function deleteGroup($id)
    {
        $query = "DELETE FROM students WHERE id = ?";
        $stmt = $this->connect->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }

    public function checkStudentsInDirection($id_direction)
    {
        $query = "SELECT * FROM students WHERE course_direction = ?";
        $stmt = $this->connect->prepare($query);
        $stmt->bind_param("i", $id_direction);
        $stmt->execute();
        $result = $stmt->get_result();

        $students = array();
        while ($row = $result->fetch_assoc()) {
            $students[] = $row;
        }

        return $students;
    }

    public function deleteDirection($id_direction)
    {
        if (!$this->checkStudentsInDirection($id_direction)) {
        $query = "DELETE FROM direction WHERE id_direction = ?";
        $stmt = $this->connect->prepare($query);
        $stmt->bind_param("i", $id_direction);
        $stmt->execute();
        //header('Location: course.php');
    } else {
        // Обработка случая, когда студенты найдены
        echo "Направление содержит студентов. Удаление невозможно.";
    }
    }
    
}

class DatabaseSingleton  // создать единственное соединение с базой данных
{
    private static $instance = null;
    private $connect;
    
    private function __construct($host, $user, $password, $dbname)
    {
        $this->connect = new mysqli($host, $user, $password, $dbname);
        if ($this->connect->connect_error) {
            die("Connection failed: " . $this->connect->connect_error);
        }
    }

    public static function getInstance($host, $user, $password, $dbname)
    {
        if (self::$instance == null) {
            self::$instance = new DatabaseSingleton($host, $user, $password, $dbname);               //self - используется для доступа к статическим свойствам и методам внутри класса без создания экземпляра этого класса
        }
        return self::$instance;
    }

    public function getConnect() {
        return $this->connect;
    }
    
}

$host = "localhost"; 
$user = "root"; 
$password = ""; 
$dbname = "lb-1"; 

$database = new Database($host, $user, $password, $dbname);
$data = $database->getGroups();
$data_course = $database->getCourse();
?>