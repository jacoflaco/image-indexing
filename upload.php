<?php session_start();
    $msg = '';
    require_once 'verify_session.php';
    require_once 'submissions.php';
?>
<!doctype html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge='>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    
    <title>Image Indexing</title>

    <link rel='stylesheet' type='text/css' href='css/style.css'>
</head>
<body>
    <?php if($msg){ ?>
    <script> alert($msg); </script>
    <?php } ?>
    <div class='bg-image-container'>
        <!-- *********************************
        * BEGIN TRANSPARENT UPLOAD
        **************************************** -->
        <div class='transparent-upload-container'>
            <form id='upload' method='post' action='upload.php' class='login-form' enctype='multipart/form-data'>
                <!--TODO: make sure that all required fields are required-->
                <label for='date' class='form-label'>Date Taken</label>
                <input type='date' class='col-100' name='date' required>
                <br><br>
                <label for='people' id='people' class='form-label'>People</label>
                <input type='text' class='col-100' name='people' placeholder='John Doe' required>
                <a class='add-people' onclick="add_people()">+ add a person</a>
                <br><br>
                <label for='event' class='form-label'>Event</label>
                <input type='text' class='col-100' name='event' placeholder='Trip to the zoo'>
                <br><br>
                <label for='tags' class='form-label'>Tags</label>
                <input type='text' class='col-100' name='tags' placeholder='Flowers'>
                <br><br>
                <label for='location' class='form-label'>Location (Zip Code)</label>
                <input type='text' class='col-100' name='location' placeholder='46202' maxlength='5' required>
                <br><br>
                <input type='file' id='file' class='col-100 inputfile' name='file' onchange='get_file()' required>
                <label for='file' id='file-label' class='form-label col-100'>Choose a file...</label>
                <input type='submit' class='submit-button' name='upload-submit' value='Upload'>

                <div class='continue'>
                    <a class='continue-link' href='index.php'>Continue as guest</a>
                </div>
            </form>
        </div>
        <!-- END TRANSPARENT UPLOAD **************************************** -->
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
                        $messages = $_SESSION['messages'];
                        foreach($messages as $msg){ ?>
                            <p class='message'> <?php echo $msg; ?> </p>
                    <?php } ?>                    
                </div>
            </div>

        <?php
            // if error message is set, unset messages session
            if(isset($_SESSION['messages']['upload-err'])){
                unset($_SESSION['messages']);
            }
        }
    ?>

    <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
    <script src='js/base.js'></script>
    <script src='js/lightbox.js'></script>
</body>
</html>