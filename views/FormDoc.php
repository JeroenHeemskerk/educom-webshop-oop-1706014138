<?php

require_once('BasicDoc.php');

abstract class FormDoc extends BasicDoc {
    protected function showFormStart($value) {
        echo '    <form method="post" action="index.php" accept-charset=utf-8>';
        $this->showHiddenField('page', $value);
    }

    protected function showHiddenField($name, $value) {
        echo '    <input type="hidden" name="'.$name.'" value='.$value.'>'.PHP_EOL;
    }

    //function to display a text input as well as its label and error message
    protected function showFormField($id, $label, $type, $data, $options=NULL, $placeholder=NULL) {
        switch ($type) {
            case 'text':
            case 'password':
            case 'email':
                $this->inputField($id, $label, $type, $data);
                break;
            case 'radio':
                $this->radioField($id, $label, $type, $data, $options);
                break;
            case 'select':
                $this->selectField($id, $label, $type, $data, $options);
                break;
            case 'textarea':
                $this->textAreaField($id, $label, $type, $data, $options, $placeholder);
                break;
            default:
                //error
                break;
        }
    }
    
    private function inputField($id, $label, $type, $data) {
        echo '        <div class="inputfield">
            <label for="' . $id . '">' . $label . '</label>
            <input type="' . $type . '" value="' . $data[$id] . '" id="' . $id . '" name="' . $id . '">
            <span class="error">' . $data[$id.'Err'] . '</span><br>
        </div>' . PHP_EOL;
    }
    
    private function selectField($id, $label, $type, $data, $options) {
        echo '        <div class="'. $id .'">
            <label for="'. $id .'">'.$label.'</label>
            <select name="'. $id .'" id="'. $id .'">' . PHP_EOL;

        echo '            <option value="" disabled ' . ($data[$id] == '' ? 'selected="true"' : '');
        echo '>Selecteer een optie</option>' . PHP_EOL;
        
        foreach ($options as $option => $optionLabel) {
            echo '<option value="'.$optionLabel.'" ' . ($data[$id] == $optionLabel ? 'selected="true"' : '');
            echo '>'.$optionLabel.'</option>';
        }

        echo '        </select>
            <span class="error">' . $data[$id.'Err'] . '</span>
        </div><br>' . PHP_EOL;
    }
    
    private function radioField($id, $label, $type, $data, $options) {
        echo '        <label for="'.$id.'">'.$label.'</label>
        <span class="error">' . $data[$id.'Err'] . '</span><br>'.PHP_EOL;
        
        foreach($options as $option => $optionLabel) {
            echo '<input type="radio" id="'.$option.'Option'.'" name="'.$id.'" value="'.$option.'" ' . ($data[$id] == $option ? "checked" : ''); 
            echo '>
        <label for="'.$option.'Option'.'">'.$optionLabel.'</label><br>'.PHP_EOL;
        }
    }
    
    private function textAreaField($id, $label, $type, $data, $options, $placeholder) {
        echo '        <label for="'.$id.'">'.$label.'</label> <span class="error">' . $data[$id.'Err'] . '</span><br>
        <textarea name="'.$id.'" placeholder="'.$placeholder.'"';
        foreach($options as $key => $value){
            echo ' '.$key.'="'.$value.'"';
        }
        echo '>' . $data[$id] . '</textarea><br>
        <br>';
    }
    
    protected function showFormEnd($value) {
        echo '<input class="form_submit" type="submit" value="'.$value.'">
    </form>' . PHP_EOL;
    }
}

?>
