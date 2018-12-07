<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Invoice
 *
 * @author User
 */
Yii::import('application.vendors.dompdf.src.*');
Yii::import('application.vendors.dompdf.lib.*');

// reference the Dompdf namespace
use Dompdf\Dompdf;
use Dompdf\Options;

class Order extends CFormModel {

    public $from;
    public $to;
    public $number;
    public $date;
    public $dueDate;
    public $paymentTerms;
    public $discounts;
    public $tax;
    public $amountPaid;
    public $signature;
    public $currency = 'USD';
    public $paymentDetails;
    public $terms;

    /**
     *
     * @var Item[] 
     */
    public $items = [];

    /**
     *
     * @var OrderTemplate 
     */
    public $template;
    public $subTotal = 0;
    public $taxAmount = 0;

    public function __construct($scenario = '') {
        parent::__construct($scenario);
        $this->template = new OrderTemplate();
    }

    public function setAttributes($values, $safeOnly = true) {
        parent::setAttributes($values, $safeOnly);
        if (isset($values['items'])) {
            $items = $values['items'];
            foreach ($items as $props) {
                $item = new Item();
                $item->setAttributes($props, $safeOnly);
                $this->items[] = $item;
            }
        }
        if (isset($values['template'])) {
            $this->template->setAttributes($values['template']);
        }
    }

    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('from,to,number,date,dueDate,paymentTerms,discounts,tax,amountPaid,signature,currency,paymentDetails', 'safe'),
            array('date', 'default', 'value' => Date::format(time(), Date::PATTERN_ENGLISH_SHORT))
        );
    }

    public function validate($attributes = null, $clearErrors = true) {
        if (parent::validate($attributes, $clearErrors)) {
            if (!$this->template->validate()) {
                $this->addErrors($this->template->errors);
            }
            foreach ($this->items as $item) {
                if (!$item->validate()) {
                    $this->addErrors($item->errors);
                }
            }
        }
        return count($this->errors) == 0;
    }

    public function calculateAmountDue() {
        foreach ($this->items as $item) {
            $this->subTotal += $item->getTotalCost();
        }
        if (strpos('%', $this->tax)) {
            $tax = substr($this->tax, 0, strlen($this->tax) - 1);
            $this->taxAmount = ((float) $tax * $this->subTotal) / 100;
        }
        else {
            if ($this->tax) {
                $this->taxAmount = $this->tax;
            }
            else {
                $this->taxAmount = '-';
            }
        }
    }

    public function isPercentageTax() {
        return strpos('%', $this->tax) != false;
    }

    public function sendPDF() {
        require_once(Yii::getPathOfAlias('application') . '/vendors/dompdf/autoload.inc.php');
        $html = Yii::app()->controller->renderPartial('invoice', ['order' => $this], true);
        // instantiate and use the dompdf class
        $options = new Options();
        $options->setIsRemoteEnabled(true);
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        // (Optional) Setup the paper size and orientation
//        $dompdf->setPaper('A4', 'landscape');
        // Render the HTML as PDF
        $dompdf->render();
        // Output the generated PDF to Browser
        $dompdf->stream('document.pdf', ['Attachment' => 1]);
    }

}
