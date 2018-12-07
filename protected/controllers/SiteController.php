<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SiteController
 *
 * @author User
 */
class SiteController extends CController {

    public function actionIndex() {
        $data = file_get_contents('php://input');
        $jsonData = CJSON::decode($data, true);
        if (!isset($jsonData['items'])) {
            throw new CHttpException(500, "Items not set.");
        }
        $order = new Order();
        $order->setAttributes($jsonData);
        if ($order->validate()) {
            $order->calculateAmountDue();
            $order->sendPDF();
        }
        else {
            throw new CHttpException(500, CHtml::errorSummary($order));
        }
    }

}
