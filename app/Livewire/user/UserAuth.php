<?php

namespace App\Livewire\User;

use Livewire\Component;
use Illuminate\Support\Facades\Validator;

use Auth;
use App\Models\User;

class UserAuth extends Component
{
    public $label = "Contact No.";
    public $button = "Send OTP";
    public $action = "contact";
    public $input;
    public $msg = "msg";
    public $showError = false;
    public $otp;
    public $contact;

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

            if ($validator->fails())
            {
                $this->msg = $validator->errors()->first();
                $this->showError = true;
            }
            else
            {
                $this->contact = $this->input;

                $this->label = "OTP";
                $this->button = "Login";
                $this->input = "";
                $this->action = "otp";
                $this->showError = false;

                $this->otp = 1234;
                //send otp
            }  
        }
        elseif ($this->action == "otp")
        {
            if($this->input == $this->otp)
            {
                if(User::where('contact', $this->contact)->count() == 0)
                {
                    $this->msg = "No account registered under the number";
                    $this->showError = true;

                    $this->label = "Contact No.";
                    $this->button = "Send OTP";
                    $this->action = "contact";
                    $this->input = "";
                }
                else
                {
                   $user = User::where('contact', $this->contact)->first();

                    Auth::login($user);

                    return redirect()->route('user.dashboard'); 
                }
            }
            else
            {
                $this->msg = "Incorrect OTP";
                $this->showError = true;
            }
        } 
    }
}
