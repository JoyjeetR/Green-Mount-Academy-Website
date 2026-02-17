<!DOCTYPE html>
<?php
if(isset($_POST['submit_enquiry'])) {

      $guardian_name   = htmlspecialchars($_POST['guardian_name']);
      $phone           = htmlspecialchars($_POST['phone']);
      $student_name    = htmlspecialchars($_POST['student_name']);
      $class_applying  = htmlspecialchars($_POST['class_applying']);
      $email           = htmlspecialchars($_POST['email']);
      $branch          = htmlspecialchars($_POST['branch']);
      $message         = htmlspecialchars($_POST['message']);

      try {
            require_once('sql_connect.php');

            $query = "INSERT INTO enquiry 
            (guardianName, studentName, classApplying, phone, email, branch, message) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";

            $stmt = $pdo->prepare($query);
            $stmt->execute([
                  $guardian_name,$student_name,$class_applying,$phone,$email,$branch,$message ]);

            $pdo = NULL;
            $stmt = NULL;

            header("Location: contact.php?success=1");
            exit();

      } catch(PDOException $e) {
            echo "<script>alert('Error submitting enquiry');</script>";
      }
}
?>
<html lang="en">

<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Document</title>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

      <link rel="stylesheet" href="css/contact.css">
      <link rel="stylesheet" href="css/contact_media.css">
      <link rel="stylesheet" href="css/header.css">
      <link rel="stylesheet" href="css/header_media.css">
</head>

