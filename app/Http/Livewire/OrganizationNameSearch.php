<?php

namespace App\Http\Livewire;

use App\Organization;
use Livewire\Component;

class OrganizationNameSearch extends Component
{
    // this component has been replaced by checkOrganizationName method in FrontendController
    public $organizationName;

    public function search()
    {
        if ($this->organizationName == "") {
            session()->flash('error', 'कृपया व्यवसायको नाम टाइप गर्नुहोस्।');
            return;
        }

        $count = Organization::where('org_name', $this->organizationName)->count();

        if (!$count) {
            session()->flash('success', $this->organizationName . ' is available for registration.');
        } else {
            session()->flash('error', $this->organizationName . ' is not available for registration.');
        }
    }

    public function render()
    {
        return view('livewire.organization-name-search');
    }
}
