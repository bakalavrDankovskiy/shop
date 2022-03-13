<?php

namespace App\Controllers;

use App\Models\Order;

class OrderController
{
    private Order $orderModel;

    public function __construct()
    {
        $this->orderModel = new Order();
    }

    public function get()
    {
        return json_encode($this->orderModel->get());
    }

    public function save()
    {
        if (trim($_SERVER["CONTENT_TYPE"] ?? '') !== "application/json") {
            die(json_encode([
                'value' => 0,
                'error' => 'Content-Type is not set as "application/json"',
                'data' => null,
            ]));
        }

        $decoded = json_decode(trim(file_get_contents("php://input")), true);

        if (!is_array($decoded))
            die(json_encode([
                'value' => 0,
                'error' => 'Received JSON is improperly formatted',
                'data' => null,
            ]));

        /*
         * Validation block
         */
        $patterns = [
            'id' => '/^\d{1,10}$/',
            'price' => '/^\d{1,4}$/',
            'paymentMethod' => '/^((н|Н)аличные|(к|К)арта)$/',
            'client' => [
                'name' => '/^(?=.{1,50}$)([А-Яа-яЁёa-zA-Z]+[- ]?)+$/ui',
                'surname' => '/^(?=.{1,50}$)([А-Яа-яЁёa-zA-Z]+[- ]?)+$/ui',
                'thirdName' => '/^(?=.{1,50}$)([А-Яа-яЁёa-zA-Z]+[- ]?)+$/ui',
                'phone' => '/^(\+?7|8)\d{10}$/',
                'email' => '/^\w+@\w+\.[a-zA-Z]+$/'
            ],
            'address' => [
                'city' => '/^(?=.{1,50}$)([А-Яа-яЁёa-zA-Z]+[- ]?)+$/ui',
                'street' => '/^(?=.{1,50}$)([А-Яа-яЁёa-zA-Z]+[- ]?)+$/ui',
                'home' => '/^\d{1,4}$/',
                'aprt' => '/^\d{1,4}$/',
            ],
            'gaps' => '/ +/',
        ];

        //Common validation
        if (!array_key_exists('id', $decoded) && !preg_match($patterns['id'], $decoded['id'])) {
            die(json_encode([
                'value' => 0,
                'error' => "Error: No product id passed or id field is incorrect",
                'data' => null,
            ]));
        }
        $decoded['id'] = trim($decoded['id']);

        if (!array_key_exists('price', $decoded) && !preg_match($patterns['price'], $decoded['price'])) {
            die(json_encode([
                'value' => 0,
                'error' => "Error: No price param passed or price field is incorrect",
                'data' => null,
            ]));
        }
        $decoded['price'] = trim($decoded['price']);

        if (!array_key_exists('deliveryInfo', $decoded)) {
            die(json_encode([
                'value' => 0,
                'error' => "Error: No deliveryInfo obj passed or deliveryInfo obj is incorrect",
                'data' => null,
            ]));
        }
        $deliveryInfo = $decoded['deliveryInfo'];

        /*
         * Client info validation
         */
        if (array_key_exists('client', $deliveryInfo)) {
            $clientDetails = array_map('trim', $deliveryInfo['client']);

            foreach ($clientDetails as $key => $value) {
                $value = preg_replace('/ +/', ' ', $value);

                if (!preg_match($patterns['client'][$key], $value)) {
                    die(json_encode([
                        'pattern' => preg_match_all($patterns['client'][$key], $value),
                        'value' => 0,
                        'error' => "Client info error: FORMAT INVALID for '$key'",
                        'data' => null,
                    ]));
                }
                if ($key == 'email') {
                    $clientDetails[$key] = strtolower($value);
                } else {
                    $clientDetails[$key] = ucfirst(strtolower($value));
                }
            }
            $decoded['deliveryInfo']['client'] = $clientDetails;
        }

        /*
         * Delivery address info validation
         */
        if (!array_key_exists('paymentMethod', $deliveryInfo) || !preg_match($patterns['paymentMethod'], $deliveryInfo['paymentMethod'])) {
            die(json_encode([
                'value' => 0,
                'error' => "Error: No paymentMethod param passed or paymentMethod field is incorrect",
                'data' => null,
            ]));
        }

        if (array_key_exists('needDelivery', $deliveryInfo) || !is_bool($deliveryInfo['needDelivery'])) {
            if ($deliveryInfo['needDelivery']) {

                $decoded['price'] += $decoded['price'] < 2000 ? DELIVERY_PRICE : 0;

                if (array_key_exists('address', $deliveryInfo)) {
                    $addressDetails = array_map('trim', $deliveryInfo['address']);
                    foreach ($addressDetails as $key => $value) {
                        $value = preg_replace('/ +/', ' ', $value);

                        if (!preg_match($patterns['address'][$key], $value)) {
                            die(json_encode([
                                'value' => 0,
                                'error' => "Address info error: FORMAT INVALID for '$key'",
                                'data' => null,
                            ]));
                        }
                        if ($key == 'city' || $key == 'street') {
                            $addressDetails[$key] = ucfirst(strtolower($value));
                        }
                    }
                    $decoded['deliveryInfo']['address'] = $addressDetails;
                } else {
                    die(json_encode([
                        'value' => 0,
                        'error' => "Address info error: no delivery address passed",
                        'data' => null,
                    ]));
                }
            } else {
                $decoded['deliveryInfo']['address'] = PICKUP_POINT;
            }
        } else {
            die(json_encode([
                'value' => 0,
                'error' => "Error: No needDelivery param passed or needDelivery field value is incorrect",
                'data' => null,
            ]));
        }

        try {
            $this->orderModel->insert($decoded);
        } catch (\PDOException $e) {
            die(json_encode([
                'value' => 0,
                'error' => $e->getMessage(),
                'data' => null,
            ]));
        }

        /* Send success to fetch API */
        return json_encode([
            'value' => 1,
            'error' => null,
            'data' => $decoded,
        ]);
    }

    public function changeStatus(): string
    {
        $content = trim(file_get_contents("php://input"));
        $decoded = json_decode($content, true);

        return json_encode($this->orderModel->changeStatus($decoded['id'], $decoded['status']));
    }

}