<?php
/* @var $order Order */
?>
<html>
    <head>
        <title><?php echo $order->template->header; ?></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style type="text/css">
            thead:before, thead:after { display: none; }
            tbody:before, tbody:after { display: none; }
            table{
                border-collapse: collapse;
            }
            .table{
                width: 100%;
                margin-bottom: 30px;
            }
            .table th{
                background: #ccc;
            }
            .table td{
                vertical-align: top;
            }
            .w50{
                width: 50%;
            }
            .mb{
                margin-bottom: 30px;
            }
            .table .details{
                margin-left: auto;
            }
            .table .details td {
                border: 1px solid #ddd;
                padding: 0 5px;
            }
            .table .details td.prop{
                text-align: left;
                padding-right: 30px;
            }
            .table .details td.value{
                text-align: right;
                padding-left: 30px;
            }
            .table.items th, .table.items td {
                text-align: left;
            }
            .table.items th.align-right{
                text-align: right;
            }
            .table.items{
                border:none;
                margin-bottom: 0;
            }
            .table.items tr:nth-child(even) {background-color: #f2f2f2};
            .header{
                text-align: center;
                color: #ccc;
                width: 100%;
            }
            .top{
                min-height: 150px;
            }
            .description{
                margin: 10px 0;
                padding: 0;
                font-size:11px;
            }
            .align-right{
                text-align: right;
            }
            table.summary td{
                text-align: right;
            }
            table.summary td.value{
                padding-left: 40px;
            }
            .float-right{
                float:right;
            }
            .clearfix{
                clear: both;
            }
            .logo{
                max-width: 100px;
            }
        </style>
    </head>
    <body>
        <div class="top" style="min-height: 150px">
            <table class="table">
                <tbody>
                    <tr>
                        <td style="width:80%">
                            <?php echo str_replace("\n", "<br/>", $order->from); ?>
                            <?php if ($order->paymentDetails): ?>
                                <p>
                                    <?php echo $order->paymentDetails; ?>
                                </p>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($order->template->logo): ?>
                                <img src="<?php echo $order->template->logo; ?>" class="logo"/>
                            <?php endif; ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <h2 style="text-align: center;color: #ccc;"><?php echo $order->template->header; ?></h2>
        <table class="table">
            <tbody>
                <tr>
                    <td class="w50">
                        <b><?php echo $order->template->toTitle; ?>:</b> <br/>
                        <?php echo str_replace("\n", "<br/>", $order->to); ?>
                    </td>
                    <td style="text-align: right">
                        <table class="details">
                            <tbody>
                                <tr>
                                    <td class="prop"><?php echo $order->template->invoiceNumberTitle; ?></td>
                                    <td class="value"><?php echo $order->number; ?></td>
                                </tr>
                                <tr>
                                    <td class="prop"><?php echo $order->template->dateTitle; ?></td>
                                    <td class="value"><?php echo $order->date; ?></td>
                                </tr>
                                <tr>
                                    <td class="prop"><?php echo $order->template->amountTitle; ?></td>
                                    <td class="value"><?php echo $order->currency  .' '.($order->subTotal + $order->taxAmount); ?></td>
                                </tr>
                                <?php if ($order->dueDate): ?>
                                    <tr>
                                        <td class="prop"><?php echo $order->template->dueDateTitle; ?></td>
                                        <td class="value"><?php echo $order->dueDate; ?></td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
        <p style="width:50%;">
            <?php echo $order->terms; ?>
        </p>
        <table class="table items">
            <thead>
                <tr>
                    <th><?php echo $order->template->itemsHeader; ?></th>
                    <th><?php echo $order->template->quantityHeader; ?></th>
                    <th><?php echo $order->template->unitCostHeader . ' (' . $order->currency . ')'; ?></th>
                    <th class="align-right"><?php echo $order->template->unitAmountHeader . ' (' . $order->currency . ')'; ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($order->items as $item): ?>
                    <tr>
                        <td>
                            <?php
                            echo $item->name;
                            if ($item->description) {
                                echo '<br/><p class="description">' . $item->description . '</p>';
                            }
                            ?>                          
                        </td>
                        <td><?php echo $item->quantity; ?></td>
                        <td><?php echo $item->unitCost; ?></td>
                        <td style="text-align: right"><?php echo $item->getTotalCost(); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="float-right">
            <table class="summary float-right">
                <tbody>
                    <tr>
                        <td><b><?php echo $order->template->subtotalTitle .':'; ?></b></td>
                        <td class="value"><b><?php echo $order->subTotal; ?></b></td>
                    </tr>
                    <tr>
                        <td>
                            <?php
                            echo $order->template->taxTitle;
                            if ($order->isPercentageTax()) {
                                echo ' - ' . $order->tax;
                            }
                            echo ':';
                            ?>
                        </td>
                        <td class="value"><?php echo $order->taxAmount; ?></td>
                    </tr>
                    <tr>
                        <td colspan="2"><hr style="border-top: 1px solid #ddd;width: 100%;"/></td>
                    </tr>
                    <tr>
                        <td>
                            <b>
                                <?php
                                echo $order->template->totalTitle .':';
                                ?>
                            </b>
                        </td>
                        <td class="value"><b><?php echo $order->currency.' '. ($order->subTotal + $order->taxAmount); ?></b></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <p style="margin-top: 200px;margin-left: 50%;text-align: right">
            <?php echo $order->signature; ?>
        </p>
    </body>
</html>