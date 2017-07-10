<?php
     include('myfunctions.php');
          
        if(isset($_REQUEST['signup_email']) && isset($_REQUEST['signup_psw']) && isset($_REQUEST['psw_repeat'])){
             //se queste due variabili sono settate, tenta il signup
            
            /*controlla se i campi sono giusti*/
            $email = $_REQUEST['signup_email'];
            $psw = $_REQUEST['signup_psw'];
            $psw_repeat = $_REQUEST['psw_repeat'];
            
            /*controlla email*/
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo "inserisci un'email valida";
                exit();
            }
            
            /*controlla password*/
            $psw_regexp = '/(?=.*[0-9])(?=.*[a-zA-Z])([a-zA-Z0-9]+)(.+)/';
            if(!preg_match($psw_regexp, $psw) === 1) {
                echo "problema con la password";
                exit();
            }
            
            
            $result = signup($_POST['signup_email'],$_POST['signup_psw']);
            if($result == false){
                 echo '<script>alert("email già esistente nel Database"); '
                 . 'window.location.href=\'index.php\'</script>';
            }else {
                session_start();
                $_SESSION['s225208_myuser'] = $_POST['signup_email'];
                myRedirect("",'page2');
            }
                 
             
        }
        
        //check signin
        if(isset($_REQUEST['signin_email']) && isset($_REQUEST['signin_psw'])){
            //se queste due variabili sono settate, tenta il signin
            $result = login($_POST['signin_email'],$_POST['signin_psw']);
            if($result) {
                session_start();
                $_SESSION['s225208_myuser'] = $_POST['signin_email'];
                myRedirect("",'page2');
             } else {
                echo '<script>alert("Email o password errata"); '
                 . 'window.location.href=\'index.php\'</script>';
             }
            
        }
        
        if(isset($_REQUEST['logout'])){
            //performs logout
            session_start();
            session_destroy();
            $_SESSION = array();
            myRedirect("",'index');
        }
        
      
             
?>