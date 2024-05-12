<?php

namespace App\Mail;

use App\Models\Court;
use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Queue\SerializesModels;

class ReservationConfirmed extends Mailable
{
    use Queueable, SerializesModels;
    public Reservation $reservation;
    public $courtName;
    public $courtSurface;

    /**
     * Create a new message instance.
     */
    public function __construct(Reservation $reservation)
    {
        $this->reservation = $reservation;
        $court = Court::find($reservation->court_id);
        $this->courtName = $court->name;
        $this->courtSurface = $court->surface;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('admin@tenisso.pl', 'TENISSO'),
            subject: 'TENNISO - Dziękujemy za rezerwację!',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.reservation.confirmed',
            with: [
                'reservation' => $this->reservation,
                'court_name' => $this->courtName,
                'court_surface' => $this->courtSurface
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
