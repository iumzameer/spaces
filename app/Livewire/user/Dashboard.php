<?php

namespace App\Livewire\User;

use Livewire\Component;

class Dashboard extends Component
{

    public function mount()
    {   
        // if(!\Auth::check())
        // {
        //     return redirect(route('user.login'));
        // }
    }

    public function render()
    {
        
        return view('livewire.user.dashboard');
    }

    public function newReservation()
    {
        $this->modalBg = true;
        $this->reservationModal = true;
    }
}
