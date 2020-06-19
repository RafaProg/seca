<?php

namespace App\Services;

use GuzzleHttp\Client;
use App\Model\Release;
use App\Model\ReleaseTime;
use Illuminate\Support\Facades\Storage;

class AutomaticRelease
{
    private $client;
    private $release;
    private $releaseTime;
    private $interval;

    public function __construct(ReleaseTime $releaseTime)
    {
        $this->releaseTime = $releaseTime;
        $this->release = new Release();
        $this->client = new Client();
        $this->interval = (int) Storage::get('/timeinterval/timeinterval.txt');
    }

    public function __invoke()
    {
        $this->releaseClassroomsSequence();

        if (!$this->releaseTime->release_in_sequence) {
            $this->reoderReleaseClassrooms();
        }
    }

    private function releaseClassroomsSequence()
    {
        foreach ($this->release->orderBy('release_order', 'asc')->get() as $release) {
            $this->sendMessage($release->classroom_id);

            if ($this->releaseTime->release_in_sequence) {
                sleep($this->interval);
            }
        }
    }

    private function sendMessage($idClassroom)
    {
        $this->client->request('GET', 'http://localhost/consumir-api/testeFile.php', [
            'query' => [
                'port' => $idClassroom,
                'action' => 1
            ]
        ]);
    }

    private function reoderReleaseClassrooms()
    {
        $release = $this->release->all();

        $release->map(function ($item) use ($release) {
            $item->release_order -= 1;
            if ($item->release_order == 0) $item->release_order = $release->count();

            // update time
            $item->save();

            return $item;
        });
    }
}
