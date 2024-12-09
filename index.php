<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="icon" href="./Examination/logo.png">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css"
    integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="./styles/common.css" />
  <link rel="stylesheet" href="./styles/index.css" />
  <link rel="stylesheet" href="./styles/navbar.css" />

  <title>SUSL-Home</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <style>
    
  </style>

</head>

<body>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>

  <section class="home-main">

    <?php
    include "./inc/navbar.php"
    ?>
    <div>
      <div id="carouselExample" class="carousel slide">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="./images/susl.jpg" class="d-block w-100" alt="...">
          </div>
          <div class="carousel-item">
            <img src="./images/susl2.jpg" class="d-block w-100" alt="...">
          </div>
          <div class="carousel-item">
            <img src="./images/susl3.jpeg" class="d-block w-100" alt="...">
          </div>
          <div class="carousel-item">
            <img src="./images/susl4.jpg" class="d-block w-100" alt="...">
          </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
      </div>
    </div>
  </section>

  <section>
    <div class="layout">
      <div class="button-container">
        <div class="button-index">EXAM RULES & REGULATIONS</div>
        <div class="button-index">DEGREE PROGRAMS</div>
      </div>
      <div class="content">
        <h4>REGISTRATION PROCEDURE</h4>
        <p>The selected students are informed by the UGC to come to the University on a specific day for their Registration. Fees Payable by the New Entrants (To be paid at any branch of the Peoples Bank, to the credit of the collection Account No. 086-1-001-1-1189653)</p>
        <ul>
          <li>Application for Registration</li>
          <li>Original and a Certified copy of Birth Certificate</li>
          <li>Certified copy of A/L Certificate</li>
          <li>Certified copy of O/L Certificate</li>
          <li>04 coloured Photographs of 04 cm x 05 cm</li>
          <li>Customer Copy issued by the Bank for the payment of Registration Fee</li>
          <li>Affidavit (if the name used differs from the name in the birth certificate)</li>
        </ul>
        <hr>
        <h4>FORMS ISSUED</h4>
        <p>The following forms will be issued to the students at the registration and the duly filled forms to be submitted to the University within two weeks</p>
        <ul>
          <li>Declaration form: To be submitted to the Examinations Branch, University of Colombo.</li>
          <li>Medical Examination Form: To be sent to the University Medical Officer, by the Medical office who does the Medical examination.</li>
          <li>Application for Student Identity Card: To be sent to Chief Marshall of the University.</li>
          <li>Application for Hostel Facility: To be sent to the Senior Assistant Registrar/ Student & Staff Welfare Branch.</li>
          <li>Application for Bursary: To be sent to the Senior Assistant Registrar/ Student & Staff Welfare Branch.</li>
        </ul>
        <h4>ANNUAL REGISTRATION OF SENIOR STUDENTS</h4>
        <p>All students should register for the next academic year in the second semester of each academic year by paying an annual registration fee. The period of registration will be noticed to the students at the end of each academic year. The students those who are unable to register during the given time period will not be permitted to sit for the examination.</p>
        <div class="button-index">
          <i class="fas fa-download"></i> REGISTRATION FORM
        </div>
        <h4>CONTACT</h4>
        <div class="contact">
          <div>
            <h5>Deputy Registrar</h5>
            <p>Name</p>
            <p>Telephone</p>
            <p>Email</p>
          </div>
          <div>
            <h5>Assistant Registrar</h5>
            <p>Name</p>
            <p>Telephone</p>
            <p>Email</p>
          </div>
          <div>
            <h5>General Inquiries</h5>
            <p>Name</p>
            <p>Telephone</p>
            <p>Email</p>
          </div>
        </div>
      </div>
    </div>
  </section>
  <?php
    include "./inc/footer.php"
    ?>
  <script src="./js/navbar.js"></script>

</body>

</html>