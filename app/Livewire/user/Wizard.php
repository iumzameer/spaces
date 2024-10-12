<?php

namespace App\Livewire\User;

use Livewire\Component;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

use App\Models\Company;
use App\Models\Location;
use App\Models\Etype;
use App\Models\Tier;
use App\Models\Item;

class Wizard extends Component
{
    public $stepDescription = "Information";
    public $buttonText = "Next";
    public $step = 1;
    public $rType = null;
    public $companySection = false;
    public $company = [];
    public $companyId = null;
    public $locationId = null;
    public $etypeId = null;
    public $tierId = null;
    public $itemId = null;
    public $infoSection = true;
    public $locationSection = false;
    public $confirmSection = false;
    public $showItem = false;
    public $showDuration = false;
    public $locationDetails = false;
    public $showLocationError = false;
    public $locations, $etypes, $tiers, $from, $to, $qty = 1;
    public $rlocations = [];
    public $ritems = [];
    public $items;
    public $msg;

    public function mount()
    {
        $this->company = Company::first();
        $this->locations = Location::all();
        $this->etypes = Etype::all();
        $this->tiers = Tier::all();
        $this->items = Item::all();
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

    public function updatedlocationId()
    {
        $this->location = Location::find($this->locationId);
        $this->tiers = $this->location->tiers;
    }

    public function updatedFrom()
    {
        $this->checkDuration();
    }

    public function updatedTo()
    {
        $this->checkDuration();
    }

    public function checkDuration()
    {
        if(!is_null($this->from)||($this->from == "")||!is_null($this->to)||($this->to == ""))
        {
            $this->showDuration = false;
        }
        if($this->from == $this->to)
        {
            $this->showDuration = true;
        }
        else
        {
            $this->showDuration = false;
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
                $this->locationDetails = false;
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
        $validator = Validator::make(
        [
            'locationId' => $this->locationId,
            'from' => $this->from,
            'to' => $this->to,
            'etypeId' => $this->etypeId,
            'tierId' => $this->tierId,
        ],
        [
            'locationId' => 'required|exists:locations,id',
            'from' => 'required',
            'to' => 'required',
            'etypeId' => 'sometimes|required',
        ],
        [
            'locationId.required' => 'Location is required!',
            'locationId.exists' => 'Location is invalid!',
            'from.required' => 'From Date is required!',
            'to.required' => 'To Date is required!',
            'etypeId.required' => 'Purpose is required!',
        ]);

        if ($validator->fails())
        {
            $this->msg = $validator->errors()->first();
            $this->showLocationError = true;
        }
        else
        {
            $this->showLocationError = false;
            $location = Location::find($this->locationId);
            $etype = Etype::find($this->etypeId);

            if(Carbon::parse($this->from)->diff(Carbon::parse($this->to))->days < 1)
            {
                $tier = Tier::find($this->tierId);
            }
            else
            {
                $tier = Carbon::parse($this->from)->diff(Carbon::parse($this->to))->days;
            }    

            $rlocation = ["location" => $location, "etype" => $etype, "tier" => $tier];

            array_push($this->rlocations, $rlocation);

            $this->locationDetails = true;

            $this->locationId = null;
            $this->from = null;
            $this->to = null;
            $this->etypeId = null;
            $this->tierId = null;
        }
    }

    public function addItem()
    {
        $item = Item::find($this->itemId);
        $item->qty = $this->qty;

        array_push($this->ritems, $item);
    }

    public function updatedrType()
    {
        if(($this->rType == 2)||($this->rType == ""))
        {
            $this->companyId == null;
            $this->companySection = false;
        }
    }
}
