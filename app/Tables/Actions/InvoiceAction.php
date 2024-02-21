<?php

namespace App\Tables\Actions;

use Carbon\CarbonInterface;
use Closure;
use Filament\Forms\Components\ViewField;
use Filament\Tables\Actions\Action;
use Spatie\LaravelPdf\Facades\Pdf;

class InvoiceAction extends Action
{
    const MODE_DOWNLOAD = 'download';
    const MODE_STREAM = 'stream';
    protected string|\Closure|null $firstParty = 'Seller';
    protected string|\Closure|null $secondParty = 'Buyer';
    protected array|\Closure|null $firstPartyDetails = [];
    protected array|\Closure|null $secondPartyDetails = [];
    protected string|\Closure|null $downloadName = 'invoice';


    protected string|\Closure|null $logo = null;

    protected string|\Closure|null $status = null;
    protected string|\Closure|null $serialNumber = 'AA.00001';

    protected string|CarbonInterface|\Closure|null $date = null;
    protected string|CarbonInterface|\Closure|null $dueDate = null;
    protected array|\Closure|null $invoiceItems = [];
    //HeadersAndColumns
    protected array|Closure|null $headersAndColumns = [];
    protected string $responseMode = self::MODE_DOWNLOAD;

    //Subtotal
    protected string|\Closure|null $subtotal = null;
    //Discount
    protected string|\Closure|null $discount = null;
    //TAX
    protected string|\Closure|null $tax = null;
    //Total
    protected string|\Closure|null $total = null;
    //Amount paid
    protected string|\Closure|null $amountPaid = null;
    //Balance due
    protected string|\Closure|null $balanceDue = null;

    //signature
    protected string|\Closure|null $signature = null;


    public function signature(string|\Closure|null $signature): static
    {
        $this->signature = $signature;
        return $this;
    }




    public function subTotal(string|\Closure|null $subTotal): static
    {
        $this->subtotal = $subTotal;
        return $this;
    }

    public function discount(string|\Closure|null $discount): static
    {
        $this->discount = $discount;
        return $this;
    }

    public function tax(string|\Closure|null $tax): static
    {
        $this->tax = $tax;
        return $this;
    }

    public function total(string|\Closure|null $total): static
    {
        $this->total = $total;
        return $this;
    }

    public function amountPaid(string|\Closure|null $amountPaid): static
    {
        $this->amountPaid = $amountPaid;
        return $this;
    }

    public function balanceDue(string|\Closure|null $balanceDue): static
    {
        $this->balanceDue = $balanceDue;
        return $this;
    }

    public function setHeadersAndColumns(array|Closure|null $headersAndColumns): static
    {
        $this->headersAndColumns = $headersAndColumns;
        return $this;
    }

    //Due date
    public function dueDate(string|CarbonInterface|\Closure|null $dueDate = null): static
    {
        $this->dueDate = $dueDate;
        return $this;
    }

    public function invoiceItems(array|Closure|null $invoiceItems): static
    {
        $this->invoiceItems = $invoiceItems;
        return $this;
    }

    public function date(string|CarbonInterface|\Closure|null $date = null): static
    {
        $this->date = $date;
        return $this;
    }

    public function serialNumber(string|\Closure|null $serialNumber): static
    {
        $this->serialNumber = $serialNumber;
        return $this;
    }

    public function status(string|\Closure|null $status): static
    {
        $this->status = $status;
        return $this;
    }

    public function logo(string|\Closure|null $logo): static
    {
        $this->logo = $logo;
        return $this;
    }

    public function responseMode(string $mode): static
    {
        if (!in_array($mode, [self::MODE_DOWNLOAD, self::MODE_STREAM])) {
            throw new \InvalidArgumentException('Invalid mode. Allowed modes are "' . self::MODE_DOWNLOAD . '" and "' . self::MODE_STREAM . '".');
        }
        $this->responseMode = $mode;
        return $this;
    }

    public function firstParty(string|\Closure|null $identifier, array|Closure $details = []): static
    {
        $this->firstParty = $identifier; // Store the identifier (e.g., 'seller')
        $this->firstPartyDetails = $details; // Store the details
        return $this;
    }

    public function secondParty(string|\Closure|null $identifier, array|Closure $details = []): static
    {
        $this->secondParty = $identifier; // Store the identifier (e.g., 'buyer')
        $this->secondPartyDetails = $details; // Store the details
        return $this;
    }



    //download name
    public function downloadName(string|\Closure|null $name): static
    {
        $this->downloadName = $name;
        return $this;
    }
    //table headers

    public function download(string|\Closure|null $name = null): static
    {
        $this->downloadName = $name ?? 'invoice'; // Use provided name, or default to 'invoice' if null.
        $this->responseMode = self::MODE_DOWNLOAD;
        $this->configureAction(); // Configure the action after setting the mode.
        return $this;
    }




    protected function configureAction(): void
    {
        if ($this->responseMode === self::MODE_STREAM) {
            // For stream mode, set the action to display a modal.
            $this
                ->extraAttributes(['style' => 'h-41'])
                ->modalFooterActions(
                    fn($action): array => [
                        $action->getModalCancelAction(),
                        //download
                        Action::make('Download')
                            ->translateLabel()
                            ->icon('tabler-download')
                            ->action($this->generateInvoice()),

                    ])
                ->fillForm(function () {
                    $invoiceObject = $this->collectInvoiceData();
                    $body = view('templates.default', ['invoice' => $invoiceObject])->render();

                    return [
                        'html_body' => $body,
                    ];
                })
                ->form([
                    ViewField::make('html_body')->hiddenLabel()
                        ->view('forms.components.html-invoice-view')
//                        ->view('filament-email::filament-email.emails.html')->view('filament-email::HtmlEmailView'),
                ]);
        } else {
            // For download mode, set the action to generate and download the invoice.
            $this->action('GenerateInvoice');
//                ->action($this->generateInvoice());
        }
    }

    public function action(Closure|string|null $action): static
    {
        if ($action !== 'GenerateInvoice') {
            throw new \Exception('You\'re unable to override the action for this plugin');
        }

        $this->action = $this->GenerateInvoice();

        return $this;
    }

    protected function generateInvoice(): Closure
    {
        return function () {
            $invoiceObject = $this->collectInvoiceData();
            $pdf = $this->createPdf($invoiceObject);

            // For download mode, return the download response.
            return $this->downloadResponse($pdf);
        };
    }

    protected function collectInvoiceData(): object
    {


        $defaultDetails = [
            'name' => null,
            'address' => null,
            'code' => null,
            'vat' => null,
            'phone' => null,
            'custom_fields' => [],
        ];


        // Merge provided details with defaults to ensure all properties exist
        $firstPartyDetails = array_merge($defaultDetails, (array)$this->evaluate($this->firstPartyDetails));
        $secondPartyDetails = array_merge($defaultDetails, (array)$this->evaluate($this->secondPartyDetails));
        $items = $this->evaluate($this->invoiceItems);


        $invoiceData = [
            'name' => $this->evaluate($this->downloadName),
            'firstParty' => $this->evaluate($this->firstParty),
            'secondParty' => $this->evaluate($this->secondParty),
            'firstPartyDetails' => (object)$firstPartyDetails,
            'secondPartyDetails' => (object)$secondPartyDetails,
            'logo' => $this->evaluate($this->logo),
            'status' => $this->evaluate($this->status),
            'serialNumber' => $this->evaluate($this->serialNumber),
            'date' => $this->evaluate($this->date ?? fn() => now()),
            'dueDate' => $this->evaluate($this->dueDate),
            'items' => is_iterable($items) ? collect($items)->chunk(17) : collect([$items])->chunk(17),
            'currentChunkIndex' => 0, // initialize as 0
            'totalChunks' => is_iterable($items) ? ceil(count($items) / 17) : 1,
            'headersAndColumns' => $this->evaluate($this->headersAndColumns) ?? ['Description', 'Units', 'Qty', 'Price', 'Discount', 'Sub total'],
            'subtotal' => $this->evaluate($this->subtotal),
            'discount' => $this->evaluate($this->discount),
            'tax' => $this->evaluate($this->tax),
            'total' => $this->evaluate($this->total),
            'amountPaid' => $this->evaluate($this->amountPaid),
            'balanceDue' => $this->evaluate($this->balanceDue),
            'signature' => $this->evaluate($this->signature),
        ];

        return (object)$invoiceData;
    }

    private function createPdf($invoiceObject)
    {
        return Pdf::view('templates.default', ['invoice' => $invoiceObject])->paperSize(210, 296);
    }

    private function downloadResponse($pdf)
    {
        $filename = $this->evaluate($this->downloadName) . '.pdf'; // Evaluate the name, which could be a Closure or string.
        $pdf->save($filename);
        return response()->download($filename)->deleteFileAfterSend(true);
    }

    public function stream(): static
    {
        $this->responseMode = self::MODE_STREAM;
        $this->configureAction(); // Configure the action after setting the mode.
        return $this;
    }

    private function streamResponse(): Closure
    {
        // Return a closure that generates the view with the invoice data.
        return function () {
            return view('templates.default', ['invoice' => $this->collectInvoiceData()]);
        };
    }

//    protected function setUp(): void
//    {
//        parent::setUp();
//
//    }


}

