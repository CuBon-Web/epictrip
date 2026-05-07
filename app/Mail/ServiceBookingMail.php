<?php

namespace App\Mail;

use App\models\ServiceBooking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ServiceBookingMail extends Mailable
{
    use Queueable, SerializesModels;

    /** @var \App\models\ServiceBooking */
    public $booking;

    /** @var string */
    public $serviceTitle;

    /** @var bool */
    public $customerCopy;

    public function __construct(ServiceBooking $booking, string $serviceTitle, bool $customerCopy = false)
    {
        $this->booking = $booking;
        $this->serviceTitle = $serviceTitle;
        $this->customerCopy = $customerCopy;
    }

    public function build()
    {
        if ($this->customerCopy) {
            return $this->subject('[' . config('app.name') . '] Đã nhận yêu cầu đặt dịch vụ của bạn')
                ->view('emails.service_booking_customer');
        }

        return $this->subject('[' . config('app.name') . '] Đặt dịch vụ mới #' . $this->booking->id)
            ->view('emails.service_booking_admin');
    }
}
