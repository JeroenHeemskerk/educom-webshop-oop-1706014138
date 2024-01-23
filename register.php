<?php
    function registerHeader() {
        $header = 'Registratie Pagina';
        return $header;
    }

    function showRegisterContent($data) {
        if (isset($data['connectionErr'])) {
            echo "<p>".$data['connectionErr']."</p>".PHP_EOL;
        } else {
            displayRegistrationForm($data);
        }
    }

    function displayRegistrationForm($data) {
        
        echo '<h4>Vul uw gegevens in om te registreren</h4>' . PHP_EOL;
        
        showFormStart('register');
        
        //input for name
        showFormField('name', 'Naam:', 'text', $data);
        //input for email
        showFormField('email', 'Email:', 'email', $data);
        
        //input for password
        showFormField('pass', 'Wachtwoord:', 'password', $data);
        showFormField('passConfirm', 'Wachtwoord Herhalen:', 'password', $data);

        echo '        <br><br>' . PHP_EOL;

        showFormEnd('Registreer');
    }


    function validateRegistration() {
        $name = $email = $pass = $passConfirm = '';
        $nameErr = $emailErr = $passErr = $passConfirmErr = '';
        $valid = false;

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //check name (only allow letters, spaces, dashes and apostrophes)
            $name = testInput(getPostVar("name"));
            $nameErr = validateName($name);
            
            //check email
            $email = testInput(getPostVar("email"));
            $emailErr = validateEmail($email);
            if (doesEmailExist($email)) {
                $emailErr = "Dit email adres heeft al een account";
            }
            
            $pass = testInput(getPostVar("pass"));
            if (empty($pass)) {
                $passErr = "Vul een wachtwoord in";
            }
            $passConfirm = testInput(getPostVar('passConfirm'));
            if ($pass != $passConfirm) {
                $passConfirmErr = 'Wachtwoorden moeten gelijk zijn.';
            }
            
            
            
            //update valid boolean after all error checking
            $valid = empty($nameErr) && empty($emailErr) && empty($passErr) && empty($passConfirmErr);
        }
        $data = array('valid'=>$valid, 'name'=>$name, 'email'=>$email, 'pass'=>$pass, 'passConfirm'=>$passConfirm,
                             'nameErr'=>$nameErr, 'emailErr'=>$emailErr, 'passErr'=>$passErr, 'passConfirmErr'=>$passConfirmErr);
        return $data;
    }
?>