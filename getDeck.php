<?php
$host = 'localhost:3306';
$username = 'root';
$password = '';
$database = 'flashcards';

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$tableName = $_GET['table'];

// Check if 'numberOfWords' is set in the URL
$numberOfWords = isset($_GET['numberOfWords']) ? (int)$_GET['numberOfWords'] : PHP_INT_MAX;

// Check if 'order' is set in the URL and validate the value
$order = isset($_GET['order']) && ($_GET['order'] == 'ordered' || $_GET['order'] == 'random') ? $_GET['order'] : 'random';

// Check if 'contains' is set in the URL
$contains = isset($_GET['contains']) ? $conn->real_escape_string($_GET['contains']) : '';

// Use the arguments in your SQL query
$sql = "SELECT * FROM $tableName ";

// Add a condition for 'contains'
if ($contains != '') {
    $sql .= "WHERE question LIKE '%$contains%' ";
}

// Adjust the query based on the order parameter
if ($order == 'ordered') {
    $sql .= "ORDER BY id ";
} else {
    $sql .= "ORDER BY RAND() ";
}

// Limit the number of rows based on 'numberOfWords'
$sql .= "LIMIT $numberOfWords";

//echo "<div>" . $sql . "</div>";
$result = $conn->query($sql);

$deck = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $deck[] = $row;
    }
}

echo json_encode($deck);

$conn->close();
?>