<?php
include('db.php');
include('includes/header.php');

$sql = "SELECT * FROM events ORDER BY event_date ASC";
$result = $conn->query($sql);
?>

<section class="events">
  <h2>Upcoming Events</h2>
  <?php if ($result->num_rows > 0): ?>
    <ul>
      <?php while($row = $result->fetch_assoc()): ?>
        <li>
          <h3><?php echo $row['title']; ?></h3>
          <p><?php echo $row['description']; ?></p>
          <p><strong>Date:</strong> <?php echo $row['event_date']; ?> 
             <strong>Time:</strong> <?php echo $row['event_time']; ?></p>
          <p><strong>Location:</strong> <?php echo $row['location']; ?></p>
        </li>
      <?php endwhile; ?>
    </ul>
  <?php else: ?>
    <p>No upcoming events at the moment.</p>
  <?php endif; ?>
</section>

<?php include('includes/footer.php'); ?>
