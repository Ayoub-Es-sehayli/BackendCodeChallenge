<?php

namespace App\Services;

use App\Models\Repository;
use Carbon\Carbon;
use GuzzleHttp\Client;

class RepositoriesService
{
    public static function getRepositories()
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
        $response = json_decode((string)$raw_response->getBody());

        // Select only the necessary data from the result
        $repositories = collect($response->items)->mapToGroups(function($r, $index) {
            return [$r->language => new Repository (
                $r->id,
                $r->full_name,
                $r->url,
                $r->language
            )];
        })->map(function($languageGroupe, $language){
            return [
                'count' => $languageGroupe->count(),
                'items' => $languageGroupe->all()
            ];
        });
        return $repositories;
    }
}
