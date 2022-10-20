<?php
class OpenWeather {

    private $apiKey;

    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function getToday(string $city): ?array  
    {   
      $data = $this->callAPI("weather?q={$city}");
        return [
            'temp' => $data ['main'] ['temp'],
            'description' => $data ['weather'][0]['description'],
            'date' => new DateTime()
        ];
    }

    public function getForcast(string $city): ?array
    {   
        $data = $this->callAPI("forecast/daily?q={$city}");
        foreach ($data ['list'] as $day) {
            $results = [
                'temp' => $day  ['temp'] ['day'],
                'descrition' => $day['weather'][0]['descrition'],
                'date' => new DateTime('@' . $day['dt'])
            ];
        }
        return $results;
    }

    private function callAPI(string $endpoint): ?array
    {   
        $curl = curl_init("https://api.openweathermap.org/data/2.5/{$endpoint}&units=metric&lang=fr&appid={$this->apikey}");
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CAINFO => dirname(__DIR__).DIRECTORY_SEPARATOR.'/cacert.pem',
            CURL_TIMEOUT => 1
        ]);
        $data = curl_exec($curl);
        if ($data === false || curl_getinfo($curl, CURLINFO_HTTP_CODE) !== 200){
            return null;
        }
        return json_decode($data, true);
        }
    }