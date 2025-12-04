<?php

namespace App\Http\Livewire;

use App\OnlineApplication;
use App\Organization;
use App\Patient;
use Livewire\Component;

class TokenSearchForm extends Component
{
    public $tokenNumber;
    public $organization;
    public $message;
    public $rules = [
        'tokenNumber' => 'required'
    ];

    public function mount($tokenNumber = null)
    {
        $this->organization  = new Organization();
        if ($tokenNumber) {
            $this->tokenNumber = $tokenNumber;
            $this->search();
        }
    }

    public function search()
    {

        $this->message = '';
        $this->validate();
        $onlineApplication = OnlineApplication::where('token_number', $this->tokenNumber)->first();
        if ($onlineApplication) {
            $this->organization = Patient::find($onlineApplication->patient_id);
        } else {
            $this->message = 'टोकन नम्बर मिलेन ।';
        }
    }

    public function cancel()
    {
        $this->organization = new Organization();
        $this->reset('message');
    }

    public function render()
    {
        return view('livewire.token-search-form', ['organization' => $this->organization]);
    }
}
