<?php

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;

class UserTest extends TestCase
{
    public $json = array(
        "name"=>"Marcelo Mileris",
        "email"=>"marcelo.mileris@gmail.com",
        "birth"=>"1982-05-31",
        "phone"=>"19981308867",
        "document"=>"32369295880",
        "zip_code"=>"13344350",
        "number"=>"242");

    public $url = "http://localhost:8000/user";
    
    public function testListAll()
    {
        $client = new Client();
        $client->post($this->url, ['body'=>json_encode($this->json), 'headers' => ['Content-type' => 'application/json']]);

        $response = $client->get($this->url);
        $response = $response->getBody()->getContents();
        $this->assertTrue(count(json_decode($response, true)) > 0);
    }

    public function testListUser() 
    {
        $client = new Client();
        $response = $client->post($this->url, ['body'=>json_encode($this->json), 'headers' => ['Content-type' => 'application/json']]);
        $response = $response->getBody()->getContents();

        $data = json_decode($response, true);
        $id = $data["data"]["id"];

        $response = $client->get($this->url."/$id");
        $response = $response->getBody()->getContents();
        $this->assertTrue(count(json_decode($response, true)) > 0);        
    }

    public function testAddUser()
    {
        $client = new Client();
        $response = $client->post($this->url, ['body'=>json_encode($this->json), 'headers' => ['Content-type' => 'application/json']]);
        $response = $response->getBody()->getContents();

        $data = json_decode($response, true);
        $id = $data["data"]["id"];

        $response = $client->get($this->url."/$id");
        $response = $response->getBody()->getContents();
        $this->assertTrue(count(json_decode($response, true)) > 0);  
    }

    public function testDeleteUser()
    {
        $client = new Client();
        $response = $client->post($this->url, ['body'=>json_encode($this->json), 'headers' => ['Content-type' => 'application/json']]);
        $response = $response->getBody()->getContents();

        $data = json_decode($response, true);
        $id = $data["data"]["id"];

        $client->delete($this->url."/$id");

        $response = $client->get($this->url."/$id");
        $response = $response->getBody()->getContents();
        $data = json_decode($response, true);

        $this->assertTrue($data["data"] == "nenhum usuário encontrado!");  
    }    

    public function testUpdateUser()
    {
        $client = new Client();
        $response = $client->post($this->url, ['body'=>json_encode($this->json), 'headers' => ['Content-type' => 'application/json']]);
        $response = $response->getBody()->getContents();

        $data = json_decode($response, true);
        $id = $data["data"]["id"];

        $json = $this->json;
        $json["id"] = $id;
        $json["zip_code"] = "13348510";

        $response = $client->put($this->url, ['body'=>json_encode($json), 'headers' => ['Content-type' => 'application/json']]);

        $response = $client->get($this->url."/$id");
        $response = $response->getBody()->getContents();
        $data = json_decode($response, true);
        var_dump($data);

        $this->assertTrue($data["data"][0]["zip_code"] == "13348510");  
    }   
}

?>