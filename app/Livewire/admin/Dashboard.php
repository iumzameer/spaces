<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Carbon\Carbon;

use App\Models\Reservation;
use App\Models\Invoice;
use App\Models\Line;

class Dashboard extends Component
{
    public $reservations;
    public $url;
    public $reserve;
    public $slipModal = false;

    public function mount()
    {
        $this->reservations = Reservation::all();
    }

    public function render()
    {
        return view('livewire.admin.dashboard')->layout('layouts.app');
    }

    public function approveReservation($id)
    {
        $reservation = Reservation::find($id);
        $invoice = new Invoice;
        $invoice->reservation_id = $id;
        $invoice->due = Carbon::now();
        $invoice->amount = 0;
        $invoice->save();

        $days = 1;
        $hrs = 0;
        $total = 0;

        foreach ($reservation->locations as $location)
        {
            
            if($location->pivot->status == "pending")
            {
                $days = Carbon::parse($location->pivot->from)->diff(Carbon::parse($location->pivot->to))->days;

                if($days < 1)
                {
                    $days = 0;
                    $amount = $location->tiers()->wherePivot('tier_id', $location->pivot->tier_id)->first()->pivot->amount;
                    $hrs= Tier::find($location->pivot->tier_id)->hrs;
                    $sub = $amount;
                }
                else
                {
                    $amount = $location->tiers()->where('hrs', 24)->first()->pivot->amount;
                    $sub = $amount * $days;
                }

                

                $line = new Line;

                if($days > 0)
                {
                    $line->description = $location->description." (".$days." days)";
                }
                else
                {
                    $line->description = $location->description." (".$hrs." hrs)";
                }

                $line->amount = $sub;
                $line->invoice_id = $invoice->id;
                $line->save();

                $total = $total + $sub;

                $reservation->locations()->updateExistingPivot($location->id, ['status' => 'payment']);
            }
        }

        if($reservation->items()->count() > 0)
        {
            foreach ($reservation->items as $key => $item)
            {
                if($item->pivot->status == "pending")
                {
                    $line = new Line;

                    if($days > 0)
                    {
                        $line->description = $item->description." x ".$item->pivot->qty." (".$days." days)";
                        $amount = $item->tiers()->where('hrs', 24)->first()->pivot->amount;
                    }
                    else
                    {
                        $line->description = $item->description." x ".$item->pivot->qty." (".$hrs." hrs)";
                        $amount = $item->tiers()->where('hrs', $hrs)->first()->pivot->amount;
                    }

                    $sub = $amount * $item->pivot->qty;
                    $line->amount = $sub;
                    $line->invoice_id = $invoice->id;
                    $line->save();

                    $total = $total + $sub;

                    $reservation->items()->updateExistingPivot($item->id, ['status' => 'payment']);
                }
            }
        }

        $reservation->status = "payment";

        $reservation->save();

        $invoice->amount = $total;
        $invoice->save();

        $this->mount();
    }

    public function openSlipModal($id)
    {
        $this->reserve = Reservation::find($id);

        $this->url = $this->reserve->invoices()->where('status','process')->first()->payments()->first()->file;
        $this->slipModal = true;
    }

    public function closeSlipModal()
    {
        $this->url = null;
        $this->slipModal = false;
    }

    public function verifySlip()
    {
        $invoice = $this->reserve->invoices()->where('status','process')->first();
        $payment = $this->reserve->invoices()->where('status','process')->first()->payments()->first();

        $invoice->status = "paid";
        $payment->status = "paid";
        $this->reserve->status = "confirmed";

        $invoice->save();
        $payment->save();
        $this->reserve->save();

        foreach ($this->reserve->items as $key => $item)
        {
            $this->reserve->items()->updateExistingPivot($item->id, ['status' => 'confirmed']);
        }

        foreach ($this->reserve->locations as $key => $location)
        {
            $this->reserve->locations()->updateExistingPivot($location->id, ['status' => 'confirmed']);
        }

        $this->mount();
        $this->closeSlipModal();
    }

    public function rejectSlip()
    {
        $invoice = $this->reserve->invoices()->where('status','process')->first();
        $payment = $this->reserve->invoices()->where('status','process')->first()->payments()->first();

        $invoice->status = "pending";
        $payment->delete();
        $this->reserve->status = "payment";

        $invoice->save();
        $this->reserve->save();

        $this->mount();
        $this->closeSlipModal();
    }
}