<body>
      <!-- Preloader -->
      <div id="preloader">
            <div class="loader"></div>
      </div>

      <header class="position-sticky top-0">
            <!-- This is a collapsable header is collapse in sm and low screens -->
            <nav class="navbar navbar-expand-lg py-2 fullNav">
                  <div class="container-fluid  px-4">
                        <!-- This is the logo pic and the name of school -->
                        <a class="navbar-brand navLogo d-flex align-items-center " href="index.html">
                              <div class="row">
                                    <div class="col-2">
                                          <img src="img/gmaLogo.PNG" alt="" class="img-fluid">
                                    </div>
                                    <div class="col-10">
                                          <h2>+2 Green Mount Academy</h2>
                                    </div>
                              </div>
                        </a>
                        <!-- Toggle button for the collapsed links -->
                        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas"
                              data-bs-target="#right_nav" aria-controls="offcanvasScrolling">
                              <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse navButn justify-content-end">
                              <!-- links for the non collapsed screen -->
                              <div class="navbar-nav">
                                    <a class="nav-link px-4 " aria-current="page" href="index.html">Home</a>
                                    <a class="nav-link px-4 " href="gallery.html">Gallery</a>
                                    <a class="nav-link px-4 " href="branches.html">Branches</a>
                                    <a class="nav-link px-4 active" href="contact.php">Contact</a>
                                    <a class="nav-link px-4 " href="about.html">About</a>
                              </div>
                        </div>
                  </div>
            </nav>
            <!-- The collapsed menu for the header comes out from the right -->
            <div class="offcanvas offcanvas-start" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1"
                  id="right_nav">
                  <div class="offcanvas-header navLogo " style="background-color:#79d199">
                        <div class="row">
                              <div class="col-2">
                                    <img src="img/gmaLogo.webp" alt="" class="img-fluid">
                              </div>
                              <div class="col-10">
                                    <h2>+2 Green Mount Academy</h2>
                                    <p class="m-0">An english medium school CBSE Curriculum, New Delhi</p>
                              </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                  </div>
                  <div class="offcanvas-body">
                        <div class="navbar-nav">
                              <a class="nav-link px-4  " aria-current="page" href="index.html">Home</a>
                              <a class="nav-link px-4 " href="gallery.html">Gallery</a>
                              <a class="nav-link px-4 " href="branches.html">Branches</a>
                              <a class="nav-link px-4 active" href="contact.php">Contact</a>
                              <a class="nav-link px-4 " href="about.html">About</a>
                        </div>
                  </div>
            </div>
      </header>
      <main>
            <!-- HERO -->
            <section class="contact-hero text-center">
                  <div class="container">
                        <h1>CONTACT US</h1>
                        <p>We’re here to help you with admissions and inquiries</p>
                  </div>
            </section>

            <!-- CHAIRPERSON SECTION -->
            <section class="py-5 chairman-section">
                  <div class="container">
                        <div class="chairman-card row align-items-center">

                              <!-- Photo -->
                              <div class="col-md-4 text-center">
                                    <div class="chairman-image">
                                          <img src="img/karunPic1.webp" alt="Chairperson +2 Green Mount Academy">
                                    </div>
                              </div>

                              <!-- Details -->
                              <div class="col-md-8">
                                    <div class="chairman-content">
                                          <h5>Chairperson</h5>
                                          <h2>Mr. Karun Kumar Roy</h2>
                                          <p class="designation">Chairperson, +2 Green Mount Academy</p>

                                          <p class="chairperson-message">
                                                “Education is the foundation of character and excellence.
                                                Our mission is to nurture young minds with knowledge, discipline, and
                                                values.”
                                          </p>

                                          <div class="chairman-contact">
                                                <p><i class="bi bi-telephone"></i> +91 9431549204</p>
                                                <p><i class="bi bi-envelope"></i> greenmountacademy1996@gmail.com</p>
                                                <p><i class="bi bi-geo-alt"></i> Dumka, Jharkhand</p>
                                          </div>
                                    </div>
                              </div>

                        </div>
                  </div>
            </section>


            <!-- BRANCHES WITH MAP -->
            <section class="py-5 container-fluid" style="background-color: white;">
                  <div class="container branchContact">
                        <h2 class="text-center mb-3">Our Branch Contacts</h2>
                        <hr>

                        <ul class="nav nav-pills  mb-4" id="branchTabs">
                              <li class="nav-item">
                                    <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#branch1">Jail
                                          Road</button>
                              </li>
                              <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="pill" data-bs-target="#branch2">Baxi
                                          Bandh</button>
                              </li>
                              <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="pill"
                                          data-bs-target="#branch3">TataShowroom</button>
                              </li>
                              <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="pill"
                                          data-bs-target="#branch4">Sejokora</button>
                              </li>
                              <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="pill"
                                          data-bs-target="#branch5">Deoghar</button>
                              </li>
                              <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="pill"
                                          data-bs-target="#branch6">Rashikpur</button>
                              </li>
                              <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="pill"
                                          data-bs-target="#branch7">Ramghar</button>
                              </li>
                              <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="pill"
                                          data-bs-target="#branch8">Khatikhund</button>
                              </li>
                        </ul>
                        <div class="tab-content ">
                              <!-- Branch1 -->
                              <div class="tab-pane fade show active" id="branch1">
                                    <div class="row g-4 align-items-center">
                                          <!-- PRINCIPAL CARD -->
                                          <div class="col-lg-4 text-center">
                                                <div class="principal-card">
                                                      <img src="img/branch/princialPic1.webp"
                                                            alt="Principal Jail Road">
                                                      <h5>Mrs. Sunita Roy</h5>
                                                      <p class="designation">Principal</p>
                                                </div>
                                          </div>
                                          <!-- BRANCH INFO -->
                                          <div class="col-lg-8">
                                                <div class="row">
                                                      <div class="col-sm-7">
                                                            <h5 class="branch-title">+2 Green Mount Academy – Jail Road
                                                            </h5>
                                                            <p>Jail Road, Dumka, Jharkhand</p>
                                                            <p>Nursery – XII | 8:00 AM – 3:00 PM</p>

                                                      </div>
                                                      <div class="col-sm-5">
                                                            <p class="small-contact">
                                                                  📞 +91 9431549204 <br>
                                                                  ✉ jailroad@gma.edu.in
                                                            </p>
                                                      </div>
                                                </div>
                                                <iframe class="map-frame"
                                                      data-src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d909.3283896587814!2d87.24971856957309!3d24.26577619864516!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39f0b7b24379a1eb%3A0xc0e3b33db8600a51!2sGreen%20Mount%20Academy!5e0!3m2!1sen!2sus!4v1771075301340!5m2!1sen!2sus"
                                                      loading="lazy"></iframe>


                                          </div>

                                    </div>
                              </div>
                              <!-- Branch2 -->
                              <div class="tab-pane fade " id="branch2">
                                    <div class="row g-4 align-items-center">
                                          <!-- PRINCIPAL CARD -->
                                          <div class="col-lg-4 text-center">
                                                <div class="principal-card">
                                                      <img src="img/branch/princialPic1.webp"
                                                            alt="Principal baski Bandh Road">
                                                      <h5>Mr. Rajeev Ranjan</h5>
                                                      <p class="designation">Principal</p>
                                                </div>
                                          </div>
                                          <!-- BRANCH INFO -->
                                          <div class="col-lg-8">
                                                <div class="row">
                                                      <div class="col-sm-7">
                                                            <h5 class="branch-title">+2 Green Mount Academy – Baski
                                                                  bandh Road
                                                            </h5>
                                                            <p>Baski Bandh Road, Dumka, Jharkhand</p>
                                                            <p>Nursery – XII | 8:00 AM – 3:00 PM</p>

                                                      </div>
                                                      <div class="col-sm-5">
                                                            <p class="small-contact">
                                                                  📞 +91 9431549204 <br>
                                                                  ✉ greenmountacademy1996@gmail.com
                                                            </p>
                                                      </div>
                                                </div>
                                                <iframe class="map-frame"
                                                      data-src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d58180.907908845955!2d87.15867976953126!3d24.30093333196995!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39f0b7c7c4b5a217%3A0x45a9856e62df0f42!2sGreen%20Mount%20Academy!5e0!3m2!1sen!2sus!4v1770786693623!5m2!1sen!2sus"
                                                      loading="lazy"></iframe>


                                          </div>

                                    </div>
                              </div>
                              <!-- Branch3 -->
                              <div class="tab-pane fade " id="branch3">
                                    <div class="row g-4 align-items-center">
                                          <!-- PRINCIPAL CARD -->
                                          <div class="col-lg-4 text-center">
                                                <div class="principal-card">
                                                      <img src="img/branch/princialPic1.webp"
                                                            alt="Principal baski Bandh Road">
                                                      <h5>Mrs. Sweta </h5>
                                                      <p class="designation">Principal</p>
                                                </div>
                                          </div>
                                          <!-- BRANCH INFO -->
                                          <div class="col-lg-8">
                                                <div class="row">
                                                      <div class="col-sm-7">
                                                            <h5 class="branch-title">First Step "A Play School"
                                                            </h5>
                                                            <p>TataShowroom Road, Dumka, Jharkhand</p>
                                                            <p>Pre-Nursery – I | 9:00 AM – 12:00 PM</p>

                                                      </div>
                                                      <div class="col-sm-5">
                                                            <p class="small-contact">
                                                                  📞 +91 9431549204 <br>
                                                                  ✉ greenmountacademy1996@gmail.com
                                                            </p>
                                                      </div>
                                                </div>
                                                <iframe class="map-frame"
                                                      data-src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d29097.611547329463!2d87.22603658172316!3d24.269693537568916!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39f0b7b719836813%3A0x231eed5dc0762918!2sFirst%20Step%20Play%20School%20Dumka!5e0!3m2!1sen!2sin!4v1770786029438!5m2!1sen!2sin"
                                                      loading="lazy"></iframe>


                                          </div>

                                    </div>
                              </div>
                              <!-- Branch4 -->
                              <div class="tab-pane fade " id="branch4">
                                    <div class="row g-4 align-items-center">
                                          <!-- PRINCIPAL CARD -->
                                          <div class="col-lg-4 text-center">
                                                <div class="principal-card">
                                                      <img src="img/branch/princialPic1.webp"
                                                            alt="Principal baski Bandh Road">
                                                      <h5>Mr. Amrandan Jha</h5>
                                                      <p class="designation">Principal</p>
                                                </div>
                                          </div>
                                          <!-- BRANCH INFO -->
                                          <div class="col-lg-8">
                                                <div class="row">
                                                      <div class="col-sm-7">
                                                            <h5 class="branch-title">+2 Green Mount Academy – Jama
                                                            </h5>
                                                            <p>Sejakora, Jama, Dumka, Jharkhand</p>
                                                            <p>Nursery – XII | 8:00 AM – 3:00 PM</p>

                                                      </div>
                                                      <div class="col-sm-5">
                                                            <p class="small-contact">
                                                                  📞 +91 9431549204 <br>
                                                                  ✉ greenmountacademy1996@gmail.com
                                                            </p>
                                                      </div>
                                                </div>
                                                <iframe class="map-frame"
                                                      data-src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3635.297507333458!2d87.14374477514654!3d24.33612717827533!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39f0c7f402377d6d%3A0x2415ff906ef203a9!2sGreen%20Mount%20Academy%2C%20Jama!5e0!3m2!1sen!2sin!4v1770786188250!5m2!1sen!2sin"
                                                      loading="lazy"></iframe>


                                          </div>

                                    </div>
                              </div>
                              <!-- Branch5 -->
                              <div class="tab-pane fade " id="branch5">
                                    <div class="row g-4 align-items-center">
                                          <!-- PRINCIPAL CARD -->
                                          <div class="col-lg-4 text-center">
                                                <div class="principal-card">
                                                      <img src="img/branch/princialPic1.webp"
                                                            alt="Principal baski Bandh Road">
                                                      <h5>Mr. Amrandan Jha</h5>
                                                      <p class="designation">Principal</p>
                                                </div>
                                          </div>
                                          <!-- BRANCH INFO -->
                                          <div class="col-lg-8">
                                                <div class="row">
                                                      <div class="col-sm-7">
                                                            <h5 class="branch-title">Naba Nyoti Academy
                                                            </h5>
                                                            <p>Bharampura, Deoghar,  Jharkhand</p>
                                                            <p>Nursery – X | 8:00 AM – 3:00 PM</p>

                                                      </div>
                                                      <div class="col-sm-5">
                                                            <p class="small-contact">
                                                                  📞 +91 9431549204 <br>
                                                                  ✉ greenmountacademy1996@gmail.com
                                                            </p>
                                                      </div>
                                                </div>
                                                <iframe class="map-frame"
                                                      data-src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3633.374461300693!2d86.67947447513666!3d24.403055178230712!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39f13dabd9e1dc8b%3A0x12c14c1e82513317!2z4KSm4KWB4KSw4KWN4KSX4KS-IOCkruCkguCkpuCkv-CksCDgpKzgpY3gpLDgpLngpY3gpK7gpKrgpYHgpLDgpL4!5e0!3m2!1sen!2sus!4v1771076488163!5m2!1sen!2sus"
                                                      loading="lazy"></iframe>


                                          </div>

                                    </div>
                              </div>
                              <!-- Branch6 -->
                              <div class="tab-pane fade " id="branch6">
                                    <div class="row g-4 align-items-center">
                                          <!-- PRINCIPAL CARD -->
                                          <div class="col-lg-4 text-center">
                                                <div class="principal-card">
                                                      <img src="img/branch/princialPic1.webp"
                                                            alt="Principal baski Bandh Road">
                                                      <h5>Mrs. Tulika Sen</h5>
                                                      <p class="designation">Sectary</p>
                                                </div>
                                          </div>
                                          <!-- BRANCH INFO -->
                                          <div class="col-lg-8">
                                                <div class="row">
                                                      <div class="col-sm-7">
                                                            <h5 class="branch-title">First Step - Rashikpur
                                                            </h5>
                                                            <p>Rashikpur, Dumka,  Jharkhand</p>
                                                            <p>Pre-Nursery – I | 9:00 AM – 1:00 PM</p>

                                                      </div>
                                                      <div class="col-sm-5">
                                                            <p class="small-contact">
                                                                  📞 +91 9431549204 <br>
                                                                  ✉ greenmountacademy1996@gmail.com
                                                            </p>
                                                      </div>
                                                </div>
                                                <iframe class="map-frame"
                                                      data-src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d302.30567304520224!2d87.25492714646374!3d24.282691477694605!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39f0b70828602f2b%3A0x73871dfab87402c5!2sFirst%20Step%202nd%20Branch!5e0!3m2!1sen!2sin!4v1770793376676!5m2!1sen!2sin"
                                                      loading="lazy"></iframe>


                                          </div>

                                    </div>
                              </div>
                              <!-- Branch7 -->
                              <div class="tab-pane fade " id="branch7">
                                    <div class="row g-4 align-items-center">
                                          <!-- PRINCIPAL CARD -->
                                          <div class="col-lg-4 text-center">
                                                <div class="principal-card">
                                                      <img src="img/branch/princialPic1.webp"
                                                            alt="Principal baski Bandh Road">
                                                      <h5>Mrs. Tulika Sen</h5>
                                                      <p class="designation">Sectary</p>
                                                </div>
                                          </div>
                                          <!-- BRANCH INFO -->
                                          <div class="col-lg-8">
                                                <div class="row">
                                                      <div class="col-sm-7">
                                                            <h5 class="branch-title"> +2 Green Mount Academy - Ramghar
                                                            </h5>
                                                            <p>Ramghar, Dumka,  Jharkhand</p>
                                                            <p>Nursery – X | 8:00 AM – 3:00 PM</p>

                                                      </div>
                                                      <div class="col-sm-5">
                                                            <p class="small-contact">
                                                                  📞 +91 9431549204 <br>
                                                                  ✉ greenmountacademy1996@gmail.com
                                                            </p>
                                                      </div>
                                                </div>
                                                <iframe class="map-frame"
                                                      data-src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3628.774886467298!2d87.25344717514199!3d24.562440178125012!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39f094f124d0e777%3A0xafc9ae90448cc194!2sRose%20Garden%20Vidyapith%2C%20Ramgarh!5e0!3m2!1sen!2sin!4v1770794920068!5m2!1sen!2sin"
                                                      loading="lazy"></iframe>


                                          </div>

                                    </div>
                              </div>
                              <!-- Branch8 -->
                              <div class="tab-pane fade " id="branch8">
                                    <div class="row g-4 align-items-center">
                                          <!-- PRINCIPAL CARD -->
                                          <div class="col-lg-4 text-center">
                                                <div class="principal-card">
                                                      <img src="img/branch/princialPic1.webp"
                                                            alt="Principal baski Bandh Road">
                                                      <h5>Mrs. Tulika Sen</h5>
                                                      <p class="designation">Sectary</p>
                                                </div>
                                          </div>
                                          <!-- BRANCH INFO -->
                                          <div class="col-lg-8">
                                                <div class="row">
                                                      <div class="col-sm-7">
                                                            <h5 class="branch-title"> +2 Green Mount Academy - Khatikund
                                                            </h5>
                                                            <p>Khatikund,  Jharkhand</p>
                                                            <p>Nursery – X | 8:00 AM – 3:00 PM</p>

                                                      </div>
                                                      <div class="col-sm-5">
                                                            <p class="small-contact">
                                                                  📞 +91 9431549204 <br>
                                                                  ✉ greenmountacademy1996@gmail.com
                                                            </p>
                                                      </div>
                                                </div>
                                                <iframe class="map-frame"
                                                      data-src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14538.390499423262!2d87.40280577753603!3d24.360505255178303!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39f0a4530504ac35%3A0x4952107b974a688e!2sKathikund%2C%20Jharkhand%20814103%2C%20India!5e0!3m2!1sen!2sus!4v1771076886604!5m2!1sen!2sus"
                                                      loading="lazy"></iframe>


                                          </div>

                                    </div>
                              </div>


                        </div>
                  </div>
            </section>

            <!--  ENQUIRY SECTION -->
            <section class="enquiry-section py-5" id="AddEnquiry">
                  <div class="container">
                        <div class="row justify-content-center">
                              <div class="col-lg-10">

                                    <div class="enquiry-card">
                                          <div class="row align-items-center">

                                                <!-- LEFT SIDE -->
                                                <div class="col-lg-5 enquiry-left">
                                                      <div class="form-logo">
                                                            <img src="img/gmaLogo.PNG"
                                                                  alt="+2 Green Mount Academy Logo">
                                                      </div>

                                                      <h3>Admission Enquiry</h3>
                                                      <p>
                                                            Interested in admission? Fill out the form and our team
                                                            will contact you shortly.
                                                      </p>

                                                      <div class="contact-highlight">
                                                            <p><strong>📞 Phone:</strong> +91 9431549204</p>
                                                            <p><strong>✉ Email:</strong> greenmountacademy1996@gmail.com
                                                            </p>
                                                      </div>
                                                </div>

                                                <!-- RIGHT SIDE -->
                                                <div class="col-lg-7 enquiry-right">
                                                      <form class="modern-form" method="POST" action="" id="enquiryForm" >
                                                            <div class="row g-3">

                                                                  <!-- Parent Name -->
                                                                  <div class="col-md-6">
                                                                        <div class="form-floating">
                                                                              <input type="text" class="form-control"
                                                                                    placeholder="Parent Name" required name="guardian_name">
                                                                              <label>Parent / Guardian Name</label>
                                                                        </div>
                                                                  </div>

                                                                  <!-- Phone -->
                                                                  <div class="col-md-6">
                                                                        <div class="form-floating">
                                                                              <input type="tel" class="form-control"
                                                                                    placeholder="Phone Number" required name="phone">
                                                                              <label>Phone Number</label>
                                                                        </div>
                                                                  </div>

                                                                  <!-- Student Name -->
                                                                  <div class="col-md-6">
                                                                        <div class="form-floating">
                                                                              <input type="text" class="form-control"
                                                                                    placeholder="Student Name" required name="student_name">
                                                                              <label>Student Name</label>
                                                                        </div>
                                                                  </div>

                                                                  <!-- Class Applying -->
                                                                  <div class="col-md-6">
                                                                        <div class="form-floating">
                                                                              <select class="form-select" required name="class_applying">
                                                                                    <option selected disabled value="">
                                                                                          Select Class</option>
                                                                                    <option value="pre-nur">Pre-Nursery</option>
                                                                                    <option value="nur">Nursery</option>
                                                                                    <option value="LKG">LKG</option>
                                                                                    <option value="UKG">UKG</option>
                                                                                    <option value="one">Class I</option>
                                                                                    <option value="two">Class II</option>
                                                                                    <option value="three">Class III</option>
                                                                                    <option value="four">Class IV</option>
                                                                                    <option value="five">Class V</option>
                                                                                    <option value="six">Class VI</option>
                                                                                    <option value="seven">Class VII</option>
                                                                                    <option value="eight">Class VIII</option>
                                                                                    <option value="nine">Class IX</option>
                                                                                    <option value="ten">Class X</option>
                                                                                    <option value="eleven">Class XI</option>
                                                                                    <option value="twelve">Class XII</option>
                                                                              </select>
                                                                              <label>Class Applying For</label>
                                                                        </div>
                                                                  </div>

                                                                  <!-- Email -->
                                                                  <div class="col-md-6">
                                                                        <div class="form-floating">
                                                                              <input type="email" class="form-control"
                                                                                    placeholder="Email Address"  name="email">
                                                                              <label>Email Address</label>
                                                                        </div>
                                                                  </div>

                                                                  <!-- Branch -->
                                                                  <div class="col-md-6">
                                                                        <div class="form-floating">
                                                                              <select class="form-select" required name="branch">
                                                                                    <option selected disabled value="">
                                                                                          Select Branch</option>
                                                                                    <option value="jail">Jail Road</option>
                                                                                    <option value="baxi">Baxi Bandh</option>
                                                                                    <option value="tata_showroom">Tata Showroom</option>
                                                                                    <option value="jama">Sejokora</option>
                                                                                    <option value="bhrampura">Deoghar</option>
                                                                                    <option value="rashikpur">Rashikpur</option>
                                                                                    <option value="ramghar">Ramghar</option>
                                                                                    <option value="khatitkund">Khatikhund</option>
                                                                              </select>
                                                                              <label>Select Branch</label>
                                                                        </div>
                                                                  </div>

                                                                  <!-- Message -->
                                                                  <div class="col-12">
                                                                        <div class="form-floating">
                                                                              <textarea class="form-control"
                                                                                    placeholder="Your Message"
                                                                                    style="height: 110px" name="message"></textarea>
                                                                              <label>Additional Message</label>
                                                                        </div>
                                                                  </div>

                                                                  <!-- Submit -->
                                                                  <div class="col-12 text-end mt-2">
                                                                        <button type="submit" class="btn-submit" name="submit_enquiry" id="submitEnquiryBtn">
                                                                              Submit Enquiry
                                                                        </button>
                                                                  </div>

                                                            </div>
                                                      </form>
                                                </div>
                                          </div>
                                    </div>
                              </div>
                        </div>
                  </div>
            </section>


      </main>

      <footer class="main-footer">
            <div class="container">
                  <div class="row g-5 footer-top">

                        <!-- ABOUT SCHOOL -->
                        <div class="col-lg-3 footer-col">
                              <h5 class="footer-title">About School</h5>
                              <ul class="footer-links">
                                    <li><a href="about.html#legacy">Our Legacy</a></li>
                                    <li><a href="about.html#mission">Mission & Vision</a></li>
                                    <li><a href="about.html#history">School History</a></li>
                                    <li><a href="about.html#curriculum">Curriculum</a></li>
                                    <li><a href="about.html#admission">Admission Process</a></li>
                              </ul>
                        </div>

                        <!-- BRANCHES -->
                        <div class="col-lg-3 footer-col">
                              <h5 class="footer-title">Branches</h5>
                              <ul class="footer-links">
                                    <li><a href="branches.html">Main Branch</a></li>
                                    <li><a href="branches.html">Baxi Bandh</a></li>
                                    <li><a href="branches.html">First Step Play School</a></li>
                                    <li><a href="branches.html">Jama</a></li>
                                    <li><a href="branches.html">Khatikhund</a></li>
                              </ul>
                        </div>

                        <!-- GALLERY -->
                        <div class="col-lg-3 footer-col">
                              <h5 class="footer-title">Gallery Sections</h5>
                              <ul class="footer-links">
                                    <li><a href="gallery.html#campus">School Campus</a></li>
                                    <li><a href="gallery.html#classroom">Classrooms</a></li>
                                    <li><a href="gallery.html#SciExhi">Science Exhibition</a></li>
                                    <li><a href="gallery.html#playSchool">Play School</a></li>
                              </ul>
                        </div>

                        <!-- CONTACT -->
                        <div class="col-lg-3 footer-col">
                              <h5 class="footer-title">Contact & Connect</h5>
                              <ul class="footer-contact">
                                    <li><i class="bi bi-geo-alt"></i> Dumka, Jharkhand</li>
                                    <li><i class="bi bi-telephone"></i> +91 9431549204</li>
                                    <li><i class="bi bi-envelope"></i> greenmountacademy1996@gmail.com</li>
                              </ul>

                              <div class="footer-social">
                                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                                    <a href="#"><i class="fab fa-instagram"></i></a>
                                    <a href="#"><i class="fab fa-youtube"></i></a>
                              </div>
                        </div>

                  </div>

                  <!-- MOBILE FOOTER NAVIGATION -->
                  <div class="footer-mobile d-lg-none">

                        <!-- HOME -->
                        <div class="footer-accordion-item">
                              <button class="footer-accordion-btn" data-bs-toggle="collapse"
                                    data-bs-target="#homeLinks">
                                    Home
                                    <i class="bi bi-chevron-down"></i>
                              </button>
                              <div class="collapse footer-accordion-content" id="homeLinks">
                                    <a href="index.html#mission">Mission</a>
                                    <a href="index.html#facilities">Facilities</a>
                                    <a href="index.html#events">Events</a>
                                    <a href="index.html#about">About Section</a>
                              </div>
                        </div>

                        <!-- ABOUT -->
                        <div class="footer-accordion-item">
                              <button class="footer-accordion-btn" data-bs-toggle="collapse"
                                    data-bs-target="#aboutLinks">
                                    About
                                    <i class="bi bi-chevron-down"></i>
                              </button>
                              <div class="collapse footer-accordion-content" id="aboutLinks">
                                    <a href="about.html#legacy">Our Legacy</a>
                                    <a href="about.html#mission">Mission & Vision</a>
                                    <a href="about.html#curriculum">Curriculum</a>
                                    <a href="about.html#admission">Admission Process</a>
                              </div>
                        </div>

                        <!-- BRANCHES -->
                        <div class="footer-accordion-item">
                              <button class="footer-accordion-btn" data-bs-toggle="collapse"
                                    data-bs-target="#branchLinks">
                                    Branches
                                    <i class="bi bi-chevron-down"></i>
                              </button>
                              <div class="collapse footer-accordion-content" id="branchLinks">
                                    <a href="branches.html">Main Branch</a>
                                    <a href="branches.html">Baxi Bandh</a>
                                    <a href="branches.html">Jama</a>
                                    <a href="branches.html">Khatikhund</a>
                              </div>
                        </div>

                        <!-- GALLERY -->
                        <div class="footer-accordion-item">
                              <button class="footer-accordion-btn" data-bs-toggle="collapse"
                                    data-bs-target="#galleryLinks">
                                    Gallery
                                    <i class="bi bi-chevron-down"></i>
                              </button>
                              <div class="collapse footer-accordion-content" id="galleryLinks">
                                    <a href="gallery.html#campus">Campus</a>
                                    <a href="gallery.html#classroom">Classrooms</a>
                                    <a href="gallery.html#SciExhi">Science Exhibition</a>
                              </div>
                        </div>

                        <!-- CONTACT QUICK -->
                        <div class="footer-contact-mobile text-center mt-4">
                              <p><i class="bi bi-telephone"></i> +91 9431549204</p>
                              <p><i class="bi bi-envelope"></i> greenmountacademy1996@gmail.com</p>

                              <div class="footer-social-mobile">
                                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                                    <a href="#"><i class="fab fa-instagram"></i></a>
                                    <a href="#"><i class="fab fa-youtube"></i></a>
                              </div>
                        </div>

                  </div>


                  <hr class="footer-divider">

                  <div class="footer-bottom text-center">
                        <p>© 2025 +2 Green Mount Academy | All Rights Reserved</p>
                  </div>

            </div>

      </footer>
      <!-- Smart Scroll Button -->
      <div id="smartScrollWrapper">
            <svg class="progress-ring" width="54" height="54">
                  <circle class="progress-ring__circle" stroke-width="3" fill="transparent" r="24" cx="27" cy="27" />
            </svg>

            <button id="smartScrollBtn">
                  <i class="bi bi-arrow-down"></i>
            </button>
      </div>
      <!-- Enquiry Summit popup -->
       <!-- SUCCESS POPUP -->
      <div id="successPopup" class="success-popup">
            <div class="success-card">
                  <div class="success-icon">
                        <i class="bi bi-check-circle-fill"></i>
                  </div>
                  <h4>Enquiry Submitted Successfully!</h4>
                  <p>
                        Thank you for contacting +2 Green Mount Academy.<br>
                        Our team will reach out to you shortly.
                  </p>
                  <button onclick="closeSuccessPopup()">Close</button>
            </div>
      </div>

      <!-- To Open the succuss popup -->
<?php if(isset($_GET['success']) && $_GET['success'] == 1): ?>
      <script>
            document.addEventListener("DOMContentLoaded", function() {
            const successPopup = document.getElementById("successPopup");
            if (successPopup) {
                  successPopup.classList.add("show");
            }
            // Remove ?success=1 from URL after showing popup
            if (window.history.replaceState) {
                  window.history.replaceState(null, null, window.location.pathname);
            }

      });
      </script>
<?php endif; ?>


</body>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js"></script>
<script src="js/global.js"></script>


</html>