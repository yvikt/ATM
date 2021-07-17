<?php


namespace Lib;

use Api\BankApi;

/**
 * Abstract Class GenericBankMachine
 * @package Lib
 * It can be ATM, Terminal or POS
 */
abstract class GenericBankMachine
{

    protected array $actions = ['print_receipt']; // machine reaction (not used yet)
    protected array $operations = []; // what customer can do

    protected int $credit_card_id = 0;
    protected int $pin = 0;

    public function get_operations() :array
    {
        return $this->operations;
    }

    // this method simulates insertion credit card in credit-card-reader to get its id
    public function insert_card_id($id) :GenericBankMachine
    {
        $this->credit_card_id = $id;
        return $this;
    }

    // this method simulates getting pin from client
    public function get_pin($pin)
    {
        $this->pin = $pin;
    }

    // check credential
    public function validate() :bool
    {
        if(BankApi::is_connected()) {
            return $this->is_client_valid() && $this->is_pin_valid();
        }
        return false;
    }

    // can this Bank serve certain credit card
    protected function is_client_valid() :bool
    {
        return $this->credit_card_id == BankApi::$client_id;
    }

    // chek if input pin is correct
    protected function is_pin_valid() :bool
    {
        return BankApi::check_client_pin($this->pin);
    }

    public function print_receipt() :string
    {
        return 'This is your receipt';
    }
}