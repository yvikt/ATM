<?php

// Load composer
require_once __DIR__ . '/vendor/autoload.php';

use Api\BankApi;
use Lib\Atm;

// There is only one client in this test task, because we don't have any real databases
$client_id = 1234567890;
$client_pin = 1234;
$client_balance = 5000 * 100; // 5000 Euro
$client_overdraft = -1000 * 100; // available extra 1000 Euro

BankApi::Initialize($client_id, $client_pin, $client_balance, $client_overdraft);

$atm = new Atm();

$atm->insert_card_id(1234567890)->get_pin(1234);

if($atm->validate()) {
    // simulation of simple ATM interface
    echo 'Please choose operation' . PHP_EOL;
    foreach ($atm->get_operations() as $operation) {
        echo $operation . PHP_EOL;
    }

    // try to get some money
    if($atm->get_money(300)){
        echo 'Operation successful.';
    }
    else echo 'Error';


    // End of working
    echo $atm->print_receipt() . PHP_EOL . 'Please don\'t forget your credit card';
}
else echo 'Sorry. This credit card or pin is invalid' . PHP_EOL;