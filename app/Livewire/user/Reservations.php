<?php

namespace App\Livewire\User;

use Livewire\Component;
use Auth;

class Reservations extends Component
{
    public $reservations;
    
    public function mount()
    {
        $this->reservations = Auth::user()->reservations;
    }

    public function render()
    {
        return view('livewire.user.reservations');
    }
}
