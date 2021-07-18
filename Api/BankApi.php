<?php


namespace Api;


/**
 * Class BankApi
 * @package Lib
 * Fake Bank API - just to simulate connection between ATM/Terminal/PointOfSale and Bank API
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
        self::$balance = $balance * 100; // store money in cents
        self::$overdraft = $overdraft * 100;
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
        if($amount < 0){
            if(self::$balance + $amount >= self::$overdraft * -1){
                self::$balance += $amount;
                return true;
            }
            return false;
        }

        self::$balance += $amount;
        return true;
    }

}