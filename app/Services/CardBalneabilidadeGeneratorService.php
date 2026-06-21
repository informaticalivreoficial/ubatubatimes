<?php

namespace App\Services;

use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Interfaces\ImageInterface;
use Intervention\Image\Typography\FontFactory;

class CardBalneabilidadeGeneratorService
{
    /**
     * Posições (x, y) de cada valor no template 1024x1024.
     * x é onde o valor começa a ser escrito (logo após o rótulo "Resultados:" etc).
     * y é a posição vertical, alinhada com a linha de base de cada rótulo.
     *
     * Ajuste estes valores conforme o template real — foram calibrados
     * visualmente a partir do card de exemplo enviado.
     */
    private const POSITIONS = [
        'resultados' => ['x' => 839, 'y' => 126],
        'proprias'   => ['x' => 790, 'y' => 204],
        'improprias' => ['x' => 838, 'y' => 252],
        'resumo'     => ['x' => 638, 'y' => 320],
        'data'       => ['x' => 717, 'y' => 802],
    ];

    public function __construct(
        private ImageManager $imageManager
    ) {}

    public function make(array $data, string $template = 'card-balneabilidade.png'): string
    {
        $templatePath = storage_path("app/templates/{$template}");

        if (!file_exists($templatePath)) {
            throw new \Exception("Template não encontrado: {$templatePath}");
        }

        $image = $this->imageManager->read($templatePath);

        $this->drawValue($image, (string) ($data['resultados'] ?? '-'), self::POSITIONS['resultados'], 32);
        $this->drawValue($image, (string) ($data['proprias'] ?? '-'), self::POSITIONS['proprias'], 32);
        $this->drawValue($image, (string) ($data['improprias'] ?? '-'), self::POSITIONS['improprias'], 32);
        $this->drawValue($image, (string) ($data['ultima_atualizacao'] ?? '-'), self::POSITIONS['data'], 28);

        if (!empty($data['message'])) {
            $this->drawResumo($image, $data['message'], self::POSITIONS['resumo']);
        }

        $fileName = Str::uuid() . '.png';
        $relativePath = "cards/{$fileName}";
        $fullPath = storage_path("app/public/{$relativePath}");

        if (!is_dir(dirname($fullPath))) {
            mkdir(dirname($fullPath), 0755, true);
        }

        $image->save($fullPath);

        return asset("storage/{$relativePath}");
    }

    /**
     * Desenha um único valor (número ou data) na posição indicada,
     * alinhado à esquerda a partir do ponto x (logo após o rótulo).
     */
    private function drawValue(ImageInterface $image, string $text, array $position, int $size = 32): void
    {
        $image->text($text, $position['x'], $position['y'], function (FontFactory $font) use ($size) {
            $font->filename(public_path('fonts/Inter-Bold.ttf'));
            $font->size($size);
            $font->color('#1e293b'); // slate-800, mesmo tom escuro dos rótulos no card
            $font->align('left');
            $font->valign('middle');
        });
    }

    /**
     * Desenha o texto-resumo (ex: "✅ Nenhuma praia está imprópria..." ou
     * "⚠️ Hoje as praias X, Y estão impróprias...") com quebra automática
     * de linha, já que o tamanho varia bastante conforme a quantidade
     * de praias impróprias listadas.
     */
    private function drawResumo(ImageInterface $image, string $text, array $position): void
    {
        $image->text($text, $position['x'], $position['y'], function (FontFactory $font) {
            $font->filename(public_path('fonts/Inter-Bold.ttf'));
            $font->size(26);
            $font->color('#1e293b');
            $font->align('left');
            $font->valign('top');
            $font->lineHeight(2);
            $font->wrap(330); // largura máxima em pixels antes de quebrar linha (ajuste conforme o card)
        });
    }
}