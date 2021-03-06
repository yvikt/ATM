<?php


namespace Lib;

/**
 * Class Terminal
 * @package Lib
 * POS is machine that can only accept payments for goods and services
 */
class Pos extends GenericBankMachine
{
    protected array $operations = [
        'make a payment'
    ];
}