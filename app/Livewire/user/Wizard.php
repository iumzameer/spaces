<?php

namespace App\Livewire\User;

use Livewire\Component;

class Wizard extends Component
{
    public $stepDescription = "Information";
    public $buttonText = "Next";
    public $step = 1;
    public $companySection = false;
    public $company = false;
    public $infoSection = true;
    public $locationSection = false;
    public $confirmSection = false;
    public $showItem = false;
    public $locationDetails = false;

    public function mount()
    {
        \Auth::login(\App\Models\User::first());
    }

    public function render()
    {
        return view('livewire.user.wizard');
    }

    public function updatedCompany()
    {
        $this->companySection = true;
    }

    public function nextStep()
    {
        switch ($this->step)
        {
            case 1:
                $this->stepDescription = "Location Selection";
                $this->infoSection = false;
                $this->locationSection = true;
                $this->confirmSection = false;
                $this->step = 2;
                break;
            case 2:
                $this->stepDescription = "Agreement";
                $this->infoSection = false;
                $this->locationSection = false;
                $this->confirmSection = true;
                $this->buttonText = "Confirm Reservation";
                $this->step = 3;
                break;
            case 3:
                return redirect()->route('user.reservations');
                break;
            default:
                $this->stepDescription = "Information";
                $this->infoSection = true;
                $this->locationSection = false;
                $this->confirmSection = false;
                break;
        }
    }

    public function addLocation()
    {
        $this->locationDetails = true;
    }

    public function addItem()
    {
        $this->showItem = true;
    }
}
