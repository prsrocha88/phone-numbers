<?php

namespace App;

use Illuminate\Support\Facades\DB;

class Phones
{
    public $phone_codes;

    public function __construct()
    {
        $this->phone_codes = config('app.phone_codes');
    }

    public function getRows($country, $state, $start)
    {
        $customers_phones = DB::table('customer')->select('phone')->get();

        $count = 1;
        $limit = $start + 5;
        $phones = [];
        foreach ($customers_phones as $customer) {

            $filter = $this->checkFilters($country, $state, $customer->phone);

            if ($filter) {

                if ($count <= $start) {
                    $count++;
                    continue;
                }

                $phones[] = [
                    'country' => $this->getPhoneCountry($customer->phone),
                    'state' => $this->getPhoneState($customer->phone),
                    'code' => $this->getPhoneCode($customer->phone),
                    'num' => $this->getPhoneNum($customer->phone)
                ];

                if ($count == $limit) {
                    break;
                } else {
                    $count++;
                }
            }
        }

        return $phones;
    }



    public function getPhoneCode($phone)
    {
        preg_match('#\((.*?)\)#', $phone, $match);
        return $match[1];
    }

    public function getPhoneNum($phone)
    {
        return str_replace('('.$this->getPhoneCode($phone).')', '', $phone );
    }

    public function getPhoneState($phone)
    {
        $code = $this->getPhoneCode($phone);
        if (isset($this->phone_codes[$code]['regex'])) {
            $regex = '#' . $this->phone_codes[$code]['regex'] . '#';
        } else {
            $regex = null;
        }

        return isset($regex) && preg_match($regex, $phone) ? 'OK' : 'NOK';
    }

    public function getPhoneCountry($phone)
    {
        $code = $this->getPhoneCode($phone);
        return $this->phone_codes[$code]['country'];
    }

    public function checkFilters($code, $state, $phone)
    {
        if ($code && $code != $this->getPhoneCode($phone)) {
            return false;
        }
        if ($state && $state != $this->getPhoneState($phone)) {
            return false;
        }
        return true;
    }
}
