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
        $this->vault = $amount;
    }

    protected function take_out_from_vault($sum)
    {
        $this->vault -= $sum;
    }

    protected function put_into_vault($sum)
    {
        $this->vault += $sum;
    }

    public function check_balance() :int
    {
        return BankApi::get_client_balance();
    }

    public function get_money($sum) :bool
    {
        if(BankApi::total_available() >= $sum && $this->vault >= $sum){
            // in real life here needs to be BEGIN of transaction
            BankApi::update_balance($sum);
            $this->take_out_from_vault($sum);
            // and END of transaction
            return true;
        }
        return false;
    }

    public function put_money($sum) :bool
    {

    }
}