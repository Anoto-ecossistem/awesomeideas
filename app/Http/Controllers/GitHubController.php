<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GitHubController extends Controller
{
    
    public function getRepositories() {
        $response = Http::withOptions([
            'verify' => false,
        ])->get("https://api.github.com/search/repositories?q=stars:>10000&sort=stars&order=desc");

        if ($response->successful()) {

            $data = $response->json();

            return $data['items'];
        } else {
            echo "Error: " . $response->status();
            return [];
        }
    }

    public function ReadRepositories(){
        $repositories = $this-> getRepositories();

        if (!empty($repositories)) {
            foreach ($repositories as $repo) {
                echo "<h2>" . htmlspecialchars($repo['name']) . "</h2>";
                echo "<p><strong>Description:</strong> " . htmlspecialchars($repo['description']) . "</p>";
                echo "<p><strong>Stars:</strong> " . htmlspecialchars($repo['stargazers_count']) . "</p>";
                echo "<p><strong>Forks:</strong> " . htmlspecialchars($repo['forks_count']) . "</p>";
                echo "<p><strong>Owner:</strong> " . htmlspecialchars($repo['owner']['login']) . "</p>";
                echo "<p><a href='" . htmlspecialchars($repo['html_url']) . "'>Repository Link</a></p>";
                echo "<hr>";
            }
        } else {
            echo "No popular repositories found.";
        }
    }

    public function showRepositories() {
        $repositories = $this->getRepositories();
    
        return view('welcome', ['repositories' => $repositories]);
    }
}
