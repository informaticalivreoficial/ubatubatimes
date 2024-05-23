<?php

namespace App\Services;

use App\Repositories\ConfigRepository;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Support\Cropper;

class ConfigService
{
    protected $configRepository;
    protected $idConfig = 1;

    public function __construct(ConfigRepository $configRepository)
    {
        $this->configRepository = $configRepository;
    }

    public function getConfig()
    {
        $config = $this->configRepository->getConfigById($this->idConfig);
        return $config;
    }

    public function getMetaImg()
    {
        $config = $this->configRepository->getConfigById($this->idConfig);
        
        $image = $config->metaimg; 
        if(empty($config->metaimg) || !Storage::disk()->exists($image)) {
            return url(asset('backend/assets/images/image.jpg'));
        } 

        return Storage::url($image); 
    }
}