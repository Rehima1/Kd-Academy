<?php
// Function to get performance data
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

// Function to add performance data
function addPerformanceData($conn, $name, $score) {
    $sql = "INSERT INTO performance (name, score) VALUES ('$name', '$score')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Function to update performance data
function updatePerformanceData($conn, $id, $name, $score) {
    $sql = "UPDATE performance SET name='$name', score='$score' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

// Function to delete performance data
function deletePerformanceData($conn, $id) {
    $sql = "DELETE FROM performance WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

// Close connection
$conn->close();
?>