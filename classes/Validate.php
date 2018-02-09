<?php

class Validate {

    private $_passed = false;
    private $_errors = array();
    private $_db = null;
    
    public function __construct() {
        $this->_db = DB::getInstance();
         
         
         
    }

    public function check($source, $items = array()) {
        $creator = Session::get('TeacherUsername');
        foreach($items as $item => $rules) {
             
            foreach($rules as $rule => $rule_value) {
                $value = $source[$item];
                $item = escape($item);
                
                
                //var_dump($value);

                if($rule === 'required' && empty($value)) {
                    $this->addError("{$item} is required");
                } else if (!empty($value)) {
                    switch($rule) {
                        case 'min':
                            if(strlen($value) < $rule_value) {
                                $this->addError("{$item} must be a minimum of {$rule_value} characters.");
                            }
                            break;
                        case 'max':
                            if(strlen($value) > $rule_value) {
                                $this->addError("{$item} must be a maximum of {$rule_value} characters.");
                            }
                            break;
                        case 'matches':
                            if($value != $source[$rule_value]) {
                                $this->addError("{$rule_value} must match {$item}.");
                            }
                            break;
                         case 'currentPasswordMatches':
                            if($value == $source[$rule_value]) {
                                $this->addError("Current password must not match with new password.");
                            }    
                            break;
                        case 'passwordmatches':
                            if($value != $source[$rule_value]) {
                                $this->addError("password did not match.");
                              
                            }    
                            break;
                        case 'unique':
                            $check = $this->_db->get($rule_value, array($item, '=', $value));
                            if($check->count()) {
                                $this->addError("{$item} already exists.");
                                //var_dump($check);
                            }
                            break;
                        case 'uniqueQuizCode':
                            $check = $this->_db->get($rule_value, array($item, '=', $value));
                            if($check->count()) {
                                
                                $this->addError("QuizCode already exists.");
                                //var_dump($check);
                            }
                            break;  
                        case 'username':
                            
                            if (!preg_match('/^[A-Za-z][A-Za-z0-9]*(?:_[A-Za-z0-9]+)*$/', $value)) {
                                
                                $this->addError("Re-enter your userame! Format incorrect! (only underscore, numbers, letters are allowed");
                                
                            }
                            break; 
                        case 'name1':
                            
                            if (!preg_match('/^[a-zA-Z ]*$/', $value)) {
                                
                                $this->addError("Re-enter your name! Format incorrect! , Only alphabets and white space allowed");
                                
                            }
                            break;         
                        case 'category':
                            $check = $this->_db->query("SELECT * FROM $rule_value Where `subject` = '{$source['subject']}' and `quizNo` = {$source['quizNo']} and `creator`='$creator'");
                            
                            if($check->count()) {
                                $this->addError("quiz number already exists.");
                            }
                            break;    
                    }
                }
            }
        }
        if(empty($this->_errors)) {
            $this->_passed = true;
        }
    }
    private function addError($error) {
        $this->_errors[] = $error;
    }
    public function errors() {
        return $this->_errors;
    }
    public function passed() {
        return $this->_passed;
    }
}