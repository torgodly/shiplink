<?php

namespace App\Tables\Actions;

use Barryvdh\DomPDF\Facade\Pdf;
use Closure;
use Filament\Tables\Actions\Action;
use Symfony\Component\HttpFoundation\StreamedResponse;

class InvoiceAction extends Action
{
    const MODE_DOWNLOAD = 'download';
    const MODE_STREAM = 'stream';
    protected string|\Closure|null $firstParty = 'Seller';
    protected string|\Closure|null $secondParty = 'Buyer';
    protected string $responseMode = self::MODE_DOWNLOAD;

    public function responseMode(string $mode): static
    {
        if (!in_array($mode, [self::MODE_DOWNLOAD, self::MODE_STREAM])) {
            throw new \InvalidArgumentException('Invalid mode. Allowed modes are "' . self::MODE_DOWNLOAD . '" and "' . self::MODE_STREAM . '".');
        }
        $this->responseMode = $mode;
        return $this;
    }

    public function firstParty(string|\Closure|null $firstParty): static
    {
        $this->firstParty = $firstParty;
        return $this;
    }

    public function secondParty(string|\Closure|null $secondParty): static
    {
        $this->secondParty = $secondParty;
        return $this;
    }

    public function download(): static
    {
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
        $invoiceData = [
            'firstParty' => $this->evaluate($this->firstParty),
            'secondParty' => $this->evaluate($this->secondParty),
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
        return new StreamedResponse(function () use ($pdf) {
            echo $pdf->output();
        }, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="invoice.pdf"',
        ]);
    }

    public function stream(): static
    {
        $this->responseMode = self::MODE_STREAM;
        $this->configureAction(); // Configure the action after setting the mode.
        return $this;
    }

    protected function setUp(): void
    {
        parent::setUp();

    }
}

