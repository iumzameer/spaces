<?php

namespace App\Livewire\User;

use Livewire\Component;
use Illuminate\Support\Facades\Validator;

class UserAuth extends Component
{
    public $label = "Contact No.";
    public $button = "Send OTP";
    public $action = "contact";
    public $input;
    public $msg = "msg";
    public $showError = false;

    public function render()
    {
        return view('livewire.user.login');
    }

    public function submit()
    {
        if($this->action == "contact")
        {
            $validator = Validator::make(
            [
                'contact' => $this->input,
            ],
            [
                'contact' => 'required|digits:7',
            ],
            [
                'contact.required' => 'Contact number is required!',
                'contact.digits' => 'Contact number invalid!'
            ]);

            if ($validator->fails()) {
                $this->msg = $validator->errors()->first();
                $this->showError = true;
            } else {
                $this->label = "OTP";
                $this->button = "Login";
                $this->input = "";
                $this->action = "otp";
                $this->showError = false;
            }  
        }
        elseif ($this->action == "otp")
        {
            return redirect()->route('user.dashboard');
        } 
    }
}
