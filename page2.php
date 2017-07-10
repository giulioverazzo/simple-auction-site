<?php
    include ('myfunctions.php');
    
    HTTPS(); //abilita HTTPS
    //controlla se sono attivi i cookie
    setcookie("test_cookie", "test", time() + 3600, '/'); //setta un cookie test per capire se sono abilitati o no
    mySession(); //gestisce il periodo di inattività
    if(isset($_SESSION['s225208_myuser'])){
        $userlogged = true;
        $thrError = false;

        //controlla se il valore inserito dall'utente è > del bid attuale
       $array = BIDCompute(0); //calcola il bid attuale
       if($array['bid'] == 1) {
           $firstime = true;
       } else {$firstime = false;}
       
       if(isset($_REQUEST['thr'])){
           
          
            
           /*controlla thr*/
           $thr_regexp = "/^\d+\.?(\d+)?$/";
           if(!preg_match_all($thr_regexp,$_REQUEST['thr']) === 1) {
                echo "THR deve essere un numero";
                exit();
            }
            if($_REQUEST['thr'] <= $array['bid']){
                //errore, thr non può essere minore o uguale di BID
                
                $thrError = true;
               
                //esce l'alert e la pagina si ricarica
            } else {
                $_SESSION['s225208_userthr'] = $_REQUEST['thr'];
                $userthr = $_SESSION['s225208_userthr'];
                $array = BIDCompute($userthr);
            }
             
       }
    } else {
        $userlogged = false;
          header('HTTP/1.1 307 temporary redirect');
          header('Location: index.php?msg=noLogged');
          exit; // IMPORTANT to avoid further output from the script
    }
    
?>


<!DOCTYPE html>
<html id="page" style="display:none">
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
        <div id='header'>
            <h1>Sito Web Aste Grandi</h1>
        </div>
        
        <table id='page_layout_table'>
            <td id='left_menu'>
               <form id="logout" name="logout" method="post" action="signup_signin.php">
                                 
                    <p style="font-weight: bold">Logout</p>
                        <input type="submit" value='Logout' name="logout">                 
                    <p id='p1_signup'></p>
                </form
            </td>  
            
            <td style='position:relative'>   
         
                        <div style='position:absolute; top:5%; left: 20%; bottom:0;'>
                            <p style='margin-left: 18%; font-weight: bold;'>Oggetto dell'asta: Fender Telecaster</p><br>
                           
                            <img src="telecaster.jpg">
                        
                            <div style='margin-left: 18%; font-weight: lighter;' >
                                 <p style='font-weight: bold; margin-left: 0%; text-decoration: underline '>BID attuale :</p>
                                    <p style='margin-left: 0%; font-size: 1.5em'>
                                  <?php echo $array['bid'].'€'; ?>
                                 </p>
                                
                                
                                
                                
                                 <p>Ciao <?php echo $_SESSION["s225208_myuser"]; ?>, la tua ultima offerta è 
                                        <?php 
                                                $thr = thrExtract();
                                                if($thr == 1) {
                                                    echo $thr."€ (Valore iniziale di default)";
                                                } else {
                                                    echo $thr."€";
                                                }
                                        ?></p>
                                    <p id="p_myuser"></p>
                                    <form id="thr_form" method="post" action="page2.php">
                                        <p>Inserisci la tua offerta</p>
                                        <input type='number' name='thr' placeholder="0,00" id="thr" step="any" required>
                                        <input type='button' onclick='checkTHR("thr")' value='submit'>
                                        <p style="color:red" id="p_offer"></p>
                                    </form>
                            </div>
                        </div>
            </td>
        </table>
        
        <?php
            if($userlogged) {
               echo '<script>show("page")</script>';
            }
            if($thrError) {
               echo '<script>document.getElementById("p_offer").innerHTML = "L\'offerta deve essere maggiore del BID!";</script>';
              
            }else echo '<script>document.getElementById("p_offer").innerHTML = "";</script>';
            
            //controlla se è il miglior offerente
            if($thr != 1){
                    if(($array['best_bidder'] == $_SESSION['s225208_myuser'])) {
                        echo '<script>document.getElementById("p_myuser").style.color = "green";'
                        . 'document.getElementById("p_myuser").innerHTML = "Sei il miglior offerente"</script>';
                    }else {
                        echo '<script>document.getElementById("p_myuser").style.color = "red";'
                        . 'document.getElementById("p_myuser").innerHTML ="La tua offerta è stata superata"</script>';
                    }
            }
        ?>
        
        
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
