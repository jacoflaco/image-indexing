<?php session_start(); 
    // declare message variables for later use
    $msg = '';
    $msg1 = '';
?>
<!doctype html>
<html lang='en'>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge='>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    
    <title>Image Indexing</title>

    <link rel='stylesheet' type='text/css' href='css/style.css'>
</head>

<body>
    <!-- *********************************
    * BEGIN CONTROLS
    **************************************** -->
    <div id='controls' class='fixed'>
    <?php
        if(isset($_SESSION['user'])){ ?>
            <!-- IF LOGGED IN
            ************************************ -->
            <div id='sessions' class='col-100'>
                <a href='logout.php' class='session-link left'>Log Out</a>
                <a href='upload.php' class='session-link right'>Upload</a>
            </div>
        <?php }
        else{ ?>
            <!-- IF NOT LOGGED IN
            ************************************ -->
            <div id='sessions' class='col-100'>
                <a href='login.php' class='session-link left'>Log In</a>
            </div>
        <?php } ?>
        
        <!--TODO: Add 'Search only my photos' checkbox for users logged in -->
        <!--TODO: Add suggestions from database for each input box -->
        <!--TODO: make sure that all required fields are required-->
        <form class='form-container row-100 col-80 centered' method='post' action='index.php' onreset='undisplay_grid()'>
            <div class='form-group col-100'>
                <label for='startDate' class='form-label'>Start Date</label>
                <input type='date' class='col-100' name='startDate'>

                <label for='endDate' class='form-label'>End Date</label>
                <input type='date' class='col-100' name='endDate'>
            </div>
            <div class='form-group col-100'>
                <label for='people' id='people' class='form-label'>People</label>
                <input type='text' class='col-100' name='people' placeholder='John Doe'>
                <a class='add-people' onclick="add_people()">+ add a person</a>
            </div>
            <div class='form-group col-100'>
                <label for='event' class='form-label'>Event</label>
                <input type='text' class='col-100' name='event' placeholder='Trip to the zoo'>
            </div>
            <div class='form-group col-100'>
                <label for='tags' class='form-label'>Tags</label>
                <input type='text' class='col-100' name='tags' placeholder='Flowers'>
            </div>
            <div class='form-group col-100'>
                <label for='location' class='form-label'>Location (Zip Code)</label>
                <input id='location' type='text' class='col-100' name='location' placeholder='46202' maxlength='5' required>
                <?php
                if(isset($_SESSION['user'])){ ?>
                    <input type='checkbox' id='user-only' name='user-only'>
                    <label for='user-only'><span></span>Show only my photos</label>
                <?php } ?>
            </div>
            <div class='form-group col-100'>
                <input type='reset' class='form-button search-reset' name='search-reset'> 
                <input type='submit' class='form-button search-submit' name='search-submit'>  
            </div>
        </form>     
    </div>
    <!-- END CONTROLS **************************************** -->

    <!-- display images if search is submitted
    * BEGIN GRID
    ****************************************************** -->
    <?php
        if(isset($_POST['search-submit'])){ 
            require_once 'dbconnect.php'; 
    ?>
        <div id='grid' data-visibility='visible'>
            <div id='grid-container'>
        
            <?php
                //TODO: store all search criteria in local variables
                // store search criteria in local variables
                $location = $_POST['location'];

                //TODO: query all of the search criteria instead of just location
                //TODO: query database with user id if show only my photos is checked
                // retrieve the filename for all images matching the search criteria
                $get = mysqli_query($con, "select filename from images where location = '$location'") or die(mysqli_error($con));

                //TODO: create lightbox message for query fail

                // loop through each image and display it in the grid
                while($row = mysqli_fetch_array($get)){ 
            ?>
                    <a class='full-image' href='img/full/<?php echo $row[0]; ?>'><img class='thumbnail' src='img/tn/<?php echo $row[0]; ?>' alt=''></a>
            <?php } ?>
            </div>
        </div>
    <?php } ?>
    <!-- END GRID **************************************** -->

    <!-- show map if form has not been submitted
    * BEGIN MAP
    ****************************************************** -->
    <div id='map' class='right fixed'>
    </div>
    <!-- END MAP **************************************** -->
    
    <!-- 
    * Lightbox for images
    ************************************************* -->
    <div class='lightbox' data-visibility='hidden'>
        <div class='lightbox-container'>
            <button class='msg-lightbox-close'>&#10006;</button>
            <img class='lightbox-image' alt=''>
        </div>
    </div>

    <!-- 
    * Lightbox for messages
    ************************************************ -->
    <?php 
        // if messages are set from submissions,
        // assign them to variables to display
        if(isset($_SESSION['messages'])){
    ?>
            <div class='msg-lightbox' data-visibility='visible'>
                <div class='msg-lightbox-container'>
                    <button class='msg-lightbox-close'>&#10006;</button>
                    <?php
                        // display all current messages on screen
                        $messages = $_SESSION['messages'];
                        foreach($messages as $msg){ ?>
                            <p class='message'> <?php echo $msg; ?> </p>
                    <?php } ?>                    
                </div>
            </div>

        <?php unset($_SESSION['messages']);
        } 
    ?>
        

    <!-- jQuery
        * base.js - file for random functions
        * lightbox.js - functionality for image/message lightbox
        * maps.js - renderes the google maps panel
        * Google Maps API
    ****************************************************************** -->
    <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
    <script src='js/base.js'></script>
    <script src='js/lightbox.js'></script>
    <script src='js/maps.js'></script>
    <script async defer src='https://maps.googleapis.com/maps/api/js?key=AIzaSyCu3kiN-PMDvDcKiMXTbg8uwTtFDnCc0j4&callback=initMap'></script>
</body>
</html>