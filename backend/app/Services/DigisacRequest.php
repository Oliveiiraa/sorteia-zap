<?php

namespace App\Services;

use GuzzleHttp\Client;

class DigisacRequest
{
    public function getServices()
    {
        $jsondata = ['headers' => ['Authorization' => "Bearer " . getenv('TOKEN_DIGISAC')]];

        $clientHTTP = new Client(['http_errors' => false]);

        $response = $clientHTTP->get(getenv('URL_DIGISAC') . 'services/?query={"where":{"archivedAt":{"$eq":null}, "type": "whatsapp"}}', $jsondata);

        if ($response->getStatusCode() == 200) {

            return json_decode($response->getBody()->getContents());
        } else {

            return false;
        }
    }

    public function getUniqueService($id)
    {
        $jsondata = ['headers' => ['Authorization' => "Bearer " . getenv('TOKEN_DIGISAC')]];

        $clientHTTP = new Client(['http_errors' => false]);

        $response = $clientHTTP->get(getenv('URL_DIGISAC') . 'services/' . $id, $jsondata);

        if ($response->getStatusCode() == 200) {

            return json_decode($response->getBody()->getContents());
        } else {

            return false;
        }
    }

    public function getContact($id)
    {
        $jsondata = ['headers' => ['Authorization' => "Bearer " . getenv('TOKEN_DIGISAC')]];

        $clientHTTP = new Client(['http_errors' => false]);

        $response = $clientHTTP->get(getenv('URL_DIGISAC') . 'contacts/' . $id . '?include[0]=avatar', $jsondata);

        if ($response->getStatusCode() == 200) {

            return json_decode($response->getBody()->getContents());
        } else {

            return false;
        }
    }

    public function getQrCode($number)
    {
        $clientHTTP = new Client(['http_errors' => false]);

        $response = $clientHTTP->get("https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=wa.me/{$number}?text=vim_pelo_sorteio");

        if ($response->getStatusCode() == 200) {

            return $response->getBody()->getContents();
        } else {

            return false;
        }
    }

    public function sendMessage($number, $service_id, $message)
    {
        $jsondata = [
            'headers' => ['Authorization' => "Bearer " . getenv('TOKEN_DIGISAC')],
            'json' => [
                'number' => $number,
                'serviceId' => $service_id,
                'text' => $message
            ]
        ];

        $clientHTTP = new Client(['http_errors' => false]);
        $response = $clientHTTP->post(getenv('URL_DIGISAC') . 'messages/', $jsondata);

        if ($response->getStatusCode() == 200) {

            return $response->getBody()->getContents();
        } else {

            return false;
        }
    }
}
