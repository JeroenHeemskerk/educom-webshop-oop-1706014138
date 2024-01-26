<?php

require_once('FormDoc.php');

class RegisterDoc extends FormDoc {
    protected function showHeader() {
        echo '    <h1>Registratie Pagina</h1>' . PHP_EOL;
    }

    protected function showContent() {
        if (isset($this->model->connectionErr)) {
            echo "<p>".$this->model->connectionErr."</p>".PHP_EOL;
        } else {
            $this->displayRegistrationForm();
        }
    }

    private function displayRegistrationForm() {
        
        echo '<h4>Vul uw gegevens in om te registreren</h4>' . PHP_EOL;
        
        $this->showFormStart('register');
        
        //input for name
        $this->showFormField('name', 'Naam:', 'text', $this->model);
        //input for email
        $this->showFormField('email', 'Email:', 'email', $this->model);
        
        //input for password
        $this->showFormField('pass', 'Wachtwoord:', 'password', $this->model);
        $this->showFormField('passConfirm', 'Wachtwoord Herhalen:', 'password', $this->model);

        echo '        <br><br>' . PHP_EOL;

        $this->showFormEnd('Registreer');
    }
}

?>