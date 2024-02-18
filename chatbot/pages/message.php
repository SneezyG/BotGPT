
<?php
// connecting to database
$conn = mysqli_connect("localhost", "root", "@Che153980", "bot") or die("Database Error");

// getting user message through ajax
$newQuery = mysqli_real_escape_string($conn, $_POST['query']);
$newReply = mysqli_real_escape_string($conn, $_POST['reply']);

print $newQuery; 
print $newReply;

$insert_query = "INSERT INTO chatbot (queries, replies) VALUES ('$newQuery', '$newReply')";
$run_query = mysqli_query($conn, $insert_query) or die("database query error");

?>
