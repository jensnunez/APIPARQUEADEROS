<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReportarMail extends Mailable
{
    use Queueable, SerializesModels;
    public $subject = 'Placa reportada';
    public $placa="";
    public $imagen="";

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($placa,$imagen)
    {
        $this->placa=  $placa;
        $this->imagen=  $imagen;

    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('correo');
    }
}
