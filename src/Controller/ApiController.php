<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiController extends AbstractController
{
    private $httpClient;

    public function __construct(HttpClientInterface $httpClient) {
        $this->httpClient = $httpClient;
    }
    
    /**
     * @Route("/api/weather/geolocation", name="api_weather_geolocation")
     */
    public function geolocationWeather(): Response
    {
        $response = $this->httpClient->request("GET", "https://api.ipify.org?format=json");
        $content = $response->toArray();
        $ip = $content["ip"];

        $response = $this->httpClient->request("GET", "http://www.geoplugin.net/json.gp?ip=$ip");
        $content = $response->toArray();
        $city = $content["geoplugin_city"];

        $response = $this->httpClient->request("GET", "http://api.openweathermap.org/data/2.5/weather?q=$city&appid=9507c6b76a5357dc063652c627cb73e2&units=metric&lang=fr");
        $content = $response->toArray();

        return $this->json($content);
    }

    /**
     * @Route("/api/weather/{city}", name="api_weather_city")
     */
    public function cityWeather(string $city = "Paris"): Response
    {
        $response = $this->httpClient->request("GET", "http://api.openweathermap.org/data/2.5/weather?q=$city&appid=9507c6b76a5357dc063652c627cb73e2&units=metric&lang=fr");
        $content = $response->toArray();

        return $this->json($content);
    }
}
