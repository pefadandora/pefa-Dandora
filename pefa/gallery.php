<?php
$dsn = "mysql:host=localhost;dbname=pefa;charset=utf8mb4";
$user = "root";
$pass = "";

try {
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Corrected query: order by id
    $stmt = $pdo->query("SELECT * FROM photos ORDER BY id DESC");
    $photos = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Gallery</title>
  <style>
    body {font-family:'Helvetica Neue',sans-serif;background:#f4f4f4;color:#333;margin:0;overflow-x:hidden;}
    header {background:linear-gradient(90deg,#111,#333);color:#fff;padding:20px;text-align:center;}
    nav a {color:#fff;margin:0 15px;text-decoration:none;transition:color .3s;}
    nav a:hover {color:#ff9800;}

    h1.wipe {position:relative;overflow:hidden;margin-bottom:20px;}
    h1.wipe::after {
      content:"";position:absolute;top:0;left:0;width:100%;height:100%;
      background:#ff5722;transform:translateX(-100%);transition:transform 1s ease;z-index:1;
    }
    h1.wipe.visible::after {transform:translateX(100%);}

    .split {opacity:0;transform:scaleY(0);transition:all 1s ease;}
    .split.visible {opacity:1;transform:scaleY(1);}

    .grid-gallery {
      display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));
      gap:20px;margin:20px auto;max-width:1000px;padding:20px;
    }
    .photo-card {background:#fff;border-radius:8px;overflow:hidden;box-shadow:0 4px 12px rgba(0,0,0,.1);transition:.3s;}
    .photo-card img {width:100%;display:block;transition:.3s;}
    .photo-card:hover {transform:translateY(-5px);box-shadow:0 6px 16px rgba(0,0,0,.2);}
    .photo-card img:hover {transform:scale(1.05);}
  </style>
</head>
<body>
  <header>
    <h1 class="wipe">Gallery</h1>
    <nav>
      <a href="gallery.php">All</a>
    </nav>
  </header>

  <main class="grid-gallery split">
    <?php if ($photos): ?>
      <?php foreach ($photos as $photo): ?>
        <div class="photo-card split">
          <img src="<?= htmlspecialchars($photo['file_path']); ?>" alt="">
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p style="text-align:center; font-size:1.2rem; color:#666;">No photos available.</p>
    <?php endif; ?>
  </main>

  <script>
    window.addEventListener('DOMContentLoaded', () => {
      document.querySelector('h1.wipe').classList.add('visible');
      document.querySelector('main.grid-gallery').classList.add('visible');
      document.querySelectorAll('.photo-card').forEach(card => card.classList.add('visible'));
    });
  </script>
</body>
</html>
