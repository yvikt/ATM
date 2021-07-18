<?php


namespace Lib;

use Api\BankApi;

/**
 * Class Atm
 * @package Lib
 * This ATM has such parts:
 *  credit card reader
 *  keyboard to get a pin
 *  printer to print receipt
 *  money vault
 *  connection device to interact with the Bank
 */
class Atm extends GenericBankMachine
{
    protected array $operations = [
        'check_balance',
        'put_money',
        'get_money'
        ];

    private int $vault = 0; // available amount of money (Euros) that is now in ATM

    public function __construct($amount)
    {
        $this->vault = $amount * 100; // store money in cents
    }

    public function get_current_vault() :int
    {
        return $this->vault;
    }

    protected function take_out_from_vault($sum) :bool
    {
        $this->vault -= $sum;
        return true;
    }

    protected function put_into_vault($sum) :bool
    {
        $this->vault += $sum;
        return true;
    }

    public function check_balance() :int
    {
        return BankApi::get_client_balance();
    }

    // ATM can only give notes but no coins. So $sum is int
    public function get_money(int $sum) :bool
    {
        $sum *= 100;
        if(BankApi::total_available() >= $sum && $this->vault >= $sum){
            // in real life transaction needs to be BEGIN here
            BankApi::update_balance($sum * -1) &&
            $this->take_out_from_vault($sum);
            // and END of transaction
            return true;
        }
        return false;
    }

    // ATM can only take notes but no coins. So $sum is int
    public function put_money(int $sum) :bool
    {
        $sum *= 100;
        // in real life transaction needs to be BEGIN here
        $this->put_into_vault($sum) &&
        BankApi::update_balance($sum);
        // and END of transaction
        return true;
    }

    public function print_receipt() :string
    {
        $balance = BankApi::get_client_balance();
        $balance_euro = $balance / 100;
        $balance_cent = $balance % 100;
        if($balance_cent % 10 == 0) $balance_cent .= '0';

        $available = BankApi::total_available();
        $available_euro = $available / 100;
        $available_cent = $available % 100;
        if($available_cent % 10 == 0) $available_cent .= '0';

        return "This is your current balance: $balance_euro.$balance_cent" . PHP_EOL .
               "Total available: $available_euro.$available_cent";
    }
}