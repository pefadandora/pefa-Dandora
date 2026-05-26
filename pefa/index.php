<?php
// Database connection
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "pefa";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>PEFA Cathedral Dandora</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
      color: #fff;
      height: 100vh;
      overflow-x: hidden;
    }
    /* Background slideshow */
    .background-slideshow {
      position: fixed;
      top: 0; left: 0;
      width: 100%; height: 100%;
      z-index: -1;
      overflow: hidden;
    }
    .background-slideshow img {
      position: absolute;
      width: 100%; height: 100%;
      object-fit: cover;
      opacity: 0;
      animation: slideShow 30s infinite;
    }
    .background-slideshow img:nth-child(1) { animation-delay: 0s; }
    .background-slideshow img:nth-child(2) { animation-delay: 10s; }
    .background-slideshow img:nth-child(3) { animation-delay: 20s; }

    @keyframes slideShow {
      0% { opacity: 0; }
      10% { opacity: 1; }
      30% { opacity: 1; }
      40% { opacity: 0; }
      100% { opacity: 0; }
    }

    header {
      background: rgba(0,102,204,0.85);
      color: white;
      padding: 15px;
      text-align: center;
    }
    nav a {
      color: white;
      margin: 0 10px;
      text-decoration: none;
    }
    nav a:hover { text-decoration: underline; }
    .hero {
      text-align: center;
      padding: 100px 20px;
      background: rgba(0,0,0,0.5);
    }
    .hero h2 { font-size: 2.5rem; margin-bottom: 10px; }
    .hero p { font-size: 1.2rem; }
    .events, .gallery, form, .videos {
      padding: 20px;
      background: rgba(255,255,255,0.85);
      margin: 20px;
      border-radius: 8px;
      color: #333;
    }
    .gallery-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 20px;
    }
    .gallery-item img {
      width: 100%;
      border-radius: 8px;
      transition: transform 0.3s ease;
    }
    .gallery-item img:hover { transform: scale(1.05); }
    footer {
      background: rgba(0,102,204,0.85);
      color: white;
      text-align: center;
      padding: 10px;
      margin-top: 20px;
    }
    .success { color: green; }
    .error { color: red; }
    form input, form textarea, form button {
      display: block;
      width: 100%;
      margin: 10px 0;
      padding: 10px;
      border-radius: 5px;
      border: 1px solid #ccc;
    }
    form button {
      background: #0066cc;
      color: white;
      border: none;
      cursor: pointer;
    }
    form button:hover { background: #004c99; }

    /* Ticker */
    .ticker {
      position: fixed;
      bottom: 0;
      width: 100%;
      background: #004c99;
      color: #fff;
      overflow: hidden;
      white-space: nowrap;
      box-shadow: 0 -2px 6px rgba(0,0,0,0.2);
      font-size: 1rem;
      padding: 10px 0;
    }
    .ticker span {
      display: inline-block;
      padding-left: 100%;
      animation: ticker 30s linear infinite;
    }
    @keyframes ticker {
      0% { transform: translateX(0); }
      100% { transform: translateX(-100%); }
    }
  </style>
</head>
<body>

<!-- Background Slideshow -->
<div class="background-slideshow">
  <img src="pic 11.jpg" alt="Background 1">
  <img src="pic 12.jpg" alt="Background 2">
  <img src="pic 13.jpg" alt="Background 3">
</div>

<header>
  <h1>PEFA Cathedral Dandora</h1>
  <nav>
    <a href="index.php">Home</a>
    <a href="#contact">Contact</a>
    <a href="Board.php">Board Members</a>
    <a href="about.php">About us</a>
    <a href="sermon.php">Sermons</a>
  </nav>
</header>

<main>
  <section class="hero">
    <h2>Dandora must be saved</h2>
    <p>Join us for worship, fellowship, and ministry.</p>
  </section>

  <!-- Events Section -->
  <section class="events">
    <h2>Upcoming Events</h2>
    <?php
    $events = $conn->query("SELECT * FROM events ORDER BY event_date ASC LIMIT 3");
    if ($events && $events->num_rows > 0) {
      echo "<ul>";
      while($row = $events->fetch_assoc()) {
        echo "<li><strong>{$row['title']}</strong> - {$row['event_date']} at {$row['event_time']} ({$row['location']})</li>";
      }
      echo "</ul>";
    } else {
      echo "<p>No upcoming events.</p>";
    }
    ?>
  </section>

  <!-- Gallery Section -->
  <section class="gallery">
    <h2>Gallery</h2>
    <div class="gallery-grid">
      <?php
      $photos = $conn->query("SELECT * FROM photos ORDER BY uploaded_at DESC LIMIT 6");
      if ($photos && $photos->num_rows > 0) {
        while($row = $photos->fetch_assoc()) {
          echo "<div class='gallery-item'>
                  <img src='{$row['image_path']}' alt='Church Photo'>
                </div>";
        }
      } else {
        echo "<p>No photos available.</p>";
      }
      ?>
    </div>

<!-- Contact Section -->
<section id="contact">
  <h2>Contact Us</h2>
  <?php
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    $sql = "INSERT INTO messages (name, email, subject, message) 
            VALUES ('$name', '$email', '$subject', '$message')";
    if ($conn->query($sql) === TRUE) {
      echo "<p class='success'>Thank you for contacting us. We’ll get back to you soon.</p>";
    } else {
      echo "<p class='error'>Error: " . $conn->error . "</p>";
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
</section>

</main>
<footer>
  <p>&copy; <?php echo date("Y"); ?> PEFA Cathedral Dandora. All Rights Reserved.</p>
</footer>

<!-- Lower Thirds Ticker -->
<div class="ticker">
  <span>
    MONDAY: CELL GROUPS // TUESDAY: CHOIR PRACTICE // WEDNESDAY: BIBLE STUDY // 
    THURSDAY: YOUTH SERVICE // FRIDAY: EVENING PRAYERS (6:30PM-7:30PM) & NIGHT VIGIL (10PM-3AM) // 
    SATURDAY: PRAISE & WORSHIP PRACTICE // ALL MIDWEEK SERVICES START FROM 6:30PM - 7:40PM
  // YOU ARE WELCOME
  </span>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
  const navLinks = document.querySelectorAll("nav a");
  navLinks.forEach(link => {
    link.addEventListener("mouseover", () => link.style.textDecoration = "underline");
    link.addEventListener("mouseout", () => link.style.textDecoration = "none");
  });
});
</script>
</body>
</html>
