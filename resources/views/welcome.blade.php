<!DOCTYPE html>
<html lang="en">
<head>
    <title>{{ $invoice->name }}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <style type="text/css" media="screen">
        html {
            font-family: sans-serif;
            line-height: 1.15;
            margin: 0;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
            font-weight: 400;
            line-height: 1.5;
            color: #212529;
            text-align: left;
            background-color: #fff;
            font-size: 10px;
            margin: 36pt;
        }

        h4 {
            margin-top: 0;
            margin-bottom: 0.5rem;
        }

        p {
            margin-top: 0;
            margin-bottom: 1rem;
        }

        strong {
            font-weight: bolder;
        }

        img {
            vertical-align: middle;
            border-style: none;
        }

        table {
            border-collapse: collapse;
        }

        th {
            text-align: inherit;
        }

        h4, .h4 {
            margin-bottom: 0.5rem;
            font-weight: 500;
            line-height: 1.2;
        }

        h4, .h4 {
            font-size: 1.5rem;
        }

        .table {
            width: 100%;
            margin-bottom: 1rem;
            color: #212529;
        }

        .table th,
        .table td {
            padding: 0.75rem;
            vertical-align: top;
        }

        .table.table-items td {
            border-top: 1px solid #dee2e6;
        }

        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #dee2e6;
        }

        .mt-5 {
            margin-top: 3rem !important;
        }

        .pr-0,
        .px-0 {
            padding-right: 0 !important;
        }

        .pl-0,
        .px-0 {
            padding-left: 0 !important;
        }

        .text-right {
            text-align: right !important;
        }

        .text-center {
            text-align: center !important;
        }

        .text-uppercase {
            text-transform: uppercase !important;
        }

        * {
            font-family: "DejaVu Sans";
        }

        body, h1, h2, h3, h4, h5, h6, table, th, tr, td, p, div {
            line-height: 1.1;
        }

        .party-header {
            font-size: 1.5rem;
            font-weight: 400;
        }

        .total-amount {
            font-size: 12px;
            font-weight: 700;
        }

        .border-0 {
            border: none !important;
        }

        .cool-gray {
            color: #6B7280;
        }
    </style>
</head>

<body>
{{-- Header --}}
@if($invoice->logo)
    <img src="{{ $invoice->logo }}" alt="logo" height="100">
@endif

<table class="table mt-5">
    <tbody>
    <tr>
        <td class="border-0 pl-0" width="70%">
            <h4 class="text-uppercase">
                <strong>{{ $invoice->name }}</strong>
            </h4>
        </td>
        <td class="border-0 pl-0">
            @if($invoice->status)
                <h4 class="text-uppercase cool-gray">
                    <strong>{{ $invoice->status }}</strong>
                </h4>
            @endif
            <p>{{ __('Serial No.') }} <strong>{{ $invoice->serialNumber }}</strong></p>
            <p>{{ __('Date') }}: <strong>{{ $invoice->date }}</strong></p>
        </td>
    </tr>
    </tbody>
</table>

