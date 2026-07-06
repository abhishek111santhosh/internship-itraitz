<?php
// 1. This is the PHP "brain" zone. We define our data here.
$pageTitle = "My First PHP & Bootstrap Page";
$userName = "Developer";

// An array of dynamic content
$features = [
    ["title" => "Backend Power", "desc" => "PHP handles your databases, forms, and logic."],
    ["title" => "Frontend Beauty", "desc" => "Bootstrap makes it look stunning and mobile-friendly."],
    ["title" => "Perfect Team", "desc" => "Together, they let you build complete web apps fast."]
];
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $pageTitle; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body class="bg-light">

    <nav class="navbar navbar-dark bg-dark mb-4">
      <div class="container">
        <span class="navbar-brand mb-0 h1">PHP x Bootstrap</span>
      </div>
    </nav>

    <div class="container">
      <div class="p-5 mb-4 bg-white rounded-3 shadow-sm">
        <h1 class="display-5 fw-bold text-primary">Welcome back, <?php echo $userName; ?>!</h1>
        <p class="col-md-8 fs-4">Below is a list of features generated dynamically by a PHP loop using Bootstrap cards.</p>
      </div>

      <div class="mb-4 text-center">
        <a href="https://www.example.com" target="_blank" rel="noopener noreferrer">
          <img src="https://via.placeholder.com/800x300.png?text=Click+Here" alt="Clickable image" class="img-fluid rounded shadow-sm">
        </a>
      </div>

      <div class="row">
        <?php foreach ($features as $feature): ?>
          <div class="col-md-4 mb-3">
            <div class="card h-100 shadow-sm">
              <div class="card-body">
                <h5 class="card-title text-success"><?php echo $feature['title']; ?></h5>
                <p class="card-text"><?php echo $feature['desc']; ?></p>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>