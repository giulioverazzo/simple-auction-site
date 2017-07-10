<?php

function sanitizeString($conn, $var) {
	$var = strip_tags($var);
	$var = htmlentities($var);
	$var = stripcslashes($var);
	return mysqli_real_escape_string($conn,$var);
}

function db_connect() {
    
    //sul sito del poli cclix11
    $conn = mysqli_connect('localhost', 's225208','wersojac','s225208');
    
    //sul mio pc
    //$conn = mysqli_connect('localhost', 'root','root','auctions');
    return $conn;
}

function login($utente, $password) {
   
    $conn =  db_connect();
	
	if(!$conn) {
		die('Errore nella connessione('.mysqli_connect_errno().')'.mysqli_connect_error());
	}
        
    //dopo che si è connesso, faccio la query per verificare la password
      $utente = sanitizeString($conn,$utente);  
      
      $sql = "SELECT password FROM utenti WHERE email ='$utente'";
      
      mysqli_autocommit($conn, false);
      $risposta = doQuery($conn,$sql);
         
      if(mysqli_num_rows($risposta) == 0){
          return false;
      }
      $riga = mysqli_fetch_array($risposta, MYSQLI_NUM); //dentro riga c'è il risultato della query sotto forma di array
      if($riga[0] != md5($password)){
          return false;
      }else{
          //utente loggato correttamente
          mysqli_commit($conn);
          mysqli_close($conn);
          return true;
      }
     
      
}

function signup($utente, $password) {
   
    $conn =  db_connect();
	
	if(!$conn) {
            die('Errore nella connessione('.mysqli_connect_errno().')'.mysqli_connect_error());
	}
        
    //dopo che si è connesso, qery di verifica email già esistente
      $utente = sanitizeString($conn,$utente);  
      
      mysqli_autocommit($conn, false);
      $query1 = "SELECT * FROM utenti WHERE email = '".$utente."' FOR UPDATE";
      
      $risposta = doQuery($conn, $query1);
      if(mysqli_num_rows($risposta) != 0){
        //email già esistente nel db
          return false;
      } else {
        //registra l'utente nel DB
          $thr = 1.00;
          
          $utente = sanitizeString($conn,$utente);  
          $password = sanitizeString($conn,$password);  
          $thr = sanitizeString($conn,$thr);  
          
          $query2 = "INSERT INTO utenti VALUES('$utente',md5('$password'),'$thr',CURRENT_TIMESTAMP)";
          $risp = doQuery($conn, $query2);
          if(!$risp) {
              //la insert ritorna TRUE o FALSE
              echo '<script>alert("Errore nella INSERT")</script>';
              return false;
          }
          
          mysqli_commit($conn);
          mysqli_close($conn);
          return true;
      }
     
      
}

function BIDCompute($userthr){
    
      
     $conn =  db_connect();
	
	if(!$conn) {
            die('Errore nella connessione('.mysqli_connect_errno().')'.mysqli_connect_error());
	}
        
       mysqli_autocommit($conn, false);
        
       if($userthr != 0){
            //update the user thr
            $userMail = $_SESSION['s225208_myuser'];
            
            $userthr = sanitizeString($conn,$userthr);  
            $userMail = sanitizeString($conn,$userMail);  
            
            
            $query = "UPDATE utenti SET THR='$userthr' WHERE email='$userMail'";
            $risposta = doQuery($conn, $query);
        }
       
      //estrai il massimo tra i THR, se è 1 allora nessuno ha fatto puntate, il BID è 1.
      $query1 = "SELECT MAX(THR) FROM utenti";
      
      $risposta = doQuery($conn, $query1);
      $riga = mysqli_fetch_array($risposta, MYSQLI_NUM);
      if($riga[0] == 1) {
          //se il max è 1, nessuno ha fatto puntate, il BID è 1
        
          
          $array = array (
              "bid" => ($riga[0]),
              "best_bidder" => "Nessuno"
          );
          mysqli_commit($conn);
          mysqli_close($conn);
          return $array;
          
      } else{
          //estrai nome e timestamp degli utenti che hanno THR max
          $query = "SELECT email FROM utenti WHERE THR='$riga[0]'";
          $risposta = doQuery($conn, $query);
          $best_bidder= '';
          if(mysqli_num_rows($risposta) != 1){
              //ci stanno più di un utente che ha lo stesso THR max
              //quindi prendi quello con timestamp più vecchio, l'utente che ha puntato per primo
              
              $query = "SELECT email FROM utenti WHERE time_stamp = (SELECT MIN(time_stamp) FROM utenti WHERE THR='$riga[0]')";
              $risp = doQuery($conn, $query);
              $best_bidder = mysqli_fetch_array($risp, MYSQLI_NUM);
              
              //il comportamento è diverso se due utenti hanno lo stesso THR. L'utente con timestamp più piccolo
              //è il best bidder e il BID diventa il THR massimo.
              
               $array = array (
                   "bid" => $riga[0],
                   "best_bidder" => $best_bidder[0]
               );
               
               mysqli_commit($conn);
               mysqli_close($conn);
               return $array;
              
              
          }else {
             
              $best_bidder = mysqli_fetch_array($risposta, MYSQLI_NUM);
          }
          //ora che so chi è il miglior offerente, calcolo il bid
          $query = "SELECT MAX(THR) FROM utenti WHERE THR != '$riga[0]'";
          $risp = doQuery($conn, $query);
          $new_bid = mysqli_fetch_array($risp, MYSQLI_NUM);
          
          if($new_bid[0] == 1) {
              //solo un utente ha puntato
              $array = array ("bid" => ($new_bid[0]), "best_bidder" => $best_bidder[0]);  
          } else {
              //due o piu utenti hanno puntato
              $array = array ("bid" => ($new_bid[0] + 0.01), "best_bidder" => $best_bidder[0]); 
          }
          
          
          mysqli_commit($conn);
          mysqli_close($conn);
          return $array;

      }
     
}

function thrExtract() {
    
   $conn =  db_connect();
	
	if(!$conn) {
            die('Errore nella connessione('.mysqli_connect_errno().')'.mysqli_connect_error());
	}
        
         $userMail = $_SESSION['s225208_myuser'];
         
         $userMail = sanitizeString($conn,$userMail);  
         mysqli_autocommit($conn, false);
         
         $query = "SELECT THR FROM utenti WHERE email='$userMail'";
         $risp = doQuery($conn, $query);
         $thr = mysqli_fetch_array($risp, MYSQLI_NUM);        
        
         mysqli_commit($conn);
         mysqli_close($conn);
         return $thr[0];
    
    
}



function doQuery($conn,$query) {
   
    $risposta = mysqli_query($conn,$query);
    if(!$risposta) {
         mysqli_rollback($conn);
         die("Errore nella query =".mysqli_error($conn));
         exit;
    }
    return $risposta;
}

function myRedirect($msg="", $where) {
        header('HTTP/1.1 307 temporary redirect'); // L’URL relativo è accettato solo da HTTP/1.1 
        header("Location: ".$where.".php?msg=".urlencode($msg)); //se si vuole inserire un messaggio di errore nell'URL
        exit; // Necessario per evitare ulteriore processamento della pagina
}

function mySession(){
    session_start(); 
        $t=time();
        $diff=0;
        $new=false;
        if (isset($_SESSION['s225208_time'])){
            $t0=$_SESSION['s225208_time'];
            $diff=($t-$t0);  // inactivity period
        } else {
            $new=false;
        }
        if ($new || ($diff > 120)) { // if inactivity for 120 seconds (2 minutes)
            //session_unset(); 	// Deprecated
            $_SESSION=array();

            // If it's desired to kill the session, also delete the session cookie.
            // Note: This will destroy the session, and not just the session data!
            if (ini_get("session.use_cookies")) {
                $params = session_get_cookie_params();
                setcookie(session_name(), '', time() - 3600*24,
                    $params["path"], $params["domain"],
                    $params["secure"], $params["httponly"]
                );
            }
            session_destroy();  // destroy session
            // redirect client to login page
            header('HTTP/1.1 307 temporary redirect');
            header('Location: index.php?msg=SessionTimeOut');
            exit; // IMPORTANT to avoid further output from the script
        } else {
            $_SESSION['s225208_time']=time(); /* update time */
            //echo '<html><body>Updated last access time: '.$_SESSION['time'].'</body></html>';
        }
}


function HTTPS() {
    if ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')) { 

          // La richiesta e' stata fatta su HTTPS
        } else {
            // Redirect su HTTPS 

            // eventuale distruzione sessione e cookie relativo 
            $_SESSION=array();
            session_destroy(); 
            
            $redirect = 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
            header('HTTP/1.1 301 Moved Permanently'); 
            header('Location: '.$redirect); 
            exit();
        }
    
}


?>