<table class="table">
    <thead>
    <tr>
        <th class="border-0 pl-0 party-header" width="48.5%">
            {{ $invoice->firstParty }}
        </th>
        <th class="border-0" width="3%"></th>
        <th class="border-0 pl-0 party-header">
            {{ $invoice->secondParty }}
        </th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td class="px-0">
            @if($invoice->firstPartyDetails->name)
                <p class="firstParty-name">
                    <strong>{{ $invoice->firstPartyDetails->name }}</strong>
                </p>
            @endif

            @if($invoice->firstPartyDetails->address)
                <p class="firstParty-address">
                    {{ __('invoices::invoice.address') }}: {{ $invoice->firstPartyDetails->address }}
                </p>
            @endif

            @if($invoice->firstPartyDetails->code)
                <p class="firstParty-code">
                    {{ __('invoices::invoice.code') }}: {{ $invoice->firstPartyDetails->code }}
                </p>
            @endif

            @if($invoice->firstPartyDetails->vat)
                <p class="firstParty-vat">
                    {{ __('invoices::invoice.vat') }}: {{ $invoice->firstPartyDetails->vat }}
                </p>
            @endif

            @if($invoice->firstPartyDetails->phone)
                <p class="firstParty-phone">
                    {{ __('invoices::invoice.phone') }}: {{ $invoice->firstPartyDetails->phone }}
                </p>
            @endif

            @foreach($invoice->firstPartyDetails->custom_fields as $key => $value)
                <p class="firstParty-custom-field">
                    {{ ucfirst($key) }}: {{ $value }}
                </p>
            @endforeach
        </td>
        <td class="border-0"></td>
        <td class="px-0">
            @if($invoice->secondPartyDetails->name)
                <p class="secondParty-name">
                    <strong>{{ $invoice->secondPartyDetails->name }}</strong>
                </p>
            @endif

            @if($invoice->secondPartyDetails->address)
                <p class="secondParty-address">
                    {{ __('invoices::invoice.address') }}: {{ $invoice->secondPartyDetails->address }}
                </p>
            @endif

            @if($invoice->secondPartyDetails->code)
                <p class="secondParty-code">
                    {{ __('invoices::invoice.code') }}: {{ $invoice->secondPartyDetails->code }}
                </p>
            @endif

            @if($invoice->secondPartyDetails->vat)
                <p class="secondParty-vat">
                    {{ __('invoices::invoice.vat') }}: {{ $invoice->secondPartyDetails->vat }}
                </p>
            @endif

            @if($invoice->secondPartyDetails->phone)
                <p class="secondParty-phone">
                    {{ __('invoices::invoice.phone') }}: {{ $invoice->secondPartyDetails->phone }}
                </p>
            @endif

            @foreach($invoice->secondPartyDetails->custom_fields as $key => $value)
                <p class="secondParty-custom-field">
                    {{ ucfirst($key) }}: {{ $value }}
                </p>
            @endforeach
        </td>
    </tr>
    </tbody>

    <table class="table table-items">
        <thead>
        <tr>
            <th scope="col" class="border-0 pl-0">{{ __('invoices::invoice.description') }}</th>
            @if($invoice->hasItemUnits)
                <th scope="col" class="text-center border-0">{{ __('invoices::invoice.units') }}</th>
            @endif
            <th scope="col" class="text-center border-0">{{ __('invoices::invoice.quantity') }}</th>
            <th scope="col" class="text-right border-0">{{ __('invoices::invoice.price') }}</th>
            @if($invoice->hasItemDiscount)
                <th scope="col" class="text-right border-0">{{ __('invoices::invoice.discount') }}</th>
            @endif
            @if($invoice->hasItemTax)
                <th scope="col" class="text-right border-0">{{ __('invoices::invoice.tax') }}</th>
            @endif
            <th scope="col" class="text-right border-0 pr-0">{{ __('invoices::invoice.sub_total') }}</th>
        </tr>
        </thead>
        <tbody>
        {{-- Items --}}
        @foreach($invoice->items as $item)
            <tr>
                <td class="pl-0">
                    {{ $item->title }}

                    @if($item->description)
                        <p class="cool-gray">{{ $item->description }}</p>
                    @endif
                </td>
                @if($invoice->hasItemUnits)
                    <td class="text-center">{{ $item->units }}</td>
                @endif
                <td class="text-center">{{ $item->quantity }}</td>
                <td class="text-right">
                    {{ $invoice->formatCurrency($item->price_per_unit) }}
                </td>
                @if($invoice->hasItemDiscount)
                    <td class="text-right">
                        {{ $invoice->formatCurrency($item->discount) }}
                    </td>
                @endif
                @if($invoice->hasItemTax)
                    <td class="text-right">
                        {{ $invoice->formatCurrency($item->tax) }}
                    </td>
                @endif

                <td class="text-right pr-0">
                    {{ $invoice->formatCurrency($item->sub_total_price) }}
                </td>
            </tr>
        @endforeach
        {{-- Summary --}}
        @if($invoice->hasItemOrInvoiceDiscount())
            <tr>
                <td colspan="{{ $invoice->table_columns - 2 }}" class="border-0"></td>
                <td class="text-right pl-0">{{ __('invoices::invoice.total_discount') }}</td>
                <td class="text-right pr-0">
                    {{ $invoice->formatCurrency($invoice->total_discount) }}
                </td>
            </tr>
        @endif
        @if($invoice->taxable_amount)
            <tr>
                <td colspan="{{ $invoice->table_columns - 2 }}" class="border-0"></td>
                <td class="text-right pl-0">{{ __('invoices::invoice.taxable_amount') }}</td>
                <td class="text-right pr-0">
                    {{ $invoice->formatCurrency($invoice->taxable_amount) }}
                </td>
            </tr>
        @endif
        @if($invoice->tax_rate)
            <tr>
                <td colspan="{{ $invoice->table_columns - 2 }}" class="border-0"></td>
                <td class="text-right pl-0">{{ __('invoices::invoice.tax_rate') }}</td>
                <td class="text-right pr-0">
                    {{ $invoice->tax_rate }}%
                </td>
            </tr>
        @endif
        @if($invoice->hasItemOrInvoiceTax())
            <tr>
                <td colspan="{{ $invoice->table_columns - 2 }}" class="border-0"></td>
                <td class="text-right pl-0">{{ __('invoices::invoice.total_taxes') }}</td>
                <td class="text-right pr-0">
                    {{ $invoice->formatCurrency($invoice->total_taxes) }}
                </td>
            </tr>
        @endif
        @if($invoice->shipping_amount)
            <tr>
                <td colspan="{{ $invoice->table_columns - 2 }}" class="border-0"></td>
                <td class="text-right pl-0">{{ __('invoices::invoice.shipping') }}</td>
                <td class="text-right pr-0">
                    {{ $invoice->formatCurrency($invoice->shipping_amount) }}
                </td>
            </tr>
        @endif
        <tr>
            <td colspan="{{ $invoice->table_columns - 2 }}" class="border-0"></td>
            <td class="text-right pl-0">{{ __('invoices::invoice.total_amount') }}</td>
            <td class="text-right pr-0 total-amount">
                {{ $invoice->formatCurrency($invoice->total_amount) }}
            </td>
        </tr>
        </tbody>
    </table>
</table>
</body>
</html>
