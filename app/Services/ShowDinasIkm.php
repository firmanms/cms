<?php  
  
namespace App\Services;  
  
use GuzzleHttp\Client;  
use GuzzleHttp\Exception\RequestException;  
  
class ShowDinasIkm  
{  
    protected $client;  
  
    public function __construct(Client $client)  
    {  
        $this->client = $client;  
    }  
  
    public function getSchools()  
    {  
        $url = "https://skm.bandungkab.go.id/api/showDinas";  
  
        try {  
            $response = $this->client->request('GET', $url);  
            $body = $response->getBody();  
            $responseString = $body->getContents();  
            $responseData = json_decode($responseString, true);  
  
            if (json_last_error() !== JSON_ERROR_NONE) {  
                throw new \Exception('Error decoding JSON: ' . json_last_error_msg());  
            }  
  
            if (!isset($responseData) || empty($responseData)) {  
                throw new \Exception('No data available.');  
            }  
  
            usort($responseData, function ($a, $b) {  
                return strcmp($a['nm_dinas'] ?? '', $b['nm_dinas'] ?? '');  
            });  
  
            return $responseData;  
        } catch (RequestException $e) {  
            throw new \Exception('Error occurred while fetching data: ' . $e->getMessage());  
        } catch (\Exception $e) {  
            throw new \Exception('An unexpected error occurred: ' . $e->getMessage());  
        }  
    }  
}  
