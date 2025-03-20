<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderReadyMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;

    public function __construct($order)
    {
        $this->order = $order;
    }

    public function build()
    {
        $pdf = PDF::loadView('emails.order-invoice', ['order' => $this->order]);
        
        return $this->subject('Votre commande est prête - Facture')
                    ->view('emails.order-ready')
                    ->attachData($pdf->output(), 'facture.pdf');
    }
} 