<?php

require_once('FormDoc.php');

define("TITLES", array("mr."=>"Dhr.", "mrs."=>"Mvr.", "dr." => "Dr.", "prof." => "Prof."));
define("COMM_PREFS", array("email" => "E-Mail", "phone" => "Telefoon", "mail" => "Post"));

class ContactDoc extends FormDoc {
    protected function showHeader() {
        echo '    <h1>Contact Pagina</h1>' . PHP_EOL;
    }

    protected function showContent() {
        if ($this->model->valid) {
            $this->displayThanks();
        } else {
            $this->displayContactForm();
        }
    }

    private function displayContactForm() {
        $this->showFormStart('contact');
        
        //selection for title
        $this->showFormField('title', 'Kies uw aanhef:', 'select', $this->model, TITLES);
        
        //input for name
        $this->showFormField('name', 'Naam:', 'text', $this->model);
        //input for email
        $this->showFormField('email', 'Email:', 'email', $this->model);
        //input for phone
        $this->showFormField('phone', 'Tel. nr.:', 'text', $this->model);

        echo '    <h4>Adres</h4>' . PHP_EOL;
        
        //input for address fields (street, number, postal code, city)
        $this->showFormField('street', 'Straat:', 'text', $this->model);
        $this->showFormField('streetNo', 'Nr. + Toevoeging:', 'text', $this->model);
        $this->showFormField('postcode', 'Postcode:', 'text', $this->model);
        $this->showFormField('city', 'Woonplaats:', 'text', $this->model);
        
        echo '        <br>' . PHP_EOL;

        //input for communication preference
        $this->showFormField('preference', 'Communicatie Voorkeur', 'radio', $this->model, COMM_PREFS);
        
        echo '        <br>' . PHP_EOL;
        
        //textbox for message
        $this->showFormField('message', 'Bericht', 'textarea', $this->model, ['rows' => 10, 'cols' => 30], 'Vul in waar u contact over wil opnemen.');
        
        $this->showFormEnd('Verzenden');
    }
    
    private function displayThanks() {
        echo '<p>Bedankt voor uw reactie<p>
        <div>Naam: ' . $this->model->title . ' ' . $this->model->name . ' </div>
        <div>Email: ' . $this->model->email . ' </div>
        <div>Tel. nr.: ' . $this->model->phone . ' </div>
        <div>Adres: ' . $this->model->street . ' ' . $this->model->streetNo . ', ' . $this->model->postcode . ', ' . $this->model->city . ' </div><br>';
    }
}

?>