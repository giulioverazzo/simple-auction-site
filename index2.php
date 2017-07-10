<?php

    setcookie("test_cookie", "test", time() + 3600, '/'); //setta un cookie test per capire se sono abilitati o no
    
   
     if(count($_COOKIE) > 0) {       
        //se sono abilitati torna a index
        header('HTTP/1.1 307 temporary redirect');
        header('Location: index.php?msg=');
        exit; // IMPORTANT to avoid further output from the script  
     } else {
        //se sono disabilitati resta su questa pagina 
        echo "I cookie sono disabilitati. Abilitali per poter usare il sito.";
     }
    
?>
