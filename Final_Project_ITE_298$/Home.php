<?php

session_start();

if (!isset($_SESSION['userID'])){
  header("Location: LoginForm.html");
  exit();
}
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Hotel Iloilo</title>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.3.1/css/all.min.css"
    />
    <link rel="stylesheet" href="Home_page.css" />
  </head>
  <body>
    <!-- header / navbar -->
    <header>
      <nav class="navbar section-content">
        <a href="#" class="nav-logo">
          <h2 class="logo-text">🏨 Hotel</h2>
        </a>
        <ul class="nav-menu">
          <button id="menu-close-button" class="fas fa-times"></button>
          <li class="nav-item">
            <a href="#" class="nav-links">Home</a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-links">About</a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-links">Rooms</a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-links">Gallery</a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-links">Contact</a>
          </li>
          <li class="nav-item">
            <a href="Booking.html" class="nav-links">Book Now</a>
          </li>
          <li class="nav-item">
            <a href="profile.php" class="nav-links">Profile</a>
          </li>
        </ul>
        <button id="menu-open-button" class="fas fa-bars"></button>
      </nav>
    </header>

    <!-- hero section -->
    <main>
      <section class="hero-section">
        <div class="section-content">
          <div class="hero-details">
            <h2 class="title">Best Hotel in iloilo</h2>
            <h3 class="subtitle">Your perfect stay awaites you here</h3>
            <p class="description">
              Discover serenity and luxury at our exquisite hotels. Unwind
              Comfort indulge in impeceable service and create unforgettable
              memories with us.
            </p>
            <div class="buttons">
              <a href="Booking.html" class="button order-now">Book Now</a>
              <a href="#" class="button contact-us">Contact Us</a>
            </div>
          </div>
        </div>
      </section>
    </main>

    <script src="script.js"></script>
  </body>
</html>
