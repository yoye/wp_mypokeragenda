<?php

class MyPokerAgendaFormException extends Exception
{
    protected $errors = array();
    
    /**
     * Add error
     * 
     * @param string $key
     * @param string $value 
     */
    public function addError($key, $value)
    {
        $this->errors[$key] = $value;
    }
    
    /**
     * Set errors
     * 
     * @param array $errors 
     */
    public function setErrors(array $errors)
    {
        $this->errors = $errors;
    }
    
    /**
     * Get errors
     * 
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }
}