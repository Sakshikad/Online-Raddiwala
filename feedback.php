<?php
session_start();
require 'config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $rating = intval($_POST['rating']);
    $comment = trim($_POST['comment']);

    // Validate input
    if (empty($username) || $rating < 1 || $rating > 5 || empty($comment)) {
        $response = array(
            'success' => false,
            'message' => 'Invalid input. Please fill out all fields correctly.'
        );
        echo json_encode($response);
        exit();
    }

    $query = "INSERT INTO feedback (username, rating, comment) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);

    if ($stmt) {
        $stmt->bind_param("sis", $username, $rating, $comment);

        if ($stmt->execute()) {
            $response = array(
                'success' => true,
                'message' => 'Feedback submitted successfully.'
            );
        } else {
            $response = array(
                'success' => false,
                'message' => 'Error submitting feedback: ' . $stmt->error
            );
        }
        $stmt->close();
    } else {
        $response = array(
            'success' => false,
            'message' => 'Error preparing statement: ' . $conn->error
        );
    }

    echo json_encode($response);
} else {
    $response = array(
        'success' => false,
        'message' => 'Invalid request method.'
    );
    echo json_encode($response);
}
?>
