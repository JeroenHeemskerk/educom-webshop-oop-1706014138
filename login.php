<?php
    function loginHeader() {
        $header = 'Login Pagina';
        return $header;
    }
    
    function showLoginContent($data) {
        if (!empty($data['connectionErr'])) {
            echo "<p>".$data['connectionErr']."</p>".PHP_EOL;
        } else {
            displayLoginForm($data);
        }
    }
    
    function displayLoginForm($data) {
        
        echo '<h4>Vul uw gegevens in om te registreren</h4>' . PHP_EOL;
        
        showFormStart('login');
        
        //input for email
        showFormField('email', 'Email:', 'email', $data);
        
        //input for password
        showFormField('pass', 'Wachtwoord:', 'password', $data);

        echo '        <br><br>' . PHP_EOL;

        showFormEnd('Login');
    }

    function validateLogin() {
        $email = $pass = $name = $userId = '';
        $emailErr = $passErr = $connectionErr = '';
        $valid = false;

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //check email
            $email = testInput(getPostVar("email"));
            $emailErr = validateEmail($email);
            if (empty($emailErr)) {
                $pass = testInput(getPostVar("pass"));
                try {
                    $userData = authorizeUser($email, $pass);
                    switch($userData['result']) {
                        case RESULT_UNKNOWN_USER:
                            $emailErr = "Dit email adres heeft geen account";
                            break;
                        case RESULT_INCORRECT_PASSWORD:
                            $passErr = "Ongeldig wachtwoord";
                            break;
                        case RESULT_OK:
                            $name = $userData['user']['name'];
                            $userId = $userData['user']['id'];
                            break;
                    }
                }
                catch (Exception $ex) {
                    $connectionErr = "Er is een technische storing opgetreden, inloggen is niet mogelijk. Probeer het later opnieuw.";

                    LogError("Authentication Failed: ".$ex->getMessage());
                }
                
            }
            
            
            
            //update valid boolean after all error checking
            $valid = empty($nameErr) && empty($emailErr) && empty($passErr) && empty($passConfirmErr);
        }
        $data = array('valid'=>$valid, 'email'=>$email, 'pass'=>$pass, 'name'=>$name, 'userId'=>$userId,
                             'emailErr'=>$emailErr, 'passErr'=>$passErr, 'connectionErr'=>$connectionErr);
        return $data;
    }
?>