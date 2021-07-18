<?php

require_once __DIR__ . '/vendor/autoload.php';

use Api\BankApi;
use Lib\Atm;

// There is only one client in this test task, because we don't have any real database
$client_id = 1234567890;
$client_pin = 1234;
$client_balance = 3000; // Euro
$client_overdraft = 1000; // available extra Euro

BankApi::Initialize($client_id, $client_pin, $client_balance, $client_overdraft);

$atm = new Atm(50000);

$atm->insert_card_id(1234567890)->get_pin(1234);

if($atm->validate()) {
    // simulation of simple ATM interface
    echo 'Please choose operation' . PHP_EOL;
    foreach ($atm->get_operations() as $operation) {
        echo $operation . PHP_EOL;
    }

    // try to get some money to buy new Phone
    if($atm->get_money(250)){
        echo '...' . PHP_EOL . 'Operation successful.' . PHP_EOL;
    }
    else echo 'Error' . PHP_EOL;

    // put in some money earned on freelance
    if($atm->put_money(725)){
        echo '...' . PHP_EOL . 'Operation successful.' . PHP_EOL;
    }
    else echo 'Error' . PHP_EOL;

    // try to get some money to buy new 4K TV
    if($atm->get_money(3500)){
        echo '...' . PHP_EOL . 'Operation successful.' . PHP_EOL;
    }
    else echo 'Error' . PHP_EOL;

    // try to get some money for new Laptop
    if($atm->get_money(2000)){
        echo '...' . PHP_EOL . 'Operation successful.' . PHP_EOL;
    }
    else echo 'Error' . PHP_EOL;

    // End of working
    echo $atm->print_receipt() . PHP_EOL . 'Please don\'t forget your credit card' . PHP_EOL;
    // DEBUG_
    $current_vault = $atm->get_current_vault();
    $vault_euro = $current_vault / 100;
    $vault_cent = $current_vault % 100;
    if($vault_cent % 10 == 0) $vault_cent .= '0';
    echo "Current vault: $vault_euro.$vault_cent"  . PHP_EOL;
    // _DEBUG
}
else echo 'Sorry. This credit card or pin is invalid' . PHP_EOL;