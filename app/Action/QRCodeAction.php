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
            ->modalContent(fn(Model $record) => Qr::render($record->code, statePath: $record->code))
            ->icon('tabler-qrcode')
            ->label('QR Code')
            ->translateLabel()
            ->modalCancelAction(false)
            ->modalSubmitAction(false);

    }
}
