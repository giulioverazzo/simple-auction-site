<?php
    include ('myfunctions.php');
    HTTPS(); //enable https
    $array = BIDCompute(0); //calcola il bid attuale
    setcookie("test_cookie", "test", time() + 3600, '/'); //setta un cookie test per capire se sono abilitati o no
    session_start();
    
     if(isset($_SESSION['s225208_myuser'])){
         header('HTTP/1.1 307 temporary redirect');
         header('Location: page2.php?msg=Logged');
         exit; // IMPORTANT to avoid further output from the script
     }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Sito Web Aste Grandi</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="myStyle.css" rel="stylesheet"> 
        <link rel='shortcut icon' type='image/x-icon' href='favicon.ico' />
        <script src="myJSFunctions.js"></script>
        <noscript>
            <p style="font-weight: bold; margin-left: 2em">Javascript è disabilitato. Il sito non funzionerà correttamente.</p>
        </noscript>
    </head>
    <body>
        
        <?php
            if($_SERVER['QUERY_STRING'] == "msg=SessionTimeOut") {
               echo '<script>alert("Sessione scaduta, Accedi di nuovo")</script>';  
            }
        ?>
        
        
        <div id='header'>
            <h1>Sito Web Aste Grandi</h1>
        </div>
        
         
      
        <table id='page_layout_table'>
            <td id='left_menu'>
                
                <p style="font-weight: bold">Accedi o Registrati!</p>
                <input type="button" value="Accedi" onclick="show('signin')">
                <br><br>
                <input type="button" value="Registrati" onclick="show('signup')">
                
                <form id="signin" name="signin" style="display:none" method="post" action="signup_signin.php">
                    
                    <p style="font-weight: bold">Accedi</p>
                        Email <br>
                        <input onmouseover='over("signin_email")' onmouseout='out("signin_email")'type="email" name="signin_email" id="signin_email" required><br>
                        Password <br>
                        <input onmouseover='over("signin_psw")' onmouseout='out("signin_psw")' type="password" name="signin_psw" id="signin_psw" required><br><br>
                        <input type="submit" value='Submit'>                 
                    <p id='p1'></p>
                </form>
                
                
                <form id="signup" name="signup" style="display:none" method="post" action="signup_signin.php">
                                 
                    <p style="font-weight: bold">Registrati</p>
                        Email <br>
                        <input onmouseover='over("signup_email")' onmouseout='out("signup_email")' type="text" name="signup_email" id="signup_email" required><br>
                        Password <br>
                        <input onmouseover='over("signup_psw")' onmouseout='out("signup_psw")'type="password" name="signup_psw" id="signup_psw" required><br>
                        Conferma la password <br>
                        <input onmouseover='over("psw_repeat")' onmouseout='out("psw_repeat")'type="password" name="psw_repeat" id="psw_repeat" required><br><br>
                        <input type="button" onclick="checkForm()" value='Submit'>                 
                    <p id='p1_signup'></p>
                </form>        
            </td>  
            
            <td style='position:relative'>
                <div style='position:absolute; top:5%; left: 20%; bottom:0; font-weight: bold'>
                    <p style='margin-left: 18%'>Oggetto dell'asta: Fender Telecaster</p><br>
                    <img src="telecaster.jpg" style="text-align:center">
                    <div style="margin-left: 18%">
                        <p style='font-weight: bold; margin-left: 0%; text-decoration: underline '>BID attuale :</p>
                        <p style='margin-left: 0%; font-size: 2em'>
                                  <?php echo $array['bid'].'€'; ?>
                        </p>
                        <p style='margin-left: 0%; font-size: 1em'>
                            <?php echo "Miglior offerente: ".$array['best_bidder']; ?>
                        </p>
                    </div>
                </div>
                
            </td>
        </table>
        
            <?php
            if(count($_COOKIE) > 0) {              
                //se sono abilitati niente
            } else {
                //se sono disabilitati vai a index2
                header('HTTP/1.1 307 temporary redirect');
                header('Location: index2.php?msg=noCookies');
                exit; // IMPORTANT to avoid further output from the script
            }
        ?>
        
    </body>
</html>
