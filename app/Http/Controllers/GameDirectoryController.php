<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use GuzzleHttp\Client;
use App\Models\GameDirectory;
use Illuminate\Support\Facades\Log;

class GameDirectoryController extends Controller
{
    public function home()
    {
        $client = new Client();
        $apiKey = env('RAWG_API_KEY');

        if (!$apiKey) {
            return response()->json(['error' => 'API key is missing'], 400);
        }

        try {
            $response = $client->request('GET', 'https://api.rawg.io/api/games', [
                'query' => [
                    'key' => $apiKey,
                    'ordering' => '-added',
                    'page_size' => 10,
                ]
            ]);

            $data = json_decode($response->getBody(), true);
            $games = $data['results'] ?? [];

            return view('home', ['games' => $games]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function upload()
    {
        return view('directories.upload');
    }

    public function scanDirectory(Request $request)
    {
        $directoryPath = $request->input('directory_path');
        Log::info('Scanning directory: ' . $directoryPath);

        if (!File::exists($directoryPath) || !File::isDirectory($directoryPath)) {
            Log::error('Directory does not exist or is not a directory: ' . $directoryPath);
            return response()->json(['error' => 'Directory does not exist or is not a directory'], 400);
        }

        try {
            $directories = File::directories($directoryPath);
            Log::info('Found directories: ' . implode(', ', $directories));

            $games = [];
            foreach ($directories as $dir) {
                $gameName = basename($dir);
                $gameInfo = $this->getGameInfo($gameName);
                if ($gameInfo) {
                    GameDirectory::create([
                        'name' => $gameInfo['name'],
                        'path' => $dir,
                        'image_url' => $gameInfo['background_image'],
                        'description' => $gameInfo['description_raw'] ?? 'No description available',
                        'rating' => $gameInfo['rating'] ?? null,
                        'released' => $gameInfo['released'] ?? null,
                        'platforms' => $gameInfo['platforms'] ?? null,
                        'genres' => $gameInfo['genres'] ?? null,
                    ]);
                    $games[] = $gameInfo;
                } else {
                    Log::warning('No game info found for directory: ' . $dir);
                }
            }

            return response()->json(['games' => $games], 200);
        } catch (\Exception $e) {
            Log::error('Error scanning directory: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to scan directory: ' . $e->getMessage()], 500);
        }
    }

    public function index()
    {
        $gameDirectories = GameDirectory::all();

        foreach ($gameDirectories as $game) {
            $game->platformIcons = $this->getPlatformIcons($game->platforms);
        }

        return view('directories.index', ['games' => $gameDirectories]);
    }

    private function getGameInfo($gameName)
{
    $client = new Client();
    $apiKey = env('RAWG_API_KEY');

    if (!$apiKey) {
        return response()->json(['error' => 'API key is missing'], 400);
    }

    try {
        $response = $client->request('GET', 'https://api.rawg.io/api/games', [
            'query' => [
                'key' => $apiKey,
                'search' => $gameName,
            ]
        ]);

        $data = json_decode($response->getBody(), true);
        $game = $data['results'][0] ?? null;

        if ($game) {
            // Log the raw API response for debugging
            Log::info('RAWG API Response', ['game' => $game]);

            $platforms = array_map(function ($platform) {
                return $platform['platform']['name'];
            }, $game['platforms']);

            // Fetch the trailer URL if available
            $trailerUrl = $game['clip']['clip'] ?? null;

            return [
                'name' => $game['name'],
                'background_image' => $game['background_image'],
                'description_raw' => $game['description_raw'] ?? 'No description available',
                'rating' => $game['rating'] ?? 'N/A',
                'released' => $game['released'] ?? 'N/A',
                'platforms' => implode(', ', $platforms),
                'genres' => implode(', ', array_column($game['genres'], 'name')),
                'trailer_url' => $trailerUrl,
            ];
        }

        return null;
    } catch (\GuzzleHttp\Exception\BadResponseException $e) {
        $response = $e->getResponse();
        $responseBody = $response->getBody()->getContents();
        Log::error('Bad response error fetching game info: ' . $e->getMessage(), ['response' => $responseBody]);
        return null;
    } catch (\Exception $e) {
        Log::error('General error fetching game info: ' . $e->getMessage());
        return null;
    }
}

    public function show($id)
    {
        $gameDirectory = GameDirectory::findOrFail($id);
        $platformIcons = $this->getPlatformIcons($gameDirectory->platforms);

        return view('game.show', ['game' => $gameDirectory, 'platformIcons' => $platformIcons]);
    }


    private function getPlatformIcons($platforms)
    {
        $platformIcons = [
            'PC' => 'fab fa-windows',
            'PlayStation 4' => 'fab fa-playstation',
            'Xbox One' => 'fab fa-xbox',
            'Nintendo Switch' => 'fas fa-gamepad',
            'iOS' => 'fab fa-apple',
            'Android' => 'fab fa-android',
            // Add more platforms and their corresponding icons as needed
        ];

        $icons = [];
        foreach (explode(', ', $platforms) as $platform) {
            if (isset($platformIcons[$platform])) {
                $icons[] = $platformIcons[$platform];
            }
        }

        return $icons;
    }

}
