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
    <link rel="stylesheet" href="Home_page.css?v=4" />
  </head>
  <body>
    <!-- header / navbar -->
    <header>
      <nav class="navbar section-content">
        <a href="#" class="nav-logo">
          <h2 class="logo-text">Hotel <span>Iloilo</span></h2>
        </a>
        <ul class="nav-menu">
          <button id="menu-close-button" class="fas fa-times"></button>
          <li class="nav-item">
            <a href="#home" class="nav-links">Home</a>
          </li>
          <li class="nav-item">
            <a href="#about" class="nav-links">About</a>
          </li>
          <li class="nav-item">
            <a href="#rooms" class="nav-links">Rooms</a>
          </li>
          <li class="nav-item">
            <a href="#gallery" class="nav-links">Gallery</a>
          </li>
          <li class="nav-item">
            <a href="#contact" class="nav-links">Contact</a>
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
      <section class="hero-section" id="home">
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
              <a href="#contact" class="button contact-us">Contact Us</a>
            </div>
          </div>
        </div>
      </section>

      <!-- about section -->
      <section class="about-section" id="about">
        <div class="section-content">
          <span class="eyebrow">Who we are</span>
          <h2 class="section-title">About Us</h2>
          <div class="about-grid">
            <div class="about-image">
              <img src="hotel_logo.avif" alt="Hotel building" />
            </div>
            <div class="about-details">
              <h3>Your home away from home in Iloilo</h3>
              <p>
                Located in the heart of Iloilo City, our hotel offers a calm and
                comfortable place to stay for families, couples and business
                travelers. Every room is clean, well-kept and designed to help
                you relax after a long day.
              </p>
              <p>
                Our friendly staff is ready to help you with anything you need,
                from booking your room to recommending the best places to eat
                and visit around the city.
              </p>
              <div class="about-stats">
                <div>
                  <span class="number">8</span>
                  <span class="label">Rooms</span>
                </div>
                <div>
                  <span class="number">5</span>
                  <span class="label">Room Types</span>
                </div>
                <div>
                  <span class="number">24/7</span>
                  <span class="label">Front Desk</span>
                </div>
              </div>
            </div>
          </div>

          <div class="features">
            <div class="feature">
              <i class="fa-solid fa-wifi"></i>
              <h4>Free Wi-Fi</h4>
              <p>Fast internet in every room and common area.</p>
            </div>
            <div class="feature">
              <i class="fa-solid fa-utensils"></i>
              <h4>Restaurant</h4>
              <p>Local and international dishes served daily.</p>
            </div>
            <div class="feature">
              <i class="fa-solid fa-square-parking"></i>
              <h4>Free Parking</h4>
              <p>Safe parking space for all our guests.</p>
            </div>
            <div class="feature">
              <i class="fa-solid fa-bell-concierge"></i>
              <h4>24/7 Service</h4>
              <p>Our staff is always ready to assist you.</p>
            </div>
          </div>
        </div>
      </section>

      <!-- rooms section -->
      <section class="rooms-section" id="rooms">
        <div class="section-content">
          <span class="eyebrow">Stay with us</span>
          <h2 class="section-title">Our Rooms</h2>
          <p class="section-subtitle">Choose the room that fits your stay</p>

          <div class="room-list">
            <div class="room-card">
              <img src="images/images5.jpg" alt="Standard Room" class="room-image" />
              <div class="room-body">
                <h3>Standard Room</h3>
                <p class="room-meta">22 sqm &middot; City-side window</p>
                <p class="room-desc">
                  A quiet, practical twin room for solo travelers, friends or
                  colleagues on a short stay.
                </p>
                <ul>
                  <li><i class="fa-solid fa-user"></i> Good for 1-2 guests</li>
                  <li><i class="fa-solid fa-bed"></i> 2 Single beds</li>
                  <li><i class="fa-solid fa-snowflake"></i> Air-conditioned</li>
                  <li><i class="fa-solid fa-shower"></i> Hot &amp; cold shower</li>
                </ul>
                <div class="room-footer">
                  <span class="price">₱2,500<small>/night</small></span>
                  <a href="Booking.html" class="room-button">Book Now</a>
                </div>
              </div>
            </div>

            <div class="room-card">
              <img src="images/images4.jpg" alt="Deluxe Room" class="room-image" />
              <div class="room-body">
                <h3>Deluxe Room</h3>
                <p class="room-meta">28 sqm &middot; City view</p>
                <p class="room-desc">
                  More space, a work desk and a bigger bed. Good for business
                  trips and longer stays.
                </p>
                <ul>
                  <li><i class="fa-solid fa-user"></i> Good for 2 guests</li>
                  <li><i class="fa-solid fa-bed"></i> 1 Queen bed</li>
                  <li><i class="fa-solid fa-tv"></i> Smart TV &amp; mini bar</li>
                  <li><i class="fa-solid fa-laptop"></i> Work desk</li>
                </ul>
                <div class="room-footer">
                  <span class="price">₱3,800<small>/night</small></span>
                  <a href="Booking.html" class="room-button">Book Now</a>
                </div>
              </div>
            </div>

            <div class="room-card">
              <img src="images/image1.jpg" alt="Family Room" class="room-image" />
              <div class="room-body">
                <h3>Family Room</h3>
                <p class="room-meta">40 sqm &middot; Garden view</p>
                <p class="room-desc">
                  Two big beds and room to move around, with breakfast for the
                  whole family included.
                </p>
                <ul>
                  <li><i class="fa-solid fa-user"></i> Good for 4-5 guests</li>
                  <li><i class="fa-solid fa-bed"></i> 2 Queen beds</li>
                  <li><i class="fa-solid fa-mug-hot"></i> Free breakfast</li>
                  <li><i class="fa-solid fa-couch"></i> Sofa bed on request</li>
                </ul>
                <div class="room-footer">
                  <span class="price">₱5,200<small>/night</small></span>
                  <a href="Booking.html" class="room-button">Book Now</a>
                </div>
              </div>
            </div>

            <div class="room-card">
              <img src="images/image2.jpg" alt="Suite Room" class="room-image" />
              <div class="room-body">
                <h3>Suite Room</h3>
                <p class="room-meta">55 sqm &middot; City view</p>
                <p class="room-desc">
                  A separate living area and a larger bathroom with a tub, for
                  guests who want a little extra.
                </p>
                <ul>
                  <li><i class="fa-solid fa-user"></i> Good for 2-3 guests</li>
                  <li><i class="fa-solid fa-bed"></i> 1 King bed &amp; living area</li>
                  <li><i class="fa-solid fa-bath"></i> Bathtub</li>
                  <li><i class="fa-solid fa-mug-hot"></i> Breakfast for 2</li>
                </ul>
                <div class="room-footer">
                  <span class="price">₱7,500<small>/night</small></span>
                  <a href="Booking.html" class="room-button">Book Now</a>
                </div>
              </div>
            </div>

            <div class="room-card">
              <img src="images/images3.jpg" alt="Presidential Suite" class="room-image" />
              <div class="room-body">
                <h3>Presidential Suite</h3>
                <p class="room-meta">90 sqm &middot; Top floor, city view</p>
                <p class="room-desc">
                  Our largest room: two bedrooms, a private lounge and a dining
                  area on the top floor.
                </p>
                <ul>
                  <li><i class="fa-solid fa-user"></i> Good for 4 guests</li>
                  <li><i class="fa-solid fa-bed"></i> 2 King bedrooms</li>
                  <li><i class="fa-solid fa-city"></i> City view &amp; private lounge</li>
                  <li><i class="fa-solid fa-car"></i> Free airport pickup</li>
                </ul>
                <div class="room-footer">
                  <span class="price">₱15,000<small>/night</small></span>
                  <a href="Booking.html" class="room-button">Book Now</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- policies section -->
      <section class="policies-section" id="policies">
        <div class="section-content">
          <span class="eyebrow">Before you book</span>
          <h2 class="section-title">Good to Know</h2>

          <div class="policy-grid">
            <div class="policy">
              <h4><i class="fa-regular fa-clock"></i> Check-in / Check-out</h4>
              <p>Check-in starts at 2:00 PM. Check-out is until 12:00 NN.</p>
              <p class="policy-note">Early check-in and late check-out depend on room availability.</p>
            </div>
            <div class="policy">
              <h4><i class="fa-regular fa-calendar-xmark"></i> Cancellation</h4>
              <p>Free cancellation up to 48 hours before your check-in date.</p>
              <p class="policy-note">Late cancellations and no-shows are charged one night.</p>
            </div>
            <div class="policy">
              <h4><i class="fa-regular fa-id-card"></i> Valid ID</h4>
              <p>Please bring one valid government-issued ID when you check in.</p>
              <p class="policy-note">Guests must be at least 18 years old to book.</p>
            </div>
            <div class="policy">
              <h4><i class="fa-solid fa-child"></i> Children &amp; Extra Bed</h4>
              <p>Kids below 7 stay free when using the existing beds.</p>
              <p class="policy-note">Extra bed: &#8369;800 per night.</p>
            </div>
            <div class="policy">
              <h4><i class="fa-solid fa-ban-smoking"></i> No Smoking</h4>
              <p>All rooms and indoor areas are non-smoking.</p>
              <p class="policy-note">A smoking area is available near the parking lot.</p>
            </div>
            <div class="policy">
              <h4><i class="fa-solid fa-paw"></i> Pets</h4>
              <p>Pets are not allowed inside the hotel.</p>
              <p class="policy-note">Service animals are welcome.</p>
            </div>
          </div>
        </div>
      </section>

      <!-- gallery section -->
      <section class="gallery-section" id="gallery">
        <div class="section-content">
          <span class="eyebrow">Take a look</span>
          <h2 class="section-title">Gallery</h2>
          <p class="section-subtitle">A look around our hotel</p>

          <div class="gallery">
            <div class="gallery-item large">
              <img src="hotel_logo.avif" alt="Hotel" />
              <span class="caption">Our Hotel</span>
            </div>
            <div class="gallery-item">
              <img src="images/image2.jpg" alt="Rooms" />
              <span class="caption">Rooms</span>
            </div>
            <div class="gallery-item">
              <img src="images/restaurant.jpg" alt="Restaurant" />
              <span class="caption">Restaurant</span>
            </div>
            <div class="gallery-item">
              <img src="images/pool.jpg" alt="Pool" />
              <span class="caption">Pool</span>
            </div>
            <div class="gallery-item">
              <img src="images/events.jpg" alt="Events" />
              <span class="caption">Events</span>
            </div>
          </div>
        </div>
      </section>

      <!-- reviews section -->
      <section class="reviews-section" id="reviews">
        <div class="section-content">
          <span class="eyebrow">Guest reviews</span>
          <h2 class="section-title">What Our Guests Say</h2>

          <div class="review-list">
            <figure class="review">
              <div class="stars" aria-label="5 out of 5 stars">
                <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
              </div>
              <blockquote>
                Clean room, fast Wi-Fi and the front desk helped us find a good
                place for batchoy. We will stay here again.
              </blockquote>
              <figcaption>Maria S. &middot; Deluxe Room &middot; Manila</figcaption>
            </figure>
            <figure class="review">
              <div class="stars" aria-label="5 out of 5 stars">
                <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
              </div>
              <blockquote>
                The Family Room was big enough for the five of us and breakfast
                was included. Easy to book online.
              </blockquote>
              <figcaption>John R. &middot; Family Room &middot; Bacolod</figcaption>
            </figure>
            <figure class="review">
              <div class="stars" aria-label="4 out of 5 stars">
                <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-regular fa-star"></i>
              </div>
              <blockquote>
                Good location for work trips, close to the business park. The
                room was quiet even on a weekday.
              </blockquote>
              <figcaption>Carlo D. &middot; Standard Room &middot; Cebu</figcaption>
            </figure>
          </div>
        </div>
      </section>

      <!-- nearby section -->
      <section class="nearby-section" id="nearby">
        <div class="section-content">
          <span class="eyebrow">Around the hotel</span>
          <h2 class="section-title">Nearby Places</h2>

          <ul class="nearby-list">
            <li>
              <span class="place">Iloilo River Esplanade</span>
              <span class="distance">5 min drive</span>
            </li>
            <li>
              <span class="place">SM City Iloilo</span>
              <span class="distance">10 min drive</span>
            </li>
            <li>
              <span class="place">Iloilo Business Park &amp; Festive Walk</span>
              <span class="distance">10 min drive</span>
            </li>
            <li>
              <span class="place">Molo Church</span>
              <span class="distance">15 min drive</span>
            </li>
            <li>
              <span class="place">Jaro Cathedral</span>
              <span class="distance">15 min drive</span>
            </li>
            <li>
              <span class="place">Iloilo International Airport</span>
              <span class="distance">35 min drive</span>
            </li>
          </ul>
        </div>
      </section>

      <!-- faq section -->
      <section class="faq-section" id="faq">
        <div class="section-content">
          <span class="eyebrow">Questions</span>
          <h2 class="section-title">Frequently Asked Questions</h2>

          <div class="faq-list">
            <details>
              <summary>Is parking free?</summary>
              <p>Yes. Parking is free for all checked-in guests, first come first served.</p>
            </details>
            <details>
              <summary>Do you offer airport pickup?</summary>
              <p>
                Yes. Airport pickup costs &#8369;1,200 per trip and is free for
                Presidential Suite guests. Add it in the special requests box
                when you book.
              </p>
            </details>
            <details>
              <summary>Is breakfast included?</summary>
              <p>
                Breakfast is included for the Family Room, Suite Room and
                Presidential Suite. For other rooms it is &#8369;350 per person.
              </p>
            </details>
            <details>
              <summary>What payment methods do you accept?</summary>
              <p>Cash, credit card, debit card, GCash and Maya.</p>
            </details>
            <details>
              <summary>Can I change or cancel my booking?</summary>
              <p>
                You can view your bookings in your profile. To change or cancel,
                contact the front desk at least 48 hours before check-in.
              </p>
            </details>
          </div>
        </div>
      </section>

      <!-- contact section -->
      <section class="contact-section" id="contact">
        <div class="section-content">
          <span class="eyebrow">Get in touch</span>
          <h2 class="section-title">Contact Us</h2>
          <p class="section-subtitle">We would love to hear from you</p>

          <div class="contact-grid">
            <ul class="contact-info">
              <li>
                <i class="fa-solid fa-location-dot"></i>
                <div>
                  <h4>Address</h4>
                  <p>Iloilo City, Iloilo, Philippines</p>
                </div>
              </li>
              <li>
                <i class="fa-solid fa-phone"></i>
                <div>
                  <h4>Phone</h4>
                  <p>+63 912 345 6789</p>
                </div>
              </li>
              <li>
                <i class="fa-solid fa-envelope"></i>
                <div>
                  <h4>Email</h4>
                  <p>info@hoteliloilo.com</p>
                </div>
              </li>
              <li>
                <i class="fa-solid fa-clock"></i>
                <div>
                  <h4>Front Desk</h4>
                  <p>Open 24 hours, 7 days a week</p>
                </div>
              </li>
            </ul>

            <div class="map">
              <iframe
                src="https://www.google.com/maps/embed?origin=mfe&amp;pb=!1m2!2m1!1sIloilo+City"
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
                allowfullscreen
                title="Hotel location"
              ></iframe>
            </div>
          </div>
        </div>
      </section>
    </main>

    <!-- footer -->
    <footer class="site-footer">
      <div class="section-content footer-grid">
        <div>
          <h3 class="footer-logo">Hotel <span>Iloilo</span></h3>
          <p>
            A comfortable stay in the heart of Iloilo City, for families,
            couples and business travelers.
          </p>
        </div>
        <div>
          <h4>Quick Links</h4>
          <ul>
            <li><a href="#rooms">Rooms</a></li>
            <li><a href="#policies">Good to Know</a></li>
            <li><a href="#faq">FAQ</a></li>
            <li><a href="Booking.html">Book Now</a></li>
            <li><a href="profile.php">My Profile</a></li>
          </ul>
        </div>
        <div>
          <h4>Contact</h4>
          <ul>
            <li>Iloilo City, Iloilo, Philippines</li>
            <li>+63 912 345 6789</li>
            <li>info@hoteliloilo.com</li>
          </ul>
        </div>
        <div>
          <h4>Follow Us</h4>
          <ul class="socials">
            <li><a href="#" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a></li>
            <li><a href="#" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a></li>
            <li><a href="#" aria-label="TikTok"><i class="fa-brands fa-tiktok"></i></a></li>
          </ul>
        </div>
      </div>
      <div class="footer-bottom">
        <div class="section-content">
          &copy; <?php echo date("Y"); ?> Hotel Iloilo. All rights reserved.
        </div>
      </div>
    </footer>

    <script src="script.js?v=2"></script>
  </body>
</html>
