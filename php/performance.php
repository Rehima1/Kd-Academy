<?php
session_start();
include 'db_connection.php';

function getPerformanceData($conn) {
    $sql = "SELECT * FROM performance";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "id: " . $row["id"]. " - Name: " . $row["name"]. " - Score: " . $row["score"]. "<br>";
        }
    } else {
        echo "0 results";
    }
}

function addPerformanceData($conn, $name, $score) {
    $sql = "INSERT INTO performance (name, score) VALUES ('$name', '$score')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

function updatePerformanceData($conn, $id, $name, $score) {
    $sql = "UPDATE performance SET name='$name', score='$score' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

function deletePerformanceData($conn, $id) {
    $sql = "DELETE FROM performance WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

$conn->close();
?>