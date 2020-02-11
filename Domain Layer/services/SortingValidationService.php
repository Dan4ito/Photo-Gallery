<?php

class SortingValidationService
{
    private $allowed = ["ascending", "asc", "descending", "desc"];
   
    public function validateSortingType($type) {
        if(!in_array($type, $this->allowed)) {
            throw new Exception("You need to enter proper sorting way!", 400);
        }
    }
}

?>