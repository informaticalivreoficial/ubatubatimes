<?php

namespace App\Services;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Str;

class GerarBoletimCardService
{
    private ImageManager $image;
    private string $fontBold;
    private string $fontRegular;
    private string $fontLight;

    public function __construct()
    {
        $this->image       = new ImageManager(new Driver());
        $this->fontBold    = public_path('fonts/Roboto-Bold.ttf');
        $this->fontRegular = public_path('fonts/Roboto-Regular.ttf');
        $this->fontLight   = public_path('fonts/Roboto-Light.ttf');
    }

    public function handle(array $ondas, ?array $tempo): array
    {
        $img = $this->image->create(1080, 1080)->fill('#f8fafc');

        $this->drawHeader($img);
        $this->drawBoxes($img);
        $this->drawOndas($img, $ondas);
        $this->drawClima($img, $tempo);
        $this->drawFooter($img);

        $dir = public_path('boletins');
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $filename = 'boletim-' . now()->format('Y-m-d-H-i-s') . '.jpg';
        $path     = $dir . '/' . $filename;

        $img->save($path, quality: 90);

        return [
            'path' => $path,
            'url'  => url('boletins/' . $filename),
        ];
    }
    // =========================
    // HEADER
    // =========================

    private function drawHeader($img): void
    {
        if (file_exists(public_path('icons/clima.png'))) {
            $icon = $this->image->read(public_path('icons/clima.png'))->resize(80, 80);
            $img->place($icon, 'top-left', 320, 60);
        }

        $img->text('Boletim do Dia', 420, 110, function ($font) {
            $font->filename($this->fontBold);
            $font->size(68);
            $font->color('#222222');
            $font->align('left');
        });
    }

    // =========================
    // BOXES (cards internos)
    // =========================

    private function drawBoxes($img): void
    {
        $boxOndas = $this->image->create(420, 720)->fill('#ffffff');
        $img->place($boxOndas, 'top-left', 80, 200);

        $boxClima = $this->image->create(420, 720)->fill('#ffffff');
        $img->place($boxClima, 'top-left', 580, 200);
    }

    // =========================
    // ONDAS
    // =========================

    private function drawOndas($img, array $ondas): void
    {
        $x = 290;

        $img->text('ONDAS', $x, 260, function ($font) {
            $font->filename($this->fontBold);
            $font->size(38);
            $font->color('#111111');
            $font->align('center');
        });

        // Ícone manhã
        if (
            !empty($ondas['manha']['img_path']) &&
            file_exists($ondas['manha']['img_path'])
        ) {
            $icon = $this->image
                ->read($ondas['manha']['img_path'])
                ->resize(100, 100);

            $img->place($icon, 'top-left', $x - 50, 300);
        }

        // --- MANHÃ ---
        $this->drawText($img, 'Manhã', $x, 460, $this->fontBold, 30, '#333333', 'center');
        $this->drawPeriodoOndas($img, $ondas['manha'] ?? null, $x, 500);

        // Ícone tarde
        if (
            !empty($ondas['tarde']['img_path']) &&
            file_exists($ondas['tarde']['img_path'])
        ) {
            $icon = $this->image
                ->read($ondas['tarde']['img_path'])
                ->resize(100, 100);

            $img->place($icon, 'top-left', $x - 50, 610);
        }

        // --- TARDE ---
        $this->drawText($img, 'Tarde', $x, 750, $this->fontBold, 30, '#333333', 'center');
        $this->drawPeriodoOndas($img, $ondas['tarde'] ?? null, $x, 790);
    }

    private function drawPeriodoOndas($img, ?array $periodo, int $x, int $y): void
    {
        if (!$periodo) {
            $this->drawText($img, 'Sem dados', $x, $y, $this->fontRegular, 26, '#999999', 'center');
            return;
        }

        $altura     = $periodo['altura'] ?? '-';
        $ondaDir    = $periodo['direcao_onda_short'] ?? '-';
        $ventoDir   = $periodo['vento_dir_short'] ?? '-';
        $vento      = isset($periodo['vento']) ? round($periodo['vento']) . ' km/h' : '-';

        // Tamanho em destaque
        $this->drawText($img, $altura, $x, $y, $this->fontBold, 42, '#0077b6', 'center');

        // Direção da onda
        $this->drawText($img, "Ondas: {$ondaDir}", $x, $y + 55, $this->fontRegular, 28, '#333333', 'center');

        // Vento
        $this->drawText($img, "Vento: {$ventoDir} - {$vento}", $x, $y + 95, $this->fontRegular, 28, '#555555', 'center');
    }

    // =========================
    // CLIMA
    // =========================

    private function drawClima($img, ?array $tempo): void
    {
        $x = 790;
        $hoje = $tempo[0] ?? null;

        if (!$hoje) return;

        $img->text('CLIMA', $x, 260, function ($font) {
            $font->filename($this->fontBold);
            $font->size(38);
            $font->color('#111111');
            $font->align('center');
        });

        if (!empty($hoje['img']) && file_exists(public_path('icons/' . $hoje['img']))) {
            $icon = $this->image->read(public_path('icons/' . $hoje['img']))->resize(100, 100);
            $img->place($icon, 'top-left', $x - 50, 300);
        }

        $this->drawMultiline($img, $this->wrap($hoje['previsao'] ?? ''), $x, 460, 28, 36);

        $this->drawText($img, "{$hoje['maxima']}°", $x, 600, $this->fontBold, 56, '#111111', 'center');
        $this->drawText($img, "Min {$hoje['minima']}°", $x, 660, $this->fontRegular, 30, '#666666', 'center');
    }

    // =========================
    // FOOTER
    // =========================

    private function drawFooter($img): void
    {
        $img->text('Boletim gerado por: ' . config('app.name'). ' - ' . now()->format('d/m/Y'), 540, 1000, function ($font) {
            $font->filename($this->fontLight);
            $font->size(30);
            $font->color('#888888');
            $font->align('center');
        });
    }

    // =========================
    // HELPERS
    // =========================

    private function drawText($img, string $text, int $x, int $y, string $font, int $size, string $color, string $align): void
    {
        $img->text($text, $x, $y, function ($f) use ($font, $size, $color, $align) {
            $f->filename($font);
            $f->size($size);
            $f->color($color);
            $f->align($align);
        });
    }

    private function drawMultiline($img, string $text, int $x, int $y, int $size = 22, int $lineHeight = 28, string $color = '#333333', string $align = 'center'): void
    {
        $lines = explode("\n", $text);
        foreach ($lines as $line) {
            $this->drawText($img, $line, $x, $y, $this->fontRegular, $size, $color, $align);
            $y += $lineHeight;
        }
    }

    private function wrap(string $text, int $width = 35): string
    {
        return wordwrap(Str::limit($text, 120), $width, "\n");
    }
}