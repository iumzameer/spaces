<?php

namespace App\Livewire\User;

use Livewire\Component;

class Dashboard extends Component
{

    public function mount()
    {   
        return redirect(route('user.reservations'));
    }
}
