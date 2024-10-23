<?php

namespace App\Livewire\User;

use Livewire\Component;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Auth;

use App\Models\Company;
use App\Models\Location;
use App\Models\Etype;
use App\Models\Tier;
use App\Models\Item;
use App\Models\Reservation;

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
    public $showItemError = false;
    public $locations, $etypes, $tiers, $from, $to, $qty = 1;
    public $rlocations = [];
    public $ritems = [];
    public $items;
    public $msg, $itemMsg;

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
                $this->addReservation();
                break;
            default:
                $this->stepDescription = "Information";
                $this->infoSection = true;
                $this->locationSection = false;
                $this->confirmSection = false;
                break;
        }
    }

    public function addReservation()
    {
        $reservation = new Reservation;
        $reservation->user_id = Auth::user()->id;

        if(!is_null($this->companyId))
        {
            $reservation->company_id = $this->companyId;
            $type = "normal";
        }
        else
        {
            $type = "commercial";
        }

        $reservation->save();

        foreach ($this->rlocations as $key => $rlocation)
        {
            if(isset($rlocation["tier"]->hrs))
            {
                $tier_id = $rlocation["tier"]->id;
            }
            else
            {
                $tier_id = null;
            }

            $reservation->locations()->attach($rlocation["location"]->id, ['type' => $type, 'etype_id' => $rlocation["etype"]->id, 'from' => $rlocation["from"], 'to' => $rlocation["to"], 'tier_id' => $tier_id]);
        }

        foreach ($this->ritems as $key => $ritem)
        {
            $reservation->items()->attach($ritem["item"]->id, ['qty' => $ritem["qty"], 'location_id' => $ritem["locationId"]]);
        }
        
        return redirect()->route('user.reservations');
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
            $check = 0;

            foreach($this->rlocations as $location)
            {
                if($location["location"]->id == $this->locationId)
                {
                    $check = 1;
                    break;
                }
            }

            if($check == 0)
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

                $rlocation = ["location" => $location, "etype" => $etype, "tier" => $tier, "from" => $this->from, "to" => $this->to];

                array_push($this->rlocations, $rlocation);

                $this->locationDetails = true;

                $this->locationId = null;
                $this->from = null;
                $this->to = null;
                $this->etypeId = null;
                $this->tierId = null;
            }
            else
            {
                $this->msg = "Location already exists!";
                $this->showLocationError = true;
            }   
        }

        $this->updateAmounts();
    }

    public function addItem($locationId)
    {

        $validator = Validator::make(
        [
            'itemId' => $this->itemId,
            'qty' => $this->qty
        ],
        [
            'itemId' => 'required|exists:items,id',
            'qty' => 'required'
        ],
        [
            'itemId.required' => 'Item is required!',
            'itemId.exists' => 'Item is invalid!',
            'qty.required' => 'Quantity is required!'
        ]);

        if ($validator->fails())
        {
            $this->itemMsg = $validator->errors()->first();
            $this->showItemError = true;
        }
        else
        {
            $item["item"] = Item::find($this->itemId);
            $item["qty"] = $this->qty;
            $item["locationId"] = $locationId;
            $item["sub"] = 0;

            $check = 0;

            foreach ($this->ritems as $key => $itemx)
            {
                if(($itemx["item"]->id == $this->itemId)&&($itemx["locationId"] == $locationId))
                {
                    $this->ritems[$key]["qty"] = $itemx["qty"] + $this->qty;
                    $check = 1;
                }
            }

            if($check == 0)
            {
                array_push($this->ritems, $item);
            }

            $this->itemId = null;
            $this->qty = 1;
        }

        $this->updateAmounts();
    }

    public function updateAmounts()
    {
        foreach($this->rlocations as $key => $rlocation)
        {
            if(!isset($rlocation["tier"]->hrs))
            {
                $hrs = false;
                $total = $rlocation["location"]->tiers()->where('hrs', 24)->first()->pivot->amount * $rlocation["tier"];
            }
            else
            {
                $hrs = true;
                $total = $rlocation["location"]->tiers()->where('tier_id', $rlocation["tier"]->id)->first()->pivot->amount;
            }

            foreach ($this->ritems as $key => $item)
            {
                if($rlocation["location"]->id == $item["locationId"])
                {
                    if($hrs == false)
                    {
                        $sub = $item["item"]->tiers()->where('hrs', 24)->first()->pivot->amount * $rlocation["tier"] * $item["qty"];
                    }
                    else
                    {
                        $sub = $item["item"]->tiers()->where('tier_id', $rlocation["tier"]->id)->first()->pivot->amount * $item["qty"];
                    }

                    $this->ritems[$key]["sub"] = $sub;
                    $total = $total + $sub;
                }

            }

            $this->rlocations[$key]["location"]["total"] = $total;
        }

    }

    public function deleteItem($itemId, $locationId)
    {
        foreach ($this->ritems as $key => $item)
        {
            if(($locationId == $item["locationId"]) && ($itemId == $item["item"]->id))
            {
                unset($this->ritems[$key]);
                break;
            }
        }

        $this->updateAmounts();
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
