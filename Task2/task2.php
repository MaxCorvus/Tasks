<?php

function sortDeliveryMethods () {

    $deliveryMethodsArray = [
        [
            'code' => 'dhl',
            'customer_costs' => [
                22 => '1.000',
                11 => '3.000',
            ]
        ],
        [
            'code' => 'fedex',
            'customer_costs' => [
                22 => '4.000',
                11 => '6.000',
            ]
        ]
    ];
    $sortArray = [];

    foreach ($deliveryMethodsArray as $key1 => $value) {
        foreach ($value['customer_costs'] as $key2=>$value2) {
            if (!isset($sortArray[$key2])) {
                $sortArray[$key2] = [];
            }

            $sortArray[$key2][$value['code']] = $value2;
        }

    }
    return $sortArray;

}
echo "<pre>";
var_dump(sortDeliveryMethods());
