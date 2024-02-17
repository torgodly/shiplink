<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      dir="{{ config('locales')[app()->getLocale()]['dir'] ?? 'ltr' }}">
<head>
    <meta charset="UTF-8">
    {{--    <meta name="viewport"--}}
    <meta name="viewport" content="width=1024">
    {{--    <meta http-equiv="X-UA-Compatible" content="ie=edge">--}}
    <title>{{__('Invoice')}}</title>
    <style>

        @page {
            {{--size: {{ $attributes->has('size') ? $attributes->get('size') : $size }};--}}
                                                            size: A4;
            margin: 0;
        }

        body {
            margin: 0;
            min-width: initial !important
        }

        .sheet {
            margin: 0;
            overflow: hidden;
            position: relative;
            box-sizing: border-box;
            /*page-break-after: always*/
        }

        /** Paper sizes **/
        body.A3 .sheet {
            width: 297mm;
            height: 419mm
        }

        body.A3_landscape .sheet {
            width: 420mm;
            height: 296mm
        }

        body.A4 .sheet {
            /*width: 210mm;*/
            height: 296mm
        }

        body.A4_landscape .sheet {
            width: 297mm;
            height: 209mm
        }

        body.A5 .sheet {
            width: 148mm;
            height: 209mm
        }

        body.A5_landscape .sheet {
            width: 210mm;
            height: 147mm
        }

        body.card .sheet {
            width: 86mm;
            height: 54mm
        }

        /** Fix Chrome Issue **/
        @media print {
            body.A3 {
                width: 297mm
            }

            body.A3_landscape {
                width: 420mm
            }

            body.A4 {
                width: 210mm
            }

            body.A4_landscape {
                width: 297mm
            }

            body.A5 {
                width: 148mm
            }

            body.A5_landscape {
                width: 210mm
            }

            body.card {
                width: 86mm
            }
        }

        /** Padding area **/
        .sheet.padding-0mm {
            padding: 0mm
        }

        .sheet.padding-5mm {
            padding: 5mm
        }

        .sheet.padding-10mm {
            padding: 10mm
        }

        .sheet.padding-15mm {
            padding: 15mm
        }

        .sheet.padding-20mm {
            padding: 20mm
        }

        .sheet.padding-25mm {
            padding: 25mm
        }

        /** For screen preview **/
        @media screen {
            body {
                background: #e0e0e0
            }

            .sheet {
                background: white;
                box-shadow: 0 .5mm 2mm rgba(0, 0, 0, .3);
                margin: 5mm;
            }
        }
    </style>

    <script src="https://cdn.tailwindcss.com"></script>

</head>
<body class="bg-gray-50 A4">
<!-- Invoice -->

