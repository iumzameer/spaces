<?php

namespace App\Livewire\User;

use Livewire\Component;
use Illuminate\Support\Facades\Validator;
use Auth;

use App\Models\Company;
use App\Models\Reservation;

class Profile extends Component
{
    public $action = "none";
    public $editIndex = null;
    public $company_name, $company_contact, $company_email, $company_address;
    public $name, $nid, $contact, $email, $address, $paddress;
    public $showError = false;
    public $showProfileMsg = false;
    public $profileMsgType = "error";
    public $msg;
    public $company = "";

    public function mount()
    {
        $this->name = Auth::user()->name;
        $this->nid = Auth::user()->nid;
        $this->contact = Auth::user()->contact;
        $this->email = Auth::user()->email;
        $this->address = Auth::user()->address;
        $this->paddress = Auth::user()->paddress;
    }

    public function render()
    {
        return view('livewire.user.profile');
    }

    public function editCompany($index, Company $company)
    {
        $this->company_name = $company->name;
        $this->company_contact = $company->contact;
        $this->company_email = $company->email;
        $this->company_address = $company->address;

        $this->action = "edit";
        $this->editIndex = $index;
    }

    public function cancel()
    {
        $this->action = "none";
        $this->editIndex = null;
    }

    public function deleteCompany($index)
    {
        $this->action = "delete";
        $this->editIndex = $index;
    }

    public function confirmDelete(Company $company)
    {
        $company->users()->detach();
        $company->delete();
        $this->action = "none";
        $this->editIndex = null;
    }

    public function saveCompany(Company $company)
    {
        $validator = Validator::make(
        [
            'company_name' => $this->company_name,
            'company_contact' => $this->company_contact,
            'company_email' => $this->company_email,
            'company_address' => $this->company_address,
        ],
        [
            'company_name' => 'required|string',
            'company_contact' => 'required|digits:7',
            'company_email' => 'required|email',
            'company_address' => 'required|string',
        ],
        [
            'company_contact.required' => 'contact number is required.',
            'company_contact.digits' => 'contact number invalid.'
        ]);

        if ($validator->fails())
        {
            $this->msg = $validator->errors()->first();
            $this->showError = true;

            if($this->action == "add")
            {
                $this->editIndex = "new";
            }
        }
        else
        {

            $this->msg = "";
            $this->showError = false;

            if($this->action == "add")
            {
                $company = new Company;
            }

            $company->name = $this->company_name;
            $company->contact = $this->company_contact;
            $company->email = $this->company_email;
            $company->address = $this->company_address;
            $company->save();

            if($this->action == "add")
            {
                $company->users()->attach(Auth::user()->id,['status' => 'verified']);
            }

            $this->editIndex = null;
            $this->action = "none";
        }
    }

    public function addCompany()
    {
        $this->company_name = null;
        $this->company_contact = null;
        $this->company_email = null;
        $this->company_address = null;
        $this->action = "add";
    }

    public function saveProfile()
    {
        $validator = Validator::make(
        [
            'name' => $this->name,
            'nid' => $this->nid,
            'contact' => $this->contact,
            'email' => $this->email,
            'address' => $this->address,
            'paddress' => $this->paddress,
        ],
        [
            'name' => 'required|string',
            'nid' => 'required|string',
            'contact' => 'required|digits:7',
            'email' => 'required|email',
            'address' => 'required|string',
            'paddress' => 'required|string',
        ],
        [
            'contact.required' => 'contact number is required.',
            'contact.digits' => 'contact number invalid.'
        ]);

        if ($validator->fails())
        {
            $this->msg = $validator->errors()->first();
            $this->showProfileMsg = true;
            $this->profileMsgType = "error";
        }
        else
        {
            $user = Auth::user();

            $user->name = $this->name;
            $user->nid = $this->nid;
            $user->contact = $this->contact;
            $user->email = $this->email;
            $user->address = $this->address;
            $user->paddress = $this->paddress;
            $user->save();

            $this->msg = "Profile Saved!";
            $this->showProfileMsg = true;
            $this->profileMsgType = "success";
        }
    }
}
