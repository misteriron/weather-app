<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiController extends AbstractController
{
    private $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @Route("/api/weather/{city}", name="api_weather_city")
     */
    public function cityWeather(string $city = "Paris"): Response
    {
        // Suppression de la clé du dépôt
        // Il faut la clé de l'api openweathermap pour que cela fonctionne
        $response = $this->httpClient->request("GET", "http://api.openweathermap.org/data/2.5/weather?q=$city&appid={{api_key}}&units=metric&lang=fr");
        $content = $response->toArray();

        return $this->json($content);
    }
}
