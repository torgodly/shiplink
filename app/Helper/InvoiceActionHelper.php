<?php

namespace App\Helper;

use App\Models\Package;
use App\Tables\Actions\InvoiceAction;

class InvoiceActionHelper
{

    public static function setupInvoiceAction()
    {
        return InvoiceAction::make('Invoice')
            ->translateLabel()
            ->icon('tabler-file-invoice')
            ->firstParty('Sender', fn(Package $record) => $record->SenderInfo)
            ->secondParty('Recipient', fn(Package $record) => $record->ReceiverInfo)
            ->status('Paid')
            ->serialNumber('215478')
            ->date(now()->format('Y-m-d'))
            ->logo(asset('images/logo.png'))
            ->invoiceItems(fn(Package $record) => $record)
            ->setHeadersAndColumns(['code' => 'Package Code', 'weight' => 'Weight', 'price' => 'Price',])
            ->subTotal(fn(Package $record) => $record->price)
            ->amountPaid(fn(Package $record) => $record->price)
            ->balanceDue('0')
            ->total(fn(Package $record) => $record->price)
            ->signature(fn(Package $record) => $record->signature);
    }
}
