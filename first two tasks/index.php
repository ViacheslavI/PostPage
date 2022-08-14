<?php
function myArrowFunc($value)
{
    $dataRightArrow = '';
    $dataLeftArrow = '';
    for ($i = 0; $i < $value; $i++) {
        $dataLeftArrow .= "<";
        $dataRightArrow .= ">";
    }
    return "$dataLeftArrow $dataRightArrow";
}

$deliveryMethodsArray = [
    [
        'code' => 'dhl',
        'customer_costs' => [
            22 => '4.000',
            11 => '9.000',
        ]
    ],
    [
        'code' => 'fedex',
        'customer_costs' => [
            22 => '2.000',
            11 => '6.000',
        ]
    ]
];
function sortDeliveryMethodsdelivery($MethodsArray)
{

    foreach ($MethodsArray as $item) {
        if (array_key_exists(22, $item['customer_costs']) && in_array('dhl', $item)) {
            $ar[22]['dhl'] = $item['customer_costs'][22];
        } else {
            $ar[22]['fedex'] = $item['customer_costs'][22];
        }
        if (array_key_exists(11, $item['customer_costs']) && in_array('dhl', $item)) {
            $ar[11]['dhl'] = $item['customer_costs'][11];
        } else {
            $ar[11]['fedex'] = $item['customer_costs'][11];
        }
        arsort($ar[22]);
        arsort($ar[11]);
    }
    var_dump($ar);
}

sortDeliveryMethodsdelivery($deliveryMethodsArray);

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<?= myArrowFunc(3) ?>
<br>
<?= myArrowFunc(9) ?>
</body>
</html>
