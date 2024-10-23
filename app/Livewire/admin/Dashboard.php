<?php

namespace App\Livewire\Admin;

use Livewire\Component;

use App\Models\Reservation;

class Dashboard extends Component
{
    public $reservations;

    public function mount()
    {
        $this->reservations = Reservation::all();
    }

    public function render()
    {
        return view('livewire.admin.dashboard')->layout('layouts.app');
    }
}
