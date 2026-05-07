<?php

namespace App\Mail;

use App\models\BillTour;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TourBookingMail extends Mailable
{
    use Queueable, SerializesModels;

    /** @var \App\models\BillTour */
    public $bill;

    /** @var string */
    public $tourTitle;

    /** @var string */
    public $servicesSummary;

    /** @var bool */
    public $customerCopy;

    public function __construct(BillTour $bill, string $tourTitle, bool $customerCopy = false)
    {
        $this->bill = $bill;
        $this->tourTitle = $tourTitle;
        $this->customerCopy = $customerCopy;
        $raw = (string) ($bill->service_id ?? '');
        $decoded = json_decode($raw, true);
        $this->servicesSummary = (json_last_error() === JSON_ERROR_NONE && is_array($decoded))
            ? implode(', ', $decoded)
            : $raw;
    }

    public function build()
    {
        if ($this->customerCopy) {
            return $this->subject('[Epic Travel] Confirmation of Receipt of Tour Booking Request')
                ->view('emails.tour_booking_customer');
        }

        return $this->subject('[Epic Travel] New Tour Booking Request #' . $this->bill->id)
            ->view('emails.tour_booking_admin');
    }
}
