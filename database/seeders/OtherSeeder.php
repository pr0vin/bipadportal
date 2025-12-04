<?php

namespace Database\Seeders;

use App\Relation;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class OtherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Role::where('name', 'admin')->first();
        $wardSecretary = Role::where('name', 'ward-secretary')->first();
        $admin->syncPermissions(([
            'dirgha.create',
            'bipanna.create',
            'samajik.create',
            'nagarpalika.create',
            'dirgha.application',
            'bipanna.application',
            'samajik.application',
            'nagarpalika.application',
            'dirgha.registered',
            'bipanna.registered',
            'samajik.registered',
            'nagarpalika.registered',
            'dirgha.show',
            'dirgha.edit',
            'dirgha.delete',
            'dirgha.register',
            'dirgha.tokenletter',
            'dirgha.renew',
            'dirgha.close',
            'bipanna.show',
            'bipanna.edit',
            'bipanna.delete',
            'bipanna.register',
            'bipanna.TokenLetter',
            'bipanna.DecisionPrint',
            'bipanna.SifarisPrint',
            'samajik.show',
            'samajik.edit',
            'samajik.delete',
            'samajik.register',
            'samajik.TokenLetter',
            'samajik.DecisionPrint',
            'nagarpalika.show',
            'nagarpalika.edit',
            'nagarpalika.delete',
            'nagarpalika.register',
            'nagarpalika.TokenLetter',
            'nagarpalika.DecisionPrint',
            'dirgha.report',
            'bipanna.report',
            'samajik.report',
            'nagarpalika.report',
            'closed.report',
            'renewed.report',
            'notRenewed.report',
            'user.store',
            'user.edit',
            'user.delete',
            'user.password',
            'member.store',
            'fiscalYear.edit',
            'member.edit',
            'member.delete',

            'hospital_document',
            'disease_proved_document',
            'citizenship_card',
            'application',
            'doctor_recomandation',
            'bank_cheque',
            'decision_document'
        ]));

        $wardSecretary->syncPermissions(([
            'dirgha.create',
            'bipanna.create',
            'samajik.create',
            'nagarpalika.create',
            'dirgha.application',
            'bipanna.application',
            'samajik.application',
            'nagarpalika.application',
            'dirgha.registered',
            'bipanna.registered',
            'samajik.registered',
            'nagarpalika.registered',

            'dirgha.show',
            'dirgha.edit',
            'bipanna.show',
            'bipanna.edit',
            'samajik.show',
            'samajik.edit',
            'nagarpalika.show',
            'nagarpalika.edit',

            'hospital_document',
            'disease_proved_document',
            'citizenship_card',
            'application',
            'doctor_recomandation',
            'bank_cheque',
            'decision_document'
        ]));

        $relations = ['हजुर बुवा', 'पत्नी', 'हजुर आमा', 'बाबु', 'आमा', 'छोरा', 'छोरी', 'नाति', 'नातिनी', 'दाजु-भाइ', 'दिदी-बहिनी', 'भान्जा-भान्जी', 'भतिजा-भतिजी', 'छोराबुहारी', 'छोरीज्वाईं', 'सासू', 'ससुरा'];
        foreach ($relations as $relation) {

            Relation::create([
                'name' => $relation
            ]);
        }
    }
}
