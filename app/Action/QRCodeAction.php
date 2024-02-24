<?php

namespace App\Action;

use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Model;
use LaraZeus\Qr\Facades\Qr;

class QRCodeAction
{
    public static function QrCodeAction()
    {
        return Action::make('qr')
            ->modalContent(fn(Model $record) => Qr::render($record->code, options: [
            'size' => '300',
            'margin' => '1',
            'color' => 'rgba(27, 61, 212, 1)',
            'back_color' => 'rgba(252, 252, 252, 1)',
            'style' => 'round',
            'hasGradient' => false,
            'gradient_form' => 'rgb(69, 179, 157)',
            'gradient_to' => 'rgb(241, 148, 138)',
            'gradient_type' => 'vertical',
            'hasEyeColor' => true,
            'eye_color_inner' => 'rgb(255, 234, 41)',
            'eye_color_outer' => 'rgb(255, 234, 41)',
            'eye_style' => 'circle',
        ], statePath: $record->code))->icon('tabler-qrcode')->label('QR Code')->translateLabel()->modalCancelAction(false)->modalSubmitAction(false);

    }
}
