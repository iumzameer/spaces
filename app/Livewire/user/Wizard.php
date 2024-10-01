<?php

namespace App\Livewire\User;

use Livewire\Component;

use App\Models\Company;

class Wizard extends Component
{
    public $stepDescription = "Information";
    public $buttonText = "Next";
    public $step = 1;
    public $companySection = false;
    public $company = [];
    public $companyId = null;
    public $infoSection = true;
    public $locationSection = false;
    public $confirmSection = false;
    public $showItem = false;
    public $locationDetails = false;

    public function mount()
    {
        $this->company = Company::first();
    }

    public function render()
    {
        return view('livewire.user.wizard');
    }

    public function updatedCompanyId()
    {
        if(!is_null($this->companyId) && ($this->companyId != ""))
        {
            $this->company = Company::find($this->companyId);
            $this->companySection = true; 
        }
        else
        {
            $this->companyId = null;
            $this->companySection = false; 
        }
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
