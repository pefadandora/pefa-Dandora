<?php
include('db.php');


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $subject = $_POST['subject'];
  $message = $_POST['message'];

  $sql = "INSERT INTO messages (name, email, subject, message) 
          VALUES ('$name', '$email', '$subject', '$message')";
  if ($conn->query($sql) === TRUE) {
    echo "<p>Thank you for contacting us. We’ll get back to you soon.</p>";
  } else {
    echo "<p>Error: " . $conn->error . "</p>";
  }
}
?>

<form method="POST" action="">
  <input type="text" name="name" placeholder="Your Name" required>
  <input type="email" name="email" placeholder="Your Email" required>
  <input type="text" name="subject" placeholder="Subject" required>
  <textarea name="message" placeholder="Message" required></textarea>
  <button type="submit">Send Message</button>
</form>

