<?php
require_once "includes/layout3.php";
?>
<title>Find accommodations and roommates around your campus</title>
  <div class="jumbotron text-center search">
    <header class="color">
      <h2>
        <!--<span class="hidden-xs">Why stress yourself?</span> -->
       
          Find accommodations around your campus</span>
      </h2>
    </header>
        <form class="navbar-form" role="form" action="home.php" method="get">

            <labels class="sr-only" for="University select">Choose University</labels>
            <select class="form-control  input-lg form-size" name="school" placeholder="Where do you school?">
              <option value ="">Where do you school?</option>
              <option value="Federal University of Technology, Akure">Federal University of Technology, Akure</option>
              <option value="Ladoke Akintola University of Technology">Ladoke Akintola University of Technology</option>
              <option value="Lagos State University">Lagos State University</option>
              <option value="University of Ibadan">University of Ibadan</option>
              <option value="University of Lagos">University of Lagos</option>
              
             
            </select>

            <labels class="sr-only" for="Accomodation type">Choose Accomodation type</labels>
            <select  class="form-control form-control input-lg form-size" name="accommodation" placeholder="Choose Accomodation type">
              <option value="">Choose accomodation type</option>
              <option value="one room">One Room</option>
              <option value="one room self-contain">One Room Self-Contain</option>
              <option value="room and parlor">Room and Parlour</option>
              <option value="2 bedroom flat">2 Bedroom Flat</option>
              <option value="3 bedroom flat">3 Bedroom Flat</option>
              <option value="see all">See All</option>
            </select>

            <labels class="sr-only" for="price Range" placeholder="what is your budget?">Choose price Range</labels>
            <select class="form-control form-control input-lg form-size" name="price" placeholder="what is your budget?">
              <option value ="">What is your budget?</option>
              <option value="0-50,000">0 - 50,000</option>
              <option value="50,000-100,000">50,000 - 100,000</option>
              <option value="100,000-150,000">100,000 - 150,000</option>
              <option value="150,000-200,000">150,000 - 200,000</option>
              <option value="200,000 and above">200,000 and above</option>
              <option value="see all">See All</option>
            </select>
</br>
          <input type="submit" name="submit" value="Search" class="btn btn-success btn-lg ">
        </form>
      <div class="col-md-6 col-md-offset-3">
      <div class="jumbotron social-links text-center">
          <a href='roommate.php' class="btn btn-danger" style='margin-top: 10px;'>Find a roommate here</a></br><p class='help-text' style="font-size: 14px; font-weight: bold; font-style: italic;">It only takes 2minutes 30seconds</p>
          
          <h4 style="font-size: 15px;">Chat with us on WhatsApp:<strong> 080 63 321 043 </strong> or join our WhatsApp Group <a href='https://chat.whatsapp.com/C8WW8BfcWDRCQ0hGE7sl0T' style="color: red;">here</a>.        
          </h4>
          

      </div>
    </div>  
    </div> <!-- Jumbotron ends here -->
    
  <footer>  
    <hr>
    <div class="container text-center" id="copyright">
      
      <p>
        <span><a href="about.php">About Us</a></span><span><a href="blog.php">Blog</a></span><span><a href="contact.php">Contact Us</a></span>
      </p>
      
      <p style="margin-left: 10px;">Copyright © 2016 Offcampus Enterprise. All rights reserved.</p>
    </div>
  </footer>
