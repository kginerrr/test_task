<?php

namespace MyApp;

class Weather
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
        $data = json_decode(curl_exec($ch));
        $stack = [];
        foreach ($data as $city=>$name)
        {
            array_push($stack,  str_replace(' ', '_', $name->name));
        }
        return $stack;
    }

    /**
     * print weather by every city from Musement api at 12.00 today and tomorrow
     */
    public function getWeatherByCity()
    {
        $cities = $this->getApiMusementCities();
        foreach ($cities as $city)
        {
            $ch = curl_init("http://api.weatherapi.com/v1/forecast.json?key=".$this->key."&q=".$city."&days=2");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $data = json_decode(curl_exec($ch));
            if (!property_exists($data, "error"))
            {
                echo "Processed city ".$city. " - ".
                    $data->forecast->forecastday[0]->hour[12]->condition->text. " - ".
                    $data->forecast->forecastday[1]->hour[12]->condition->text. "\n";
            }
        }
    }
}