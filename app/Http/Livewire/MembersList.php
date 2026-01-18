<?php

namespace App\Http\Livewire;

use App\Member;
use App\Address;
use App\Committee;
use Livewire\Component;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;

class MembersList extends Component
{
  
    public $members;
    public $patientId;

    public $committees;
    public $committeesId;
    public $patients = [];
    public $filteredMembers = [];
    public $firstMember;

    public $toggle = true;
    public function mount($members = null, $patients = null, $patientId = null)
    {
        $this->members = $members;
        $this->patients = $patients;
        $this->patientId = $patientId;
    }

    public function toggleModal()
    {
        $this->toggle = false;
    }
    public function toggleMember($memberId)
    {
        // dd($memberId);
        if (in_array($memberId, $this->filteredMembers)) {
            $this->filteredMembers = array_filter($this->filteredMembers, fn($id) => $id !== $memberId);
        } else {
            // Add to filtered members
            $this->filteredMembers[] = $memberId;
        }

        $this->sortFilteredMembers();
    }

    protected function sortFilteredMembers()
    {
        // Sort the filtered members array in ascending order (you can customize the sorting)
        $this->filteredMembers = collect($this->members)
            ->whereIn('id', $this->filteredMembers)
            ->sortBy('order') // Sort by the 'order' property
            ->pluck('id') // Get back just the IDs
            ->toArray();
    }

    public function exportData()
    {
        $phpWord = new PhpWord();
        $section = $phpWord->addSection();

        $fontStyle = [
            'name' => 'Noto Sans Devanagari',
            'size' => 12,
        ];
        $today = ad_to_bs(now()->format('Y-m-d'));
        $todayDate = englishToNepaliLetters($today);
        $address = Address::find(municipalityId());
        $committee = null;

        $string = 'आज मिति ' . $todayDate . ' गतेका दिन ' . englishToNepaliLetters(date('h:i')) . ' बजे यस ' . $address->municipality . ' का ';
        if ($committee) {

            if ($this->members) {
                if ($this->members[0]) {
                    $string = $string . $this->members[0]->position->name;
                } else {
                    $string = $string . " ";
                }
            } else {
                $string = $string . " ";
            }
        }
        $string = $string . " " . 'एवं नेपालसरकार बाट जारी गरिएको "प्रभावित नागरिक विपद् राहत कोष निर्देशिका २०८०" बमोजिम प्रभावित नागरिकहरुलाई विपद् राहत सहुलियत उपलब्ध गराउने प्रयोजनको लागि सिफारिस समितिका';
        if ($committee) {

            if ($this->members) {
                if ($this->members[0]) {
                    $string = $string . $this->members[0]->committeePosition->name;
                } else {
                    $string = $string . " ";
                }
            } else {
                $string = $string . " ";
            }
        }
        $string = $string . " श्री";
        if ($committee) {
            if ($this->members) {
                if ($this->members[0]) {
                    $string = $string . " " . $this->members[0]->name;
                } else {
                    $string = $string . " ";
                }
            } else {
                $string = $string . " ";
            }
        }
        $string = $string . " ज्युको अध्यक्ष्यतामा बसेको बैठकले तपसिल बमोजिम प्रस्ताबहरु माथि छलफल गरि तपसिल बमोजिम निर्णयहरु पारित गरियो";
        $section->addText($string, $fontStyle);
        $section->addTextBreak(0);
        $string = 'उपस्थिति';
        $section->addText($string, $fontStyle);
        $section->addTextBreak(0);
        $string = '';

        foreach ($this->filteredMembers as $index => $filterMember) {
            $string = $string . ($index + 1) . ".";
            $string = $string . " " . $this->members->find($filterMember)->position->name;
            $string = $string . " " . $this->members->find($filterMember)->name . ' (' . $this->members->find($filterMember)->committeePosition->name . ')';
            $section->addText($string, $fontStyle);
            $section->addTextBreak(0);
            $string = '';
        }



        $section->addText($string, $fontStyle);
        $section->addTextBreak(0);
        $string = "प्रस्ताव नं 1 : विपद् राहत सहुलियत का लागि सिफारिस सम्बन्धमा";
        $section->addText($string, $fontStyle);
        $section->addTextBreak(0);
        $string = "निर्णय नं: 1 प्रस्ताव नं: 1 माथि छलफल गर्दा यस घोडाघोडी नगरपालिका मा स्थायी बसोबास भएका तपसिल बमोजिमका प्रभावित नागरिकहरुले यस पालिकामा दिएको निवेदन उपर छलफल गरी संलग्न कागजातका आधारमा “प्रभावित नागरिक विपद् राहत कोष निर्देशिका 2080” अनुसार तपसिल बमोजिमका प्रभावित नागरिकहरुलाई देहाय बमोजिम तोकिएका निकायहरु मार्फत राहत उपलब्ध गराउन सिफारिस गर्ने निर्णय पारित गरियो।";
        $section->addText($string, $fontStyle);
        $section->addTextBreak(0);


        $tableStyle = [

            'borderSize' => 6,
            'borderColor' => '000000',
            'cellMargin' => 50,
        ];
        $fontStyle = ['size' => 8];

        $phpWord->addTableStyle('myTable', $tableStyle);

        $table = $section->addTable('myTable');

        $table->addRow();
        $table->addCell(500)->addText('क्र. सं.', $fontStyle);
        $table->addCell(2000)->addText('नाम थर', $fontStyle);
        $table->addCell(2000)->addText('ना.प्र.प.नं./ज. .द.प्र.प.नं.', $fontStyle);
        $table->addCell(800)->addText('वडा न.', $fontStyle);
        $table->addCell(3500)->addText('क्षती भएको कारण', $fontStyle);
        $table->addCell(1200)->addText('क्षति मिति', $fontStyle);
        $table->addCell(1200)->addText('अनुमानित क्षतिरकम', $fontStyle);
        $table->addCell(1200)->addText('प्रदानरकम', $fontStyle);

        foreach ($this->patients as $index => $patient) {
            if (is_array($patient)) {
                $patient = json_decode(json_encode($patient));
            }
            $table->addRow();
            $table->addCell(500)->addText(englishToNepaliLetters($index + 1), $fontStyle);
            $cell = $table->addCell(2000);
            $cell->addText(englishToNepaliLetters($patient->name ?? ''), $fontStyle);
            $cell->addText(englishToNepaliLetters($patient->mobile_number ?? ''), $fontStyle); 
            $table->addCell(2000)->addText(englishToNepaliLetters($patient->citizenship_number ?? ''), $fontStyle);
            $table->addCell(800)->addText(englishToNepaliLetters($patient->ward_number  ?? ''), $fontStyle);
            $table->addCell(3200)->addText(englishToNepaliLetters($patient->description ?? ''), $fontStyle);
            $table->addCell(1500)->addText(englishToNepaliLetters($patient->kshati_date  ?? ''), $fontStyle);
            $table->addCell(1200)->addText(englishToNepaliLetters($patient->estimated_amount), $fontStyle);
            $table->addCell(1200)->addText('');
        }



        $tempFilePath = tempnam(sys_get_temp_dir(), 'PHPWord') . '.docx';
        $writer = IOFactory::createWriter($phpWord, 'Word2007');
        $writer->save($tempFilePath);
        return response()->download($tempFilePath, 'निर्णय पत्र.docx')->deleteFileAfterSend(true);
    }
    public function render()
    {
        $members = collect($this->members); // Ensure it's a collection
        $first = $members->sortBy('order')->first();
        // dd($this->firstMember);
        return view('livewire.members-list', [
            'members' => $this->members,
            'newMember' => $first,
        ]);
    }
}
