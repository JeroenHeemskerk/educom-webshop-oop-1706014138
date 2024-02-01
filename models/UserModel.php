<?php

require_once('models/PageModel.php');

define('RESULT_UNKNOWN_USER', 0);
define('RESULT_INCORRECT_PASSWORD', 1);
define('RESULT_OK', 2);

class UserModel extends PageModel {
    //Values
    public $email = '';
    public $name = '';
    public $pass = '';
    public $passConfirm = '';

    public $title = '';
    public $message = '';
    public $phone = '';
    public $preference = '';

    public $street = '';
    public $streetNo = '';
    public $postcode = '';
    public $city = '';

    //Errors
    public $emailErr = '';
    public $nameErr = '';
    public $passErr = '';
    public $passConfirmErr = '';


    public $titleErr = '';
    public $messageErr = '';
    public $phoneErr = '';
    public $preferenceErr = '';

    public $streetErr = '';
    public $streetNoErr = '';
    public $postcodeErr = '';
    public $cityErr = '';

    //validation variables
    private $userId = 0;
    public $valid = false;

    //CRUD
    private $userCrud;

    public function __construct($pageModel, $crud) {
        PARENT::__construct($pageModel);
        $this->userCrud = $crud;
    }

    function validateContact() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            require_once('Util.php');

            //check title
            if (empty(Util::getPostVar("title", ''))) {
                $this->titleErr = "Kies een aanhef";
            } else {
                $this->title = $this->testInput(Util::getPostVar("title"));
            }
            
            //check name (only allow letters, spaces, dashes and apostrophes)
            $this->name = $this->testInput(Util::getPostVar("name"));
            $this->nameErr = $this->validateName($this->name);
            
            //check message
            if (empty(Util::getPostVar("message"))) {
                $this->messageErr = "Vul een bericht in";
            } else {
                $this->message = $this->testInput(Util::getPostVar("message"));
            }
            
            $addressRequired = $emailRequired = $phoneRequired = false;
            //check preference
            if (empty(Util::getPostVar("preference", ''))) {
                $this->preferenceErr = "Vul in hoe we met u contact op kunnen nemen";
            } else {
                $this->preference = testInput(getPostVar("preference"));
                if ($this->preference == "mail" || !empty(Util::getPostVar("street")) || !empty(Util::getPostVar("streetNo"))
                        || !empty(Util::getPostVar("postcode")) || !empty(Util::getPostVar("city")) )  {
                    $addressRequired = true;
                }
                if ($this->preference == "email" || !empty(Util::getPostVar("email"))) {
                    $emailRequired = true;
                }
                if ($this->preference == "phone" || !empty(Util::getPostVar("phone"))) {
                    $phoneRequired = true;
                }
            }

            $this->street = $this->testInput(Util::getPostVar("street"));
            $this->streetNo = $this->testInput(Util::getPostVar("streetNo"));
            $this->postcode = $this->testInput(Util::getPostVar("postcode"));
            $this->city = $this->testInput(Util::getPostVar("city"));
            
            if (empty($this->street) && $addressRequired) {
                $this->streetErr = "vul een straat in";
            }
            if (empty($this->streetNo) && $addressRequired) {
                $this->streetNoErr = "vul een straat nummer in";
            }
            if (empty($this->postcode)) {
                if ($addressRequired) {
                    $this->postcodeErr = "vul een postcode in";
                }
            } elseif (strlen($this->postcode) != 6 || !is_numeric(substr($this->postcode, 0, 4)) || !preg_match("/^[a-zA-Z]{2}$/",substr($this->postcode, 4, 2))) {
                $this->postcodeErr = "vul een geldige Nederlandse postcode in";
            }
            if (empty($this->city) && $addressRequired) {
                    $this->cityErr = "vul een woonplaats in";
            }
            
            //check email
            $this->email = $this->testInput(Util::getPostVar("email"));
            $this->emailErr = $this->validateEmail($this->email, $emailRequired);
            
            $this->phone = $this->testInput(Util::getPostVar("phone"));
            if ($phoneRequired) {
                if (empty($this->phone)) {
                    $this->phoneErr = "Vul uw telefoon nummer in";
                } elseif (!is_numeric($this->phone)) {
                    $this->phoneErr = "Ongeldig nummer";
                }
            }
            
            //update valid boolean after all error checking
            $this->valid = empty($this->titleErr) && empty($this->nameErr) && empty($this->messageErr) && empty($this->emailErr) && empty($this->phoneErr) && empty($this->preferenceErr)
                        && empty($this->streetErr) && empty($this->streetNoErr) && empty($this->postcodeErr) && empty($this->cityErr);
        }
    }

    public function validateLogin() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //check email
            $this->email = $this->testInput(Util::getPostVar("email"));
            $this->emailErr = $this->validateEmail($this->email);
            if (empty($emailErr)) {
                $this->pass = $this->testInput(Util::getPostVar("pass"));
                try {
                    $userData = $this->authorizeUser($this->email, $this->pass);
                    switch($userData['result']) {
                        case RESULT_UNKNOWN_USER:
                            $this->emailErr = "Dit email adres heeft geen account";
                            break;
                        case RESULT_INCORRECT_PASSWORD:
                            $this->passErr = "Ongeldig wachtwoord";
                            break;
                        case RESULT_OK:
                            $this->name = $userData['user']->name;
                            $this->userId = $userData['user']->id;
                            break;
                    }
                }
                catch (Exception $ex) {
                    $this->connectionErr = "Er is een technische storing opgetreden, inloggen is niet mogelijk. Probeer het later opnieuw.";

                    LogError("Authentication Failed: ".$ex->getMessage());
                }
                
            }
            
            //update valid boolean after all error checking
            $this->valid = empty($this->emailErr) && empty($this->passErr);
        }
    }

    public function validateRegistration() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //check name (only allow letters, spaces, dashes and apostrophes)
            $this->name = $this->testInput(Util::getPostVar("name"));
            $this->nameErr = $this->validateName($this->name);
            
            //check email
            $this->email = $this->testInput(Util::getPostVar("email"));
            $this->emailErr = $this->validateEmail($this->email);
            if ($this->doesEmailExist($this->email)) {
                $this->emailErr = "Dit email adres heeft al een account";
            }
            
            $this->pass = $this->testInput(Util::getPostVar("pass"));
            if (empty($this->pass)) {
                $this->passErr = "Vul een wachtwoord in";
            }
            $this->passConfirm = $this->testInput(Util::getPostVar('passConfirm'));
            if ($this->pass != $this->passConfirm) {
                $this->passConfirmErr = 'Wachtwoorden moeten gelijk zijn.';
            }
            
            
            
            //update valid boolean after all error checking
            $this->valid = empty($this->nameErr) && empty($this->emailErr) && empty($this->passErr) && empty($this->passConfirmErr);
        }
    }

    public function testInput($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    
    //function that checks name input and returns an error message
    public function validateName($name) {
        $nameErr = '';
        if (empty($name)) {
                $nameErr = "Vul uw naam in";
        } elseif (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
            $nameErr= "Alleen letters, streepjes en apostrophen zijn toegestaan	";
        }
        return $nameErr;
    }
    
    //function that checks email input and returns an error message
    public function validateEmail($email, $emailRequired=true) {
        $emailErr = '';
        if ($emailRequired) {
            if (empty($email)) {
                $emailErr = "Vul uw email in";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailErr = "ongeldig email";
            }
        }
        return $emailErr;
    }

    function doesEmailExist($email) {
        return !empty($this->userCrud->readUserByEmail($email));
    }

    public function authorizeUser($email, $pass) {
        $user = $this->userCrud->readUserByEmail($email);
        
        if ($user == NULL) {
            $userData['user'] = NULL;
            $userData['result'] = RESULT_UNKNOWN_USER;
            return $userData;
        }
        if (!password_verify($pass, $user->password)) {
            $userData['user'] = NULL;
            $userData['result'] = RESULT_INCORRECT_PASSWORD;
            return $userData;
        }
        $userData['user'] = $user;
        $userData['result'] = RESULT_OK;
        return $userData;
    }

    public function addUser($email, $name, $pass) {
        $encrypted_password = password_hash($pass, PASSWORD_BCRYPT, ['cost'=>14]);
        $this->userCrud->createUser($email, $name, $encrypted_password);
    }

    public function loginUser() {
        $this->sessionManager->loginUser($this->name, $this->userId);
    }

    public function logoutUser() {
        $this->sessionManager->logoutUser();
    }

    public function getUserId() {
        return $this->userId;
    }
}

?>