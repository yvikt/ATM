<?php


namespace Api;


/**
 * Class BankApi
 * @package Lib
 * Fake Bank Api - just to simulate connection between ATM/Terminal/PointOfSale and Bank database
 */
class BankApi
{
    static int $client_id;
    static int $client_pin;
    static int $balance; // the amount of money available in cents
    static int $overdraft; // negative balance

    static function Initialize($client_id, $client_pin, $balance, $overdraft)
    {
        self::$client_id = $client_id;
        self::$client_pin = $client_pin;
        self::$balance = $balance;
        self::$overdraft = $overdraft;
    }

    static function is_connected() :bool
    {
        return true;
    }
    static function check_client_pin($pin) :bool
    {
        return $pin == self::$client_pin;
    }

    static function get_client_balance() :int
    {
        return self::$balance;
    }

    static function total_available() :int
    {
        return self::$balance + self::$overdraft;
    }

    static function update_balance($amount) :bool
    {
        if(self::$overdraft > self::$balance + $amount){
            self::$balance += $amount;
            return true;
        }
        return false;
    }

}