<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoletimOndas extends Model
{
    use HasFactory;

    private $url;

    public function __construct($url)
    {
        $this->url = $url;
    }

    public function getContent()
    {
        $url = $this->url;

        if (empty($url)) {
            return null;
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $this->url);    // get the url contents
        $data = curl_exec($ch); // execute curl request
        curl_close($ch);
        return simplexml_load_string($data); 
    }

    public function ventosManha()
    {
        $vento = $this->getContent();

        if (empty($vento)) {
            return null;
        }

        $vento_dir_manha =  ($vento->manha->vento_dir == 'ENE' ? 'Leste-nordeste' :
                            ($vento->manha->vento_dir == 'ESE' ? 'Leste-sudeste' :
                            ($vento->manha->vento_dir == 'SSE' ? 'Sul-sudeste' :
                            ($vento->manha->vento_dir == 'NE' ? 'Nordeste' :
                            ($vento->manha->vento_dir == 'NW' ? 'Noroeste' :
                            ($vento->manha->vento_dir == 'SE' ? 'Sudeste' :
                            ($vento->manha->vento_dir == 'SW' ? 'Sudoeste' :
                            ($vento->manha->vento_dir == 'N' ? 'Norte' :
                            ($vento->manha->vento_dir == 'O' ? 'Oeste' :
                            ($vento->manha->vento_dir == 'S' ? 'Sul' :
                            ($vento->manha->vento_dir == 'E' ? 'Leste' : 'Sem Vento')))))))))));
        
        return $vento_dir_manha;
    }

    public function ventosTarde()
    {
        $vento = $this->getContent();

        if (empty($vento)) {
            return null;
        }

        $vento_dir_tarde =  ($vento->tarde->vento_dir == 'ENE' ? 'Leste-nordeste' :
                            ($vento->tarde->vento_dir == 'ESE' ? 'Leste-sudeste' :
                            ($vento->tarde->vento_dir == 'SSE' ? 'Sul-sudeste' :
                            ($vento->tarde->vento_dir == 'NE' ? 'Nordeste' :
                            ($vento->tarde->vento_dir == 'NW' ? 'Noroeste' :
                            ($vento->tarde->vento_dir == 'SE' ? 'Sudeste' :
                            ($vento->tarde->vento_dir == 'SW' ? 'Sudoeste' :
                            ($vento->tarde->vento_dir == 'N' ? 'Norte' :
                            ($vento->tarde->vento_dir == 'O' ? 'Oeste' :
                            ($vento->tarde->vento_dir == 'S' ? 'Sul' :
                            ($vento->tarde->vento_dir == 'E' ? 'Leste' : 'Sem Vento')))))))))));
        return $vento_dir_tarde;
    }

    public function ondasAlturaManha()
    {
        $onda = $this->getContent();

        if (empty($onda)) {
            return null;
        }

        if($onda->manha->altura < 1):
            $altura_onda_manha = 'Flat';
            $img = url(asset('frontend/assets/images/onda-ruim.png'));
        elseif($onda->manha->altura >= 1 && $onda->manha->altura < 1.3):
            $altura_onda_manha = '0,5';
            $img = url(asset('frontend/assets/images/onda-ruim.png'));
        elseif($onda->manha->altura >= 1.3 && $onda->manha->altura < 1.8):
            $altura_onda_manha = '0,5 a 1,0';
            $img = url(asset('frontend/assets/images/onda-regular.png'));
        elseif($onda->manha->altura >= 1.8 && $onda->manha->altura < 2.4):
            $altura_onda_manha = '1,0 a 1,5';
            $img = url(asset('frontend/assets/images/onda-boa.png'));
        elseif($onda->manha->altura >= 2.4 && $onda->manha->altura < 3.0):
            $altura_onda_manha = '1,5';
            $img = url(asset('frontend/assets/images/onda-boa.png'));
        elseif($onda->manha->altura >= 3.0 && $onda->manha->altura < 3.4):
            $altura_onda_manha = '1,5 a 2,0';
            $img = url(asset('frontend/assets/images/onda-exelente.png'));
        elseif($onda->manha->altura >= 3.8 && $onda->manha->altura < 4.2):
            $altura_onda_manha = '2,0';
            $img = url(asset('frontend/assets/images/onda-exelente.png'));
        elseif($onda->manha->altura >= 4.2 && $onda->manha->altura < 4.8):
            $altura_onda_manha = '2,0 a 2,5';
            $img = url(asset('frontend/assets/images/onda-super-exelente.png'));
        endif;

        return [
            'altura' => $altura_onda_manha,
            'img' => $img,
        ];
    }
    
    public function ondasAlturaTarde()
    {
        $onda = $this->getContent();

        if (empty($onda)) {
            return null;
        }

        if($onda->tarde->altura < 1):
            $altura_onda_tarde = 'Flat';
            $img = url(asset('frontend/assets/images/onda-ruim.png'));
        elseif($onda->tarde->altura >= 1 && $onda->tarde->altura < 1.3):
            $altura_onda_tarde = '0,5';
            $img = url(asset('frontend/assets/images/onda-ruim.png'));
        elseif($onda->tarde->altura >= 1.3 && $onda->tarde->altura < 1.8):
            $altura_onda_tarde = '0,5 a 1,0';
            $img = url(asset('frontend/assets/images/onda-regular.png'));
        elseif($onda->tarde->altura >= 1.8 && $onda->tarde->altura < 2.4):
            $altura_onda_tarde = '1,0 a 1,5';
            $img = url(asset('frontend/assets/images/onda-boa.png'));
        elseif($onda->tarde->altura >= 2.4 && $onda->tarde->altura < 3.0):
            $altura_onda_tarde = '1,5';
            $img = url(asset('frontend/assets/images/onda-boa.png'));
        elseif($onda->tarde->altura >= 3.0 && $onda->tarde->altura < 3.4):
            $altura_onda_tarde = '1,5 a 2,0';
            $img = url(asset('frontend/assets/images/onda-exelente.png'));
        elseif($onda->tarde->altura >= 3.8 && $onda->tarde->altura < 4.2):
            $altura_onda_tarde = '2,0';
            $img = url(asset('frontend/assets/images/onda-exelente.png'));
        elseif($onda->tarde->altura >= 4.2 && $onda->tarde->altura < 4.8):
            $altura_onda_tarde = '2,0 a 2,5';
            $img = url(asset('frontend/assets/images/onda-super-exelente.png'));
        endif;

        return [
            'altura' => $altura_onda_tarde,
            'img' => $img,
        ];
    }
    
}
