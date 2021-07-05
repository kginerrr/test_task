<?php

namespace src;
/**
 * Class Req
 * @package src
 */
class req
{
    private $key;

    /**
     * req constructor.
     * @param string $key
     */
    public function __construct(string $key)
    {
        $this->key = $key;
    }

    /**
     * @return array
     * request for create list of cities
     */
    private function getApiMusementCities(): array
    {
        $ch = curl_init("https://api.musement.com/api/v3/cities");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = json_decode($response = curl_exec($ch));
        $stack = [];
        foreach ($data as $city=>$name)
        {
            array_push($stack,  str_replace(' ', '_', $name->name));
        }

        return $stack;
    }

    /**
     *
     */
    public function getWeatherByCity()
    {
        $cities = $this->getApiMusementCities();
        foreach ($cities as $city)
        {
            $ch = curl_init("http://api.weatherapi.com/v1/forecast.json?key=".$this->key."&q=".$city."&days=2");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $data = json_decode($response = curl_exec($ch));
            if (!property_exists($data, "error"))
            {
                echo $city. " - ".
                    $data->forecast->forecastday[0]->hour[12]->condition->text. " - ".
                    $data->forecast->forecastday[1]->hour[12]->condition->text. "\n";

            }

        }
    }

}

$data = new req('e114911e93b54a39a92134016210207');
$data->getWeatherByCity();
