<?php

namespace App\Livewire\User;

use Livewire\Component;

class UserAuth extends Component
{
    public $label = "Contact No.";
    public $button = "Send OTP";
    public $action = "otp";
    public $input;

    public function render()
    {
        return view('livewire.user.login');
    }

    public function submit()
    {
        if($this->action == "otp")
        {
            $this->label = "OTP";
            $this->button = "Login";
            $this->input = "";
        } 
    }
}
