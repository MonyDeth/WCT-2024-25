<?php
$filename = "students.json";

// Load students from JSON
function loadStudents() {
    global $filename;
    if (!file_exists($filename)) {
        file_put_contents($filename, json_encode([])); // Create empty file if missing
    }
    return json_decode(file_get_contents($filename), true);
}

// Save students to JSON
function saveStudents($students) {
    global $filename;
    file_put_contents($filename, json_encode($students, JSON_PRETTY_PRINT));
}

$students = loadStudents();
$action = $_GET['action'] ?? null;
$input = json_decode(file_get_contents("php://input"), true);

switch ($action) {
    case 'get':
        echo json_encode($students);
        exit;

    case 'add':
        $students[] = ["id" => $input['id'], "name" => $input['name'], "gender" => $input['gender']];
        saveStudents($students);
        exit;

    case 'edit':
        foreach ($students as &$student) {
            if ($student['id'] == $input['id']) {
                $student['name'] = $input['name'];
                $student['gender'] = $input['gender'];
                saveStudents($students);
                exit;
            }
        }
        exit;

    case 'delete':
        $students = array_values(array_filter($students, fn($s) => $s['id'] != $input['id']));
        saveStudents($students);
        exit;
}
?>
