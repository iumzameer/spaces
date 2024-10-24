<?php

namespace App\Livewire\User;

use Livewire\Component;
use Livewire\WithFileUploads;
use Auth;

use App\Models\Reservation;
use App\Models\Payment;

class Reservations extends Component
{
    use WithFileUploads;

    public $reservations;
    public $slip;
    public $reservationId;

    public function mount()
    {
        $this->reservations = Auth::user()->reservations;
    }

    public function render()
    {
        return view('livewire.user.reservations');
    }

    public function updatedSlip()
    {
        $reservation = Reservation::find($this->reservationId);

        $invoice = $reservation->invoices()->where('status','pending')->first();
        $path = $this->slip->store('slips', 'public');

        $payment = new Payment;
        $payment->amount = $invoice->amount;
        $payment->invoice_id = $invoice->id;
        $payment->file = $path;
        $payment->save();

        $invoice->status = "process";
        $invoice->save();

        $reservation->status = "process";
        $reservation->save();

        $this->mount();
    }

    public function pay($id)
    {
        $this->reservationId = $id;
    }
}
