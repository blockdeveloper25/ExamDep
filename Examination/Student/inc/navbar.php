<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">
      <img src="../logo.png" width="40">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0"
        id="navLinks">
        <li class="nav-item">
          <a class="nav-link"
            aria-current="page"
            href="index.php">Dashboard</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="result.php">Results</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="form.php">Exam Application</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="download_time.php">Download TimeTables</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="payment.php">Payment</a>
        </li>


        <li class="nav-item">
          <a class="nav-link" href="pass.php">Change Password</a>
        </li>

      </ul>
      <ul class="navbar-nav me-right mb-2 mb-lg-0 align-items-center">
        <li class="nav-item ">
          <div class="dropdown open">
            <a href=""
              class="text-white-50"
              id="triggerId"
              data-bs-toggle="dropdown"
              aria-haspopup="true"
              aria-expanded="false"
              onclick="hideBadge()">
              <i class="fa fa-bell" style="font-size: 25px;"></i>

              <?php if ($conf > 0 || $conf < 0): // Check if there are new messages 
              ?>
                <span id="notificationBadge" class="badge bg-danger position-absolute top-0 start-100 translate-middle p-2 ">
                  <?php echo 1; ?>
                  <span class="visually-hidden">unread messages</span>
                </span>
              <?php endif; ?>
            </a>
            <!-- Right-aligned dropdown -->
            <div class="dropdown-menu dropdown-menu-end p-2" style="width: 400px;" aria-labelledby="triggerId">
              <?php
              if ($conf > 0 && $app == 1) {
                echo '<div class="text-success">' . $mess . '</div>';
              } elseif ($conf < 0 && $app == -1) {
                echo '<div class="text-danger">' . $mess . '</div>';
              }
              ?>
            </div>
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../logout.php">Logout</a>
        </li>
      </ul>
    </div>
  </div>
</nav>