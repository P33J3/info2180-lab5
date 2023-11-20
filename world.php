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
$country= "";
$lookup = "";
$countries= [];
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['country']) && isset($_GET['lookup'])) {
    $country = filter_input(INPUT_GET, 'country', FILTER_SANITIZE_STRING);
    $lookup = filter_input(INPUT_GET, 'lookup', FILTER_SANITIZE_STRING);
    if (!empty($lookup)) {
        $stmt = $conn->prepare("SELECT cities.name, cities.district, cities.population
        FROM cities
        JOIN countries ON cities.country_code = countries.code 
        WHERE countries.name LIKE '%$country%'");
        $stmt->execute();
        $countries = $stmt->fetchAll();
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['country'])) {
    $country = filter_input(INPUT_GET, 'country', FILTER_SANITIZE_STRING);
    if (!empty($country)) {
        $stmt = $conn->prepare("SELECT * FROM countries WHERE name LIKE '%$country%'");
        $stmt->execute();
        $countries = $stmt->fetchAll();
    }
}
?>


<!--<ul>-->
<!--        --><?php //foreach ($countries as $row): ?>
<!--            <li>--><?php //= $row['name'] . ' is ruled by ' . $row['head_of_state']; ?><!--</li>-->
<!---->
<!--        --><?php //endforeach; ?>
<!--</ul>-->
<?php if(isset($_GET['lookup'])): ?>
<table>
    <thead>
    <tr>
        <th>Name</th>
        <th>District</th>
        <th>Population</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($countries as $row): ?>
        <tr>
            <td><?= $row['name']; ?></td>
            <td><?= $row['district']; ?></td>
            <td><?= $row['population']; ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
    <?php endif; ?>

    <?php if(!isset($_GET['lookup'])): ?>
</table>
<table>
    <thead>
    <tr>
        <th>Name</th>
        <th>Continent</th>
        <th>Independence</th>
        <th>Head of State</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($countries as $row): ?>
        <tr>
            <td><?= $row['name']; ?></td>
            <td><?= $row['continent']; ?></td>
            <td><?= $row['independence_year']; ?></td>
            <td><?= $row['head_of_state']; ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php endif; ?>


