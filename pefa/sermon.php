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
  <title>Sermons - PEFA Cathedral Dandora</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
      background: #f4f4f4;
      color: #333;
    }
    header {
      background: #004c99;
      color: white;
      padding: 15px;
      text-align: center;
    }
    .sermons {
      padding: 20px;
      max-width: 900px;
      margin: 20px auto;
      background: white;
      border-radius: 8px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    }
    .sermon {
      margin-bottom: 30px;
      border-bottom: 1px solid #ddd;
      padding-bottom: 20px;
    }
    .sermon h3 {
      margin: 0;
      color: #004c99;
    }
    .sermon p {
      margin: 5px 0;
    }
    video, audio {
      width: 100%;
      max-width: 700px;
      margin-top: 10px;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.3);
    }
  </style>
</head>
<body>

<header>
  <h1>PEFA Cathedral Dandora - Sermons</h1>
</header>

<section class="sermons">
  <h2>Latest Sermons</h2>
  <?php
  $sermons = $conn->query("SELECT * FROM sermons ORDER BY sermon_date DESC LIMIT 5");
  if ($sermons && $sermons->num_rows > 0) {
    while($row = $sermons->fetch_assoc()) {
      echo "<div class='sermon'>
              <h3>{$row['title']}</h3>
              <p><strong>Preacher:</strong> {$row['preacher']}</p>
              <p><strong>Date:</strong> {$row['sermon_date']}</p>
              <p>{$row['description']}</p>";
      if (!empty($row['media_path'])) {
        $ext = pathinfo($row['media_path'], PATHINFO_EXTENSION);
        if ($ext === 'mp4') {
          echo "<video controls>
                  <source src='{$row['media_path']}' type='video/mp4'>
                  Your browser does not support the video tag.
                </video>";
        } elseif ($ext === 'mp3') {
          echo "<audio controls>
                  <source src='{$row['media_path']}' type='audio/mpeg'>
                  Your browser does not support the audio tag.
                </audio>";
        }
      }
      echo "</div>";
    }
  } else {
    echo "<p>No sermons available yet.</p>";
  }
  ?>
</section>

</body>
</html>
