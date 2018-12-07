This is a Yii 1.1 invoice generateor. You send a json request with specific invoice details and it will return a generated PDF invoice.
Below is the json format to be sent to the invoice generator
```json
{
    "header":"",
    "invoiceNumberTitle":"",
    "toTitle":"",
    "dateTitle":"",
    "paymentTermsTitle":"",
    "dueDateTitle":"",
    "quantityHeader":"",
    "unitCostHeader":"",
     "unitAmountHeader":"",
     "amountTitle":"",
     "itemsHeader":"",
     "subtotalTitle":"",
     "discountTitle":"",
     "taxTitle":"",
     "logo":"",
     "items":[
         {"name":"","quantity":"","unitCost":"","description":""}
     ]
}
