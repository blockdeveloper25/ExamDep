<?php
function getUnDoneRequestCount($conn)
{
  $sql = "SELECT COUNT(*) FROM recorrection WHERE approved = 1 AND status = 0";
  $stmt = $conn->prepare($sql);
  $stmt->execute();
  return $stmt->fetchColumn();
}

$newRequestsCount = getUnDoneRequestCount($conn);
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">
      <img src="../logo.png" width="40">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0" id="navLinks">
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="index.php">Dashboard</a>
        </li>
        
        <li class="nav-item">
          <a class="nav-link" href="addmarks.php">Add Table</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="marks.php">Add Marks</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="updatemarks.php">Update Grade</a>
        </li>
        <li class="nav-item">
          
          <a class="nav-link" href="teacher_requests.php">Recorrection Requests
            <?php if ($newRequestsCount > 0) : ?>
              <span class="badge bg-danger"><?= $newRequestsCount ?></span>
            <?php endif; ?>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="completedreq.php">Completed Requests</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="pass.php">Change Password</a>
        </li>

      </ul>
      <ul class="navbar-nav me-right mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="../logout.php">Logout</a>
        </li>
      </ul>
    </div>
  </div>
</nav>