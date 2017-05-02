<?php session_start();
    require_once 'submissions.php';

    if(isset($_SESSION['user'])) {
        header('location: index.php');
    }
    
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
    <div class='bg-image-container'>
        <!-- *********************************
        * BEGIN TRANSPARENT LOGIN
        **************************************** -->
        <div class='transparent-login-container'>
            <button id='register-switch' class='switch-button'>Register</button>
            <button id='login-switch' class='switch-button'>Log In</button>
            <!-- LOGIN FORM
            ************************************ -->
            <form id='login' method='post' action='login.php' class='login-form'>
                <label for='email' class='login-label'>Email</label>
                <input type='email' class='login-input' name='email'>

                <label for='password' class='login-label'>Password</label>
                <input type='password' class='login-input' name='password'>

                <input type='submit' class='submit-button' name='login-submit' value='Log In'>

                <div class='continue'>
                    <a class='continue-link' href='index.php'>Continue as guest</a>
                </div>
            </form>

            <!-- REGISTER FORM
            ************************************ -->
            <form id='register' method='post' action='login.php' class='login-form'>
                <label for='email' class='login-label'>Email</label>
                <input type='email' class='login-input' name='email'>

                <label for='password' class='login-label'>Password</label>
                <input type='password' class='login-input' name='password'>

                <input type='submit' class='submit-button' name='register-submit' value='Register'>

                <div class='continue'>
                    <a class='continue-link' href='index.php'>Continue as guest</a>
                </div>
            </form>
        </div>
        <!-- END TRANSPARENT LOGIN **************************************** -->
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
                        // display all current messages
                        $messages = $_SESSION['messages'];
                        foreach($messages as $msg){ ?>
                            <p class='message'> <?php echo $msg; ?> </p>
                    <?php } ?>                    
                </div>
            </div>

        <?php 
            // if register message is not set, unset messages
            if(!isset($_SESSION['messages']['register'])){
                unset($_SESSION['messages']);
            }
        }
    ?>

    <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
    <script src='js/base.js'></script>
    <script src='js/lightbox.js'></script>
</body>
</html>