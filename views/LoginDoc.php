<?php

require_once('FormDoc.php');

class LoginDoc extends FormDoc {
    protected function showHeader() {
        echo '    <h1>Login Pagina</h1>' . PHP_EOL;
    }

    protected function showContent() {
        if (!empty($this->data['connectionErr'])) {
            echo "<p>".$this->data['connectionErr']."</p>".PHP_EOL;
        } else {
            $this->displayLoginForm($this->data);
        }
    }

    private function displayLoginForm($data) {
        
        echo '<h4>Vul uw gegevens in om te registreren</h4>' . PHP_EOL;
        
        $this->showFormStart('login');
        
        //input for email
        $this->showFormField('email', 'Email:', 'email', $data);
        
        //input for password
        $this->showFormField('pass', 'Wachtwoord:', 'password', $data);

        echo '        <br><br>' . PHP_EOL;

        $this->showFormEnd('Login');
    }
}

?>