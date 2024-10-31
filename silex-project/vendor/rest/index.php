<?php
require_once 'C:\ProgrammingTechnologiesForTheInternet2Semestr\Лабораторная 3\silex-project\vendor\autoload.php';
require_once 'C:\ProgrammingTechnologiesForTheInternet2Semestr\Лабораторная 3\silex-project\vendor\rest\logic.php'; 

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$app = new Silex\Application();

// Middleware для обработки CORS
$app->after(function (Request $request, Response $response) {
    // Разрешить доступ с определенного источника
    $response->headers->set('Access-Control-Allow-Origin', 'http://localhost:8080');
    // Разрешить использование любых методов запросов
    $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
    // Разрешить отправку заголовков авторизации и других пользовательских заголовков
    $response->headers->set('Access-Control-Allow-Headers', 'Origin, Content-Type, Accept, Authorization');
    // Для CORS запроса OPTIONS также установим заголовок Allow-Control-Allow-Credentials
    if ($request->getMethod() == 'OPTIONS') {
        $response->headers->set('Access-Control-Allow-Credentials', 'true');
    }
});

$host = "localhost"; 
$user = "root"; 
$password = ""; 
$dbname = "lb-1"; 
$database = new Database($host, $user, $password, $dbname);

// Маршрут для получения списка студентов
$app->get('/', function() use ($database) {
    $students = $database->getGroups();
    return json_encode($students);
});
// Маршрут для получения списка направлений
$app->get('/course', function() use ($database) {
    $students = $database->getCourse();
    return json_encode($students);
});

// Маршрут для удаления студента по ID
$app->delete('/{id}', function ($id, Request $request) use ($database) {
    if ($request->getMethod() === 'DELETE') {
        $database->deleteGroup($id);
        return new Response("Student with ID $id successfully deleted", 200);
    } else {
        return new Response("Method Not Allowed", 405);
    }
});

// Маршрут для удаления направления по id_direction
$app->delete('/course/{id_direction}', function ($id_direction, Request $request) use ($database) {
    if ($request->getMethod() === 'DELETE') {
        $database->deleteDirection($id_direction);
        return new Response("Course with ID $id_direction successfully deleted", 200);
    } else {
        return new Response("Method Not Allowed", 405);
    }
});


// добавляем обработку CORS для запросов DELETE
$app->options('/{id}', function ($id, Request $request) use ($app) {
    return '';
});

// добавляем обработку CORS для запросов DELETE
$app->options('/course/{id_direction}', function ($id_direction, Request $request) use ($app) {
    return '';
});


// Обработка PUT запроса
$app->match('/{id}', function ($id, Request $request) use ($app, $database) {
    if ($request->isMethod('PUT')) {
        // Получаем данные из тела запроса
        $data = json_decode($request->getContent(), true);

        // Дополнительные данные, которые могут прийти из формы\
        $id = filter_var($data['id'], FILTER_VALIDATE_INT);
        $img_student = mysqli_real_escape_string($database->getConnect(), $data['img_student']); 
        $name_student = mysqli_real_escape_string($database->getConnect(), $data['name_student']);
        $course_direction = filter_var($data['course_direction'], FILTER_VALIDATE_INT);
        $name_group = mysqli_real_escape_string($database->getConnect(), $data['name_group']);
        $year = filter_var($data['year'], FILTER_VALIDATE_INT);

        // Вызываем метод обновления записи в базе данных
        $database->updateGroup($id, $img_student, $name_student, $course_direction, $name_group, $year);

        // Возвращаем успешный ответ
        return new Response("Student with ID $id successfully updated", 200);
    }

    // Если метод запроса не PUT, возвращаем ошибку
    return new Response('Invalid request method.', 405);
})->method('PUT');

// Обработка PUT запроса
$app->match('/CourseEdit/{id_direction}', function ($id_direction, Request $request) use ($app, $database) {
    if ($request->isMethod('PUT')) {
        // Получаем данные из тела запроса
        $data = json_decode($request->getContent(), true);

        // Дополнительные данные, которые могут прийти из формы\
        $id_direction = filter_var($data['id_direction'], FILTER_VALIDATE_INT);
        $name_direction = mysqli_real_escape_string($database->getConnect(), $data['name_direction']);

        // Вызываем метод обновления записи в базе данных
        $database->updateCourse($id_direction, $name_direction);

        // Возвращаем успешный ответ
        return new Response("Course with ID $id_direction successfully updated", 200);
    }

    // Если метод запроса не PUT, возвращаем ошибку
    return new Response('Invalid request method.', 405);
})->method('PUT');

// добавляем обработку CORS для запросов OPTIONS
$app->options('/CourseEdit/{id_direction}', function ($id_direction, Request $request) use ($app) {
    return '';
});

// Маршруты для обработки CORS (Post теперь не блокируется). Добавление студента
$app->match('/', function(Request $request) use ($database) {
    $response = new Response();
    $response->headers->set('Access-Control-Allow-Origin', 'http://localhost:8080/index.php/CourseAdd');
    $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
    $response->headers->set('Access-Control-Allow-Headers', 'Origin, Content-Type, Accept, Authorization');

    if ($request->getMethod() === 'OPTIONS') {
        return $response;
    }

    // Обработка запроса
    $method = $request->getMethod();
    if ($method === 'POST') {
        $data = json_decode($request->getContent(), true);
        $img_student = mysqli_real_escape_string($database->getConnect(), $data['img_student']);
        $name_student = mysqli_real_escape_string($database->getConnect(), $data['name_student']);
        $course_direction = filter_var($data['course_direction'], FILTER_VALIDATE_INT);
        $name_group = mysqli_real_escape_string($database->getConnect(), $data['name_group']);
        $year = filter_var($data['year'], FILTER_VALIDATE_INT);
        $database->addGroup($img_student, $name_student, $course_direction, $name_group, $year);
        return new Response("Student added successfully", 200);
    }

    return new Response('Method Not Allowed', 405);
});

// Маршруты для обработки CORS (Post теперь не блокируется). Добавление направления
$app->match('/CourseAdd', function(Request $request) use ($database) {
    $response = new Response();
    $response->headers->set('Access-Control-Allow-Origin', 'http://localhost:8080');
    $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
    $response->headers->set('Access-Control-Allow-Headers', 'Origin, Content-Type, Accept, Authorization');

    if ($request->getMethod() === 'OPTIONS') {
        return $response;
    }

    // Обработка запроса
    if ($request->getMethod() === 'POST') {
        $data = json_decode($request->getContent(), true);
        $name_direction = mysqli_real_escape_string($database->getConnect(), $data['name_direction']);
        $database->addCourse($name_direction);
        return new Response("Course added successfully", 200);
    }

    return new Response('Method Not Allowed', 405);
});

$app->get('/StudentList/{id_direction}', function($id_direction) use ($database) {
    $students = $database->checkStudentsInDirection($id_direction);
    return json_encode($students);
});

$app->run();
?>
