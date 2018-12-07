<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Item
 *
 * @author User
 */
class Item extends CFormModel{
    
    public $name;
    public $quantity;
    public $unitCost;
    public $description;
    
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name,quantity,unitCost,description', 'required')
        );
    }
    
    public function getTotalCost() {
        return (float)$this->quantity * (float)$this->unitCost;
    }
}
