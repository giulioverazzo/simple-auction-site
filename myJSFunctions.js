function checkForm() {
                  var psw = document.getElementById("signup_psw").value;
                  var psw_repeat = document.getElementById("psw_repeat").value;
                  var email = document.getElementById("signup_email").value;
                  var emailregexp = /[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/;
                  var regexp = /(?=.*[0-9])(?=.*[a-zA-Z])([a-zA-Z0-9]+)(.+)/;  
                  if(!emailregexp.test(email))
                  { //email errata
                      document.getElementById('p1_signup').innerHTML = "inserisci una email valida";       
                  } else {
                      //Password check
                      //controlla se le password sono uguali
                      if(psw !== psw_repeat) {
                        document.getElementById('p1_signup').innerHTML = "le password non coincidono";  
                      } else{
                            if(!regexp.test(psw)){
                              document.getElementById('p1_signup').innerHTML = "La password deve contenere almeno un numero ed una lettera";                     
                            } else {
                              document.getElementById('p1_signup').innerHTML = "";
                              document.getElementById('signup').submit();                      
                            } 
                      }
                  }                    
              }
                            
function show(what) {
                switch (what) {
                      case 'signin' : document.getElementById('signup').style.display ='none';
                                      document.getElementById('signin').style.display = '';
                                      break;
                          
                      case 'signup' : document.getElementById('signup').style.display ='';
                                      document.getElementById('signin').style.display ='none';
                                      break;
                      case 'page' : document.getElementById('page').style.display = '';
                                            break;
                      default : break;
                  }
                  
              }
              
function checkTHR(mythr) {
    var thr = document.getElementById(mythr).value;
    var thr_regexp = /^\d+\.?(\d+)?$/;
    if(!thr_regexp.test(thr)){
       document.getElementById('p_offer').innerHTML = "Inserisci un numero, se decimale, usa la virgola";
    } else {
       document.getElementById('p_offer').innerHTML = "";
       document.getElementById('thr_form').submit();
    

    }
}

function over (element_id) {
    
    switch (element_id){
        case "signup_email" :  document.getElementById(element_id).placeholder = "La tua Email"; break;
        case "signup_psw" :    document.getElementById(element_id).placeholder = "Scegli una password"; break;
        case "psw_repeat" :    document.getElementById(element_id).placeholder = "Ripeti la password"; break;
        case "signin_email" :  document.getElementById(element_id).placeholder = "La tua Email"; break;
        case "signin_psw" :    document.getElementById(element_id).placeholder = "La tua Password"; break;

    }
       
    
}

function out(element_id) {
    
    switch (element_id){
        case "signup_email" :  document.getElementById(element_id).placeholder = ""; break;
        case "signup_psw" :    document.getElementById(element_id).placeholder = ""; break;
        case "signin_email" :  document.getElementById(element_id).placeholder = ""; break;
        case "signin_psw" :    document.getElementById(element_id).placeholder = ""; break;
        case "psw_repeat" :    document.getElementById(element_id).placeholder = ""; break;
        
    }
       
    
}

              