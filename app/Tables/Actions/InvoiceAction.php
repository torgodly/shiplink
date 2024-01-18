<?php

namespace App\Tables\Actions;

use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\CarbonInterface;
use Closure;
use Filament\Support\View\Components\Modal;
use Filament\Tables\Actions\Action;
use Symfony\Component\HttpFoundation\StreamedResponse;

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
    protected array|\Closure|null $invoiceItems = [];
    protected string $responseMode = self::MODE_DOWNLOAD;

    public function invoiceItems(array|Closure|null $invoiceItems): static
    {
        $this->invoiceItems = $invoiceItems;
        return $this;
    }

    public function date(string|CarbonInterface|\Closure|Modal|null $date = null): static
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

    public function firstParty(string|\Closure|null $identifier, array $details = []): static
    {
        $this->firstParty = $identifier; // Store the identifier (e.g., 'seller')
        $this->firstPartyDetails = $details; // Store the details
        return $this;
    }

    public function secondParty(string|\Closure|null $identifier, array $details = []): static
    {
        $this->secondParty = $identifier; // Store the identifier (e.g., 'buyer')
        $this->secondPartyDetails = $details; // Store the details
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
            $this->modalContent($this->streamResponse());
        } else {
            // For download mode, set the action to generate and download the invoice.
            $this->action('GenerateInvoice');
//                ->action($this->generateInvoice());
        }
    }

    private function streamResponse(): Closure
    {
        // Return a closure that generates the view with the invoice data.
        return function () {
            return view('welcome', ['invoice' => $this->collectInvoiceData()]);
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
            'items' => is_iterable($items) ? $items : [$items],
        ];

        return (object)$invoiceData;
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

    private function createPdf($invoiceObject): \Barryvdh\DomPDF\PDF
    {
        return Pdf::loadView('welcome', ['invoice' => $invoiceObject]);
    }

    private function downloadResponse($pdf): StreamedResponse
    {
        $filename = $this->evaluate($this->downloadName) . '.pdf'; // Evaluate the name, which could be a Closure or string.
        return new StreamedResponse(function () use ($pdf) {
            echo $pdf->output();
        }, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    public function stream(): static
    {
        $this->responseMode = self::MODE_STREAM;
        $this->configureAction(); // Configure the action after setting the mode.
        return $this;
    }

//    protected function setUp(): void
//    {
//        parent::setUp();
//
//    }


}

