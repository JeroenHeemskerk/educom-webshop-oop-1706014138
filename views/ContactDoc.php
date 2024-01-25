<?php

require_once('FormDoc.php');

define("TITLES", array("mr."=>"Dhr.", "mrs."=>"Mvr.", "dr." => "Dr.", "prof." => "Prof."));
define("COMM_PREFS", array("email" => "E-Mail", "phone" => "Telefoon", "mail" => "Post"));

class ContactDoc extends FormDoc {
    protected function showHeader() {
        echo '    <h1>Contact Pagina</h1>' . PHP_EOL;
    }

    protected function showContent() {
        if ($this->data['valid']) {
            $this->displayThanks($this->data);
        } else {
            $this->displayContactForm($this->data);
        }
    }

    private function displayContactForm($data) {
        $this->showFormStart('contact');
        
        //selection for title
        $this->showFormField('title', 'Kies uw aanhef:', 'select', $data, TITLES);
        
        //input for name
        $this->showFormField('name', 'Naam:', 'text', $data);
        //input for email
        $this->showFormField('email', 'Email:', 'email', $data);
        //input for phone
        $this->showFormField('phone', 'Tel. nr.:', 'text', $data);

        echo '    <h4>Adres</h4>' . PHP_EOL;
        
        //input for address fields (street, number, postal code, city)
        $this->showFormField('street', 'Straat:', 'text', $data);
        $this->showFormField('streetNo', 'Nr. + Toevoeging:', 'text', $data);
        $this->showFormField('postcode', 'Postcode:', 'text', $data);
        $this->showFormField('city', 'Woonplaats:', 'text', $data);
        
        echo '        <br>' . PHP_EOL;
        
        //input for communication preference
        $this->showFormField('preference', 'Communicatie Voorkeur', 'radio', $data, COMM_PREFS);
        
        echo '        <br>' . PHP_EOL;
        
        //textbox for message
        $this->showFormField('message', 'Bericht', 'textarea', $data, ['rows' => 10, 'cols' => 30], 'Vul in waar u contact over wil opnemen.');
        
        $this->showFormEnd('Verzenden');
    }
    
    private function displayThanks($data) {
        echo '<p>Bedankt voor uw reactie<p>
        <div>Naam: ' . $data['title'] . ' ' . $data['name'] . ' </div>
        <div>Email: ' . $data['email'] . ' </div>
        <div>Tel. nr.: ' . $data['phone'] . ' </div>
        <div>Adres: ' . $data['street'] . ', ' . $data['streetNo'] . ', ' . $data['postcode'] . ', ' . $data['city'] . ' </div><br>';
    }
}

?>