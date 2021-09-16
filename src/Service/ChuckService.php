<?php

namespace App\Service;

use App\Exception\ApiException;
use App\Exception\JsonException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class ChuckService
{
    private $client;
    private $hostname;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
        $this->hostname = 'https://api.chucknorris.io';
    }

    /**
     * @return array
     * @throws JsonException
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function getCategories(): array
    {
        $response = $this->client->request('GET', $this->hostname . '/jokes/categories');

        return $this->handleResponse($response);
    }

    public function getCategory(string $category): array
    {
        $response = $this->client->request('GET', $this->hostname . '/jokes/random?category='.$category);

        return $this->handleResponse($response);
    }


    /**
     * @param ResponseInterface $response
     * @return array
     * @throws JsonException
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    private function handleResponse(ResponseInterface $response): array
    {
        $content  = [];
        $error    = false;
        $errorMsg = '';

        try {
            if (Response::HTTP_OK !== $response->getStatusCode()) {
                throw new ApiException('Erreur ' . $response->getStatusCode());
            }

            $contentJson = $response->getContent();
            $content = json_decode($contentJson);

            if (JSON_ERROR_NONE !== json_last_error()) {
                throw new JsonException(json_last_error_msg());
            }
        } catch (ApiException $e) {
            $error = true;
            $errorMsg = 'L\'api a mal fonctionné, ' . $e->getMessage();
        } catch (JsonException $e) {
            $error = true;
            $errorMsg = 'Le json retourné n\'est pas valide, ' . $e->getMessage();
        } catch (\Exception $e) {
            $error = true;
            $errorMsg = $e->getMessage();
        }

        return [
            'content'  => $content,
            'error'    => $error,
            'errorMsg' => $errorMsg
        ];
    }
}
