<?php

require_once('FormDoc.php');

class RegisterDoc extends FormDoc {
    protected function showHeader() {
        echo '    <h1>Registratie Pagina</h1>' . PHP_EOL;
    }

    protected function showContent() {
        if (isset($this->data['connectionErr'])) {
            echo "<p>".$this->data['connectionErr']."</p>".PHP_EOL;
        } else {
            $this->displayRegistrationForm($this->data);
        }
    }

    private function displayRegistrationForm($data) {
        
        echo '<h4>Vul uw gegevens in om te registreren</h4>' . PHP_EOL;
        
        $this->showFormStart('register');
        
        //input for name
        $this->showFormField('name', 'Naam:', 'text', $data);
        //input for email
        $this->showFormField('email', 'Email:', 'email', $data);
        
        //input for password
        $this->showFormField('pass', 'Wachtwoord:', 'password', $data);
        $this->showFormField('passConfirm', 'Wachtwoord Herhalen:', 'password', $data);

        echo '        <br><br>' . PHP_EOL;

        $this->showFormEnd('Registreer');
    }
}

?>