<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstagramFeed extends Model
{
    use HasFactory;

    private $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function getFeed()
    {
        $user = $this->user;

        if (empty($user)) {
            return null;
        }

        $items = [];

        $client = new \GuzzleHttp\Client;
        $url = sprintf('https://www.instagram.com/%s/media', $user);
        $response = $client->get($url);
        $items = json_decode((string) $response->getBody(), true)['items'];
        return $items;
    }
}
