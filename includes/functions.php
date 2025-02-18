<?php

function brlbd_get_currency_list()
{
    $currencies = get_transient('brlbd_currency_list');

    if (!$currencies) {
        $currencies = [
            "$" => "USD ",
            "€" => "EUR ",
            "£" => "GBP ",
            "৳" => "BDT ",
            "₹" => "INR ",
            "¥" => "JPY ",
            "₩" => "KRW ",
            "₽" => "RUB ",
            "₴" => "UAH ",
            "₺" => "TRY - Turkish Lira",
            "R$" => "BRL - Brazilian Real",
            "₦" => "NGN - Nigerian Naira",
            "د.إ" => "AED - UAE Dirham",
            "CHF" => "CHF - Swiss Franc",
            "HK$" => "HKD - Hong Kong Dollar",
            "C$" => "CAD - Canadian Dollar",
            "A$" => "AUD - Australian Dollar",
            "NZ$" => "NZD - New Zealand Dollar",
            "SGD$" => "SGD - Singapore Dollar",
            "MX$" => "MXN - Mexican Peso",
            "ZAR" => "ZAR - South African Rand",
            "MYR" => "MYR - Malaysian Ringgit",
            "PHP" => "PHP - Philippine Peso",
            "IDR" => "IDR - Indonesian Rupiah",
            "THB" => "THB - Thai Baht",
            "VND" => "VND - Vietnamese Dong",
            "EGP" => "EGP - Egyptian Pound",
            "ARS$" => "ARS - Argentine Peso",
            "CLP$" => "CLP - Chilean Peso",
            "COP$" => "COP - Colombian Peso",
            "KR" => "SEK - Swedish Krona",
            "NOK" => "NOK - Norwegian Krone",
            "DKK" => "DKK - Danish Krone",
        ];

        set_transient('brlbd_currency_list', $currencies, DAY_IN_SECONDS); // Cache for 24 hours
    }

    return $currencies;
}
