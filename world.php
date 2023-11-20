<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
$host = 'localhost:3307';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
$stmt = $conn->query("SELECT * FROM countries");

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
$country="";
$countries=[];
if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['country'])) {
    $country = filter_input(INPUT_GET, 'country', FILTER_SANITIZE_STRING);
    if (!empty($country)) {
        $stmt = $conn->prepare("SELECT * FROM countries WHERE name LIKE '%$country%'");
        $stmt->execute();
        $countries = $stmt->fetchAll();
    }
}
?>


<ul>
        <?php foreach ($countries as $row): ?>
            <li><?= $row['name'] . ' is ruled by ' . $row['head_of_state']; ?></li>
        <?php endforeach; ?>
</ul>


