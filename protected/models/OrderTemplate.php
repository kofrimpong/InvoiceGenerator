<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of InvoiceTemplate
 *
 * @author User
 */
class OrderTemplate extends CFormModel{
    
    public $header = "Invoice";
    public $invoiceNumberTitle = "Invoice #";
    public $toTitle = "Bill To";
    public $dateTitle = "Date";
    public $paymentTermsTitle = "Payment Terms";
    public $dueDateTitle = "Due Date";
    public $quantityHeader = "Quantity";
    public $unitCostHeader = "Rate";
    public $unitAmountHeader = "Amount";
    public $amountTitle = "Amount Due";
    public $itemsHeader = "Item";
    public $subtotalTitle = "Subtotal";
    public $discountTitle = "Discounts";
    public $taxTitle = "Tax";
    public $totalTitle = "Total";
    public $logo;
    
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('header,invoiceNumberTitle,toTitle,dateTitle,paymentTermsTitle,dueDateTitle,quantityHeader,unitCostHeader,'
                . 'unitAmountHeader,amountTitle,itemsHeader,subtotalTitle,discountTitle,taxTitle,logo', 'safe')
        );
    }
}
