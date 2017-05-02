<?php 
    require_once 'dbconnect.php';
    require_once 'functions.php';

    /* *****************************
     * LOGIN
     *************************************/
    if(isset($_POST['login-submit'])){
        // trim and save from bad code/sql injection
        $email = trim(htmlentities($_POST['email']));
        $pwd = trim(htmlentities($_POST['password']));

        $email = mysqli_real_escape_string($con, $email);
        $pwd = mysqli_real_escape_string($con, $pwd);

        // encrypt password
        $pwd = sha1($pwd);

        // find email from database with matching password
        $sql = mysqli_query($con, "select email from users where pwd = '$pwd'");
        $output = mysqli_fetch_array($sql);
        $db_email = $output['email'];

        // find password from database with matching email
        $sql = mysqli_query($con, "select pwd from users where email = '$email'");
        $output = mysqli_fetch_array($sql);
        $db_pwd = $output['pwd'];

        // if both found and matching
        if ($db_email === $email && $db_pwd === $pwd){
            // retrieve user information where email and password match
            $get = mysqli_query($con, "select * from users where email = '$email' AND pwd = '$pwd' ") or die(mysql_error());
            $_SESSION['user'] = mysqli_fetch_assoc($get);

            header('location: index.php');
        } else {
            // if login fails, send a message
            $msg = "You've entered invalid login information, please try again.";
            $_SESSION['messages']['login'] = $msg;
        }
    }

     /* *****************************
     * REGISTER
     *************************************/
    if(isset($_POST['register-submit'])){
        // trim and save from bad code/sql injection
        $email = trim(htmlentities($_POST['email']));
        $pwd = trim(htmlentities($_POST['password']));

        $email = mysqli_real_escape_string($con, $email);
        $pwd = mysqli_real_escape_string($con, $pwd);

        // encrypt password
        $pwd = sha1($pwd);

        // store new data in users table
        $sql = "insert into users (email, pwd) values ('".$email."', '".$pwd."')";
        $check = mysqli_query($con, $sql);

        // if couldn't insert, send error message
        if(!$check) {
            $msg = "Could not enter data: " . mysqli_error($con) . "Please try again.";
            $_SESSION['messages']['register'] = $msg;

        // if inserted, store user info in session and send success message to index page
        } else {
            $msg = 'You\'re information was registered. Use the search panel on the left to find your pictures';
            
            $get = mysqli_query($con, "select * from users where email = '$email' AND pwd = '$pwd' ") or die(mysqli_error($con));
            $_SESSION['user'] = mysqli_fetch_assoc($get);

            $_SESSION['messages']['register'] = $msg;
            header('location: index.php');
        }     
    }

    /* *****************************
     * UPLOAD
     *************************************/
    if(isset($_POST['upload-submit'])){
        // trim and save from bad code/sql injection
        $date = trim(htmlentities($_POST['date']));
        $event = trim(htmlentities($_POST['event']));
        $tags = trim(htmlentities($_POST['tags']));
        $location = trim(htmlentities($_POST['location']));

        $date = mysqli_real_escape_string($con, $date);
        $event = mysqli_real_escape_string($con, $event);
        $tags = mysqli_real_escape_string($con, $tags);
        $location = mysqli_real_escape_string($con, $location);

        //TODO: use Geocoding API to store lat, lng, and zipcode into a zipcode table
        
        //TODO: here is where you will put filename on a counter to avoid duplicates
        // store filepath for original image
        $target = 'img/full/' . basename($_FILES['file']['name']);
        // store name of image
        $image = $_FILES['file']['name'];
        // store user_id in local variable
        $user_id = $_SESSION['user']['user_id'];

        //TODO: check tags table to add any new tags and connect all tags with the new image

        // insert image and user info into images table
        $sql = "insert into images (date, location, event, user_id, filename) values ('".$date."', '".$location."', '".$event."', '".$user_id."', '".$image."')";
        $check = mysqli_query($con, $sql);

        // if couldn't insert, send error message
        if(!$check) {
            $msg = "Could not enter data: " . mysqli_error($con);
            $_SESSION['messages']['upload-err'] = $msg;

        // else upload the files
        } else{
            // if successfully uploaded files, create thumbnail,
            // retrieve image_id from database and store each person with image_id
            // send success message to index
            if(move_uploaded_file($_FILES['file']['tmp_name'], $target)){
                $msg = "Image uploaded successfully";

                $msg1 = create_thumbnail($target, $image);

                //TODO: check people table to add any new people and connect all people with the new image
                //TODO: change query based on how many people were added and below make the request
                // RETRIEVE IMAGE_ID, STORE ALL PEOPLE AS AN ENTRY IN THE PEOPLE TABLE WITH THIS IMAGE_ID
                $people = trim(htmlentities($_POST['people']));
                if(isset($_POST['people1'])){
                    $people1 = trim(htmlentities($_POST['people1']));
                    if(isset($_POST['people2'])){
                        $people2 = trim(htmlentities($_POST['people2']));
                        if(isset($_POST['people3'])){
                            $people3 = trim(htmlentities($_POST['people3']));
                        }
                    }
                }
                
                $_SESSION['messages']['upload'] = $msg;
                $_SESSION['messages']['upload1'] = $msg1;
                header('location: index.php');
            
            // else send error message
            } else{
                $msg = "There was a problem uploading the image";
                $_SESSION['messages']['upload-err'] = $msg;
            }
        }        
    }
?>