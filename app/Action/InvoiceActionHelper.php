<?php

namespace App\Action;

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
            ->serialNumber(fn(Package $record) => $record->code)
            ->date(fn(Package $record) => $record->created_at->format('Y-m-d'))
            ->logo(asset('images/logo.png'))
            ->invoiceItems(fn(Package $record) => $record)
            ->setHeadersAndColumns(['code' => 'Package Code', 'weight' => 'Weight', 'price' => 'Price',])
            ->subTotal(fn(Package $record) => $record->price.' د.ل ')
            ->amountPaid(fn(Package $record) => $record->price.' د.ل ')
            ->balanceDue('0'.' د.ل ')
            ->total(fn(Package $record) => $record->price.' د.ل ')
            ->signature(fn(Package $record) => $record->signature)
            ->downloadName(fn(Package $record) => $record->code . '-invoice')
            ;
    }
}
