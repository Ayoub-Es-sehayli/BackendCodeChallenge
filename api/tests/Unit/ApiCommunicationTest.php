<?php

namespace Tests\Unit;

use App\Models\Repository;
use App\Services\RepositoriesService;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use SebastianBergmann\Environment\Console;
use Tests\TestCase;

use function PHPUnit\Framework\assertCount;

class ApiCommunicationTest extends TestCase
{
    private function request_url()
    {
        return "https://api.github.com/search/repositories?q=&sort=stars&order=desc&per_page=100";
    }

    /** @test */
    public function canGetTheRepositoriesList()
    {
       $date = Carbon::now()->subMonth()->toDateString();
        $client = new Client([
            'base_uri' => 'https://api.github.com',
            'verify' => base_path('cacert.pem'),
        ]);
        $raw_response = $client->get("search/repositories", [
            'query' => [
                'q' => "created:>{$date}",
                'sort' => 'stars',
                'order' => 'desc',
                'per_page' => '100'
            ]
        ]);

        $this->assertNotEmpty($raw_response->getBody());
        $response = json_decode((string)$raw_response->getBody());
        $this->assertCount(100, $response->items);
    }

    /** @test */
    public function responseIsMappedProperly()
    {
        $repositories = RepositoriesService::getRepositories();

        $this->assertNotEmpty($repositories);
    }
}
