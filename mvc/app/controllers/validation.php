<?php
require_once("controller.php");

class Validation extends Controller {
    public $userName='';
    public $password='';
    public $password2 ='';
    public $email='';
    public $check=false;

    public function __construct($userName , $password , $password2 , $email , $check)
    {
        $this-> userName = $userName;
        $this-> password = $password ;
        $this-> password2 = $password2 ;
        $this-> email = $email ;
        $this-> check = $check ;

      //  echo $this-> userName." " . $this-> password . " " . $this-> email ."<br>" ;
    }

    function checkNull(){
        if($this-> userName!=""&& $this-> password!="" && $this-> email!="")
        {
            return true ;
        }
        else {
            return false;
        }
    }

    function checkEmail(){
        $format = explode("@" , $this-> email );
        $emailsExt = array("gmail.com" , "hotmail.com" , "yahoo.com" , "outlook.com") ;
        $expression = array( "$", "+" , "&" , "#" , "/" , "%" , "?" , "=" , "~" , "|" , "!" , ":" , ";" , "]" , "*" , "[" , "," , ")" , "(" , "^");

        /* 
          * Check the extension of email after @ sign
        */

        if (in_array($format[1] , $emailsExt))
        {
            /* 
                 * Check the first letter of email
            */
            if ($format[0][0] >= "a" && $format[0][0] <= "z")
             {
                 $counter = 0 ;
                
                 /*  start loop to check all the letters of email that they are correct */
                for ($i = 0 ; $i < strlen($format[0]) ; $i++) {
                    if (in_array($format[0][$i] , $expression))
                   { 
                   // echo "error email !! " ;
                       return false ;
                   } 
                    else
                    $counter++;
                } // end loop


                /* 
                     * check that the email length is greater than 4
                 */
                if ($counter == strlen($format[0]) && $counter > 4)
                return true;

                else
               { 
               // echo "error email length !! ";
                   return false;
                } 
                
             }// endif of first letter
            else {
              return false ;
            }
        } // endif of email extension

        else {
          //  echo "error email extension !! ";
            return false;
        }

    }

    function checkPass(){
        if(strcmp ($this-> password , $this-> password2) == 0) 
        return true;

        else
        return false;
    }

    function checkLength(){
        if (strlen($this-> password) > 4 && strlen($this-> password) < 8)
        return true ;

        else 
        return false;
    }

    function checkRequired(){
        if($this-> check == true)
        return true;

        else
        return false;
    }
}

?>