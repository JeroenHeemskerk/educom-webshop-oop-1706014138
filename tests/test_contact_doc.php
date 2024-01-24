<?php
    require_once("../views/ContactDoc.php");

    $title = $name = $message = $email = $phone = $preference = $street = $streetNo = $postcode = $city = '';
    $titleErr = $nameErr = $messageErr = $emailErr = $phoneErr = $preferenceErr = $streetErr = $streetNoErr = $postcodeErr = $cityErr = '';
    $valid = false;
    $data = array('valid'=>$valid, 'title'=>$title, 'name'=>$name, 'message'=>$message, 'email'=>$email, 'phone'=>$phone, 'preference'=>$preference,
                        'street'=>$street, 'streetNo'=>$streetNo, 'postcode'=>$postcode, 'city'=>$city,
                        'titleErr'=>$titleErr, 'nameErr'=>$nameErr, 'messageErr'=>$messageErr, 'emailErr'=>$emailErr, 'phoneErr'=>$phoneErr, 'preferenceErr'=>$preferenceErr,
                        'streetErr'=>$streetErr, 'streetNoErr'=>$streetNoErr, 'postcodeErr'=>$postcodeErr, 'cityErr'=>$cityErr,
                        'page' => 'contact', 'header' => 'Contact Pagina');

    $view = new ContactDoc($data);
    $view->show();
?>