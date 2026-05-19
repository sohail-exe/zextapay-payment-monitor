<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class ZextaPay_Error_Parser {
    private static $error_map = [
        'do_not_honor'         => 'The customer bank declined the card.',
        'card_declined'        => 'Customer card was declined.',
        'insufficient_funds'   => 'Customer does not have enough funds.',
        'api_connection_error' => 'Cannot connect to payment gateway servers.',
        'expired_card'         => 'The card has expired.',
        'incorrect_cvc'        => 'The card security code is incorrect.',
        'incorrect_number'     => 'The card number is incorrect.',
        'processing_error'     => 'An error occurred while processing the card.',
    ];

    public static function parse( $error_code ) {
        return self::$error_map[ $error_code ] ?? 'Unknown error: ' . $error_code;
    }
}