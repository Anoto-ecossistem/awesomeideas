<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GitHubController extends Controller
{
    
    public function getRepositories() {
        $response = Http::withOptions([
            'verify' => false,
        ])->get("https://api.github.com/search/repositories?q=Q");

        if ($response->successful()) {

            $data = $response->json();

            print_r($data);
        } else {
            echo "Error: " . $response->status();
        }
    }
}