<div class="max-w-[85rem]">
    <div class="lg:w-3/4 mx-auto">
        <!-- Card -->
        @foreach($invoice->items as $items)
            <div class="flex flex-col p-4 sm:p-10 bg-white shadow-md rounded-xl  sheet">
                <!-- Grid -->
                <div class="flex justify-between">
                    <h2 class="text-2xl md:text-3xl font-semibold text-gray-800 ">{{__('Invoice #')}}</h2>

                    <h4 class="uppercase text-gray-400 text-2xl">
                        <strong>{{ $invoice->status }}</strong>
                    </h4>
                </div>
                <div class="flex justify-between">
                    <div class="mt-3">
                        @if($invoice->logo)

                            <img class="h-[2.5rem]" src="{{$invoice->logo}}" alt="logo">
                        @endif

                    </div>
                    <!-- Col -->

                    <div class="text-end">

                        @if($invoice->status)
                        @endif
                        <span class="mt-1 block text-gray-800">{{__('Serial No.')}} {{ $invoice->serialNumber }}</span>
                        <span class="mt-1 block text-gray-800">{{__('Invoice date:')}} {{ $invoice->date }}</span>
                        @if($invoice->dueDate)
                            <span class="mt-1 block text-gray-800">{{__('Due date:')}} {{ $invoice->dueDate }}</span>
                        @endif
                    </div>
                    <!-- Col -->
                </div>
                <!-- End Grid -->

                <!-- Grid -->
                <div class="mt-8 grid sm:grid-cols-2 gap-3">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 ">{{__($invoice->firstParty)}}</h3>
                        @if($invoice->firstPartyDetails->name)
                            @if($invoice->firstPartyDetails->name instanceof Closure)
                                <h3 class="text-base font-semibold text-gray-800 ">{{ $invoice->firstPartyDetails->name() }}</h3>
                            @else
                                <h3 class="text-base font-semibold text-gray-800 ">{{ $invoice->firstPartyDetails->name }}</h3>
                            @endif
                        @endif
                        @if($invoice->firstPartyDetails->address)
                            <p class="seller-address">
                                {{ __('Address') }}: {{ $invoice->firstPartyDetails->address }}
                            </p>
                        @endif
                        @if($invoice->firstPartyDetails->code)
                            <p class="firstPartyDetails-code">
                                {{ __('Code') }}: {{ $invoice->firstPartyDetails->code }}
                            </p>
                        @endif

                        @if($invoice->firstPartyDetails->vat)
                            <p class="firstPartyDetails-vat">
                                {{ __('Vat') }}: {{ $invoice->firstPartyDetails->vat }}
                            </p>
                        @endif

                        @if($invoice->firstPartyDetails->phone)
                            <p class="firstPartyDetails-phone">
                                {{ __('Phone') }}: {{ $invoice->firstPartyDetails->phone }}
                            </p>
                        @endif

                        @foreach($invoice->firstPartyDetails->custom_fields as $key => $value)
                            <p class="firstPartyDetails-custom-field uppercase">
                                {{ __($key) }}: {{ $value }}
                            </p>
                        @endforeach
                    </div>
                    <!-- Col -->

                    <div class="sm:text-end space-y-2">
                        <!-- Grid -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 ">{{__($invoice->secondParty)}}</h3>
                            @if($invoice->secondPartyDetails->name)
                                <h3 class="text-base font-semibold text-gray-800 ">{{$invoice->secondPartyDetails->name}}</h3>
                            @endif
                            @if($invoice->secondPartyDetails->address)
                                <p class="seller-address">
                                    {{ __('Address') }}: {{ $invoice->secondPartyDetails->address }}
                                </p>
                            @endif
                            @if($invoice->secondPartyDetails->code)
                                <p class="secondPartyDetails-code">
                                    {{ __('Code') }}: {{ $invoice->secondPartyDetails->code }}
                                </p>
                            @endif

                            @if($invoice->secondPartyDetails->vat)
                                <p class="secondPartyDetails-vat">
                                    {{ __('Vat') }}: {{ $invoice->secondPartyDetails->vat }}
                                </p>
                            @endif

                            @if($invoice->secondPartyDetails->phone)
                                <p class="secondPartyDetails-phone">
                                    {{ __('Phone') }}: {{ $invoice->secondPartyDetails->phone }}
                                </p>
                            @endif

                            @foreach($invoice->secondPartyDetails->custom_fields as $key => $value)
                                <p class="secondPartyDetails-custom-field capitalize">
                                    {{ __($key) }}: {{ $value }}
                                </p>
                            @endforeach
                        </div>
                        <!-- End Grid -->
                    </div>
                    <!-- Col -->
                </div>
                <!-- End Grid -->

                <!-- Table -->
                <div class="mt-6">
                    <div class="border border-gray-200 p-4 rounded-lg space-y-4">
                        <table class="min-w-full">
                            <thead class="hidden sm:table-header-group">
                            <tr class="border-b border-gray-200">
                                @foreach($invoice->headersAndColumns as $column => $header)
                                    <th class="p-2 text-xs font-medium text-gray-500 uppercase text-start">{{ __($header) }}</th>
                                @endforeach
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($items as $item)
                                <tr class="border-b border-gray-200 sm:border-none">
                                    @foreach($invoice->headersAndColumns as $column => $header)
                                        <td class="p-2">
                                            <h5 class="sm:hidden text-xs font-medium text-gray-500 uppercase">{{$header}}</h5>
                                            <p class="font-medium text-gray-800">{{$item->{$column} }}</p>
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- End Table -->


                <!-- Flex -->
                <div class="mt-8 flex sm:justify-end">
                    <div class="w-full max-w-2xl sm:text-end space-y-2">
                        <!-- Grid -->
                        <div class="grid grid-cols-2 sm:grid-cols-1 gap-3 sm:gap-2">
                            @if($invoice->subtotal)

                                <dl class="grid sm:grid-cols-5 gap-x-3">
                                    <dt class="col-span-3 font-semibold text-gray-800 ">{{__('Subtotal:')}}</dt>
                                    <dd class="col-span-2 text-gray-500">{{$invoice->subtotal}}</dd>
                                </dl>
                            @endif

                            @if($invoice->discount)

                                <dl class="grid sm:grid-cols-5 gap-x-3">
                                    <dt class="col-span-3 font-semibold text-gray-800 ">{{__('Discount:')}}</dt>
                                    <dd class="col-span-2 text-gray-500">{{$invoice->discount}}</dd>
                                </dl>
                            @endif

                            @if($invoice->tax)

                                <dl class="grid sm:grid-cols-5 gap-x-3">
                                    <dt class="col-span-3 font-semibold text-gray-800 ">{{__('Tax:')}}</dt>
                                    <dd class="col-span-2 text-gray-500">{{$invoice->tax}}</dd>
                                </dl>

                            @endif

                            @if($invoice->total)

                                <dl class="grid sm:grid-cols-5 gap-x-3">
                                    <dt class="col-span-3 font-semibold text-gray-800 ">{{__('Total:')}}</dt>
                                    <dd class="col-span-2 text-gray-500">{{$invoice->total}}</dd>
                                </dl>

                            @endif
                            @if($invoice->amountPaid)

                                <dl class="grid sm:grid-cols-5 gap-x-3">
                                    <dt class="col-span-3 font-semibold text-gray-800 ">{{__('Amount Paid:')}}</dt>
                                    <dd class="col-span-2 text-gray-500">{{$invoice->amountPaid}}</dd>
                                </dl>
                            @endif

                            @if($invoice->balanceDue)

                                <dl class="grid sm:grid-cols-5 gap-x-3">
                                    <dt class="col-span-3 font-semibold text-gray-800 ">{{__('Due balance:')}}</dt>
                                    <dd class="col-span-2 text-gray-500">{{$invoice->balanceDue}}</dd>
                                </dl>
                            @endif

                        </div>
                        <!-- End Grid -->
                    </div>
                </div>
                <!-- End Flex -->


                <div class="mt-8 sm:mt-12">


                    <h4 class="text-lg font-semibold text-gray-800 ">{{__('Thank you!')}}</h4>
                    <p class="text-gray-500">{{__("If you have any questions concerning this invoice, use the following contact information:")}}</p>
                    <div class="mt-2">
                        <p class="block text-sm font-medium text-gray-800 ">info@Shiplink.ly</p>
                        <p class="block text-sm font-medium text-gray-800 ">091-111-1111</p>
                    </div>
                </div>

                <div class="flex justify-between md:flex-row flex-col gap-10 md:gap-0">
                    <p class="mt-5 text-sm text-gray-500">© {{now()->year}} ShipLink.</p>

                    @if($invoice->signature)
                        <div class="signature-area flex items-center">
                            <p class="relative" style="line-height: 1;">
                                {{__('Signature:')}} _______________________
                                <img class="absolute w-96 ml-2 bottom-[-32px] right-[25px]"
                                     src="{{$invoice->signature}}"
                                     style="vertical-align: middle;">
                            </p>

                        </div>
                    @endif


                </div>
            </div>

        @endforeach
        <!-- End Card -->
    </div>
</div>
<!-- End Invoice -->
</body>
</html>
