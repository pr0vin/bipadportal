<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // create permissions
        Permission::firstOrCreate(['name' => 'dirgha.create']);
        Permission::firstOrCreate(['name' => 'bipanna.create']);
        Permission::firstOrCreate(['name' => 'samajik.create']);
        Permission::firstOrCreate(['name' => 'nagarpalika.create']);

        Permission::firstOrCreate(['name' => 'dirgha.application']);
        Permission::firstOrCreate(['name' => 'bipanna.application']);
        Permission::firstOrCreate(['name' => 'samajik.application']);
        Permission::firstOrCreate(['name' => 'nagarpalika.application']);

        Permission::firstOrCreate(['name' => 'dirgha.registered']);
        Permission::firstOrCreate(['name' => 'bipanna.registered']);
        Permission::firstOrCreate(['name' => 'samajik.registered']);
        Permission::firstOrCreate(['name' => 'nagarpalika.registered']);

        Permission::firstOrCreate(['name' => 'dirgha.show']);
        Permission::firstOrCreate(['name' => 'dirgha.edit']);
        Permission::firstOrCreate(['name' => 'dirgha.delete']);
        Permission::firstOrCreate(['name' => 'dirgha.register']);
        Permission::firstOrCreate(['name' => 'dirgha.tokenletter']);
        Permission::firstOrCreate(['name' => 'dirgha.renew']);
        Permission::firstOrCreate(['name' => 'dirgha.close']);

        Permission::firstOrCreate(['name' => 'bipanna.show']);
        Permission::firstOrCreate(['name' => 'bipanna.edit']);
        Permission::firstOrCreate(['name' => 'bipanna.delete']);
        Permission::firstOrCreate(['name' => 'bipanna.register']);
        Permission::firstOrCreate(['name' => 'bipanna.TokenLetter']);
        Permission::firstOrCreate(['name' => 'bipanna.DecisionPrint']);
        Permission::firstOrCreate(['name' => 'bipanna.SifarisPrint']);

        Permission::firstOrCreate(['name' => 'samajik.show']);
        Permission::firstOrCreate(['name' => 'samajik.edit']);
        Permission::firstOrCreate(['name' => 'samajik.delete']);
        Permission::firstOrCreate(['name' => 'samajik.register']);
        Permission::firstOrCreate(['name' => 'samajik.TokenLetter']);
        Permission::firstOrCreate(['name' => 'samajik.DecisionPrint']);

        Permission::firstOrCreate(['name' => 'nagarpalika.show']);
        Permission::firstOrCreate(['name' => 'nagarpalika.edit']);
        Permission::firstOrCreate(['name' => 'nagarpalika.delete']);
        Permission::firstOrCreate(['name' => 'nagarpalika.register']);
        Permission::firstOrCreate(['name' => 'nagarpalika.TokenLetter']);
        Permission::firstOrCreate(['name' => 'nagarpalika.DecisionPrint']);

        Permission::firstOrCreate(['name' => 'dirgha.report']);
        Permission::firstOrCreate(['name' => 'bipanna.report']);
        Permission::firstOrCreate(['name' => 'samajik.report']);
        Permission::firstOrCreate(['name' => 'nagarpalika.report']);
        Permission::firstOrCreate(['name' => 'closed.report']);
        Permission::firstOrCreate(['name' => 'renewed.report']);
        Permission::firstOrCreate(['name' => 'notRenewed.report']);

        Permission::firstOrCreate(['name' => 'user.store']);
        Permission::firstOrCreate(['name' => 'user.edit']);
        Permission::firstOrCreate(['name' => 'user.delete']);
        Permission::firstOrCreate(['name' => 'user.password']);

        Permission::firstOrCreate(['name' => 'role.store']);
        Permission::firstOrCreate(['name' => 'role.edit']);
        Permission::firstOrCreate(['name' => 'role.delete']);
        Permission::firstOrCreate(['name' => 'role.permission']);

        Permission::firstOrCreate(['name' => 'system.setting']);
        Permission::firstOrCreate(['name' => 'application.setting']);
        Permission::firstOrCreate(['name' => 'downloadDocument.setting']);
        Permission::firstOrCreate(['name' => 'colsedReason.setting']);
        Permission::firstOrCreate(['name' => 'position.setting']);
        Permission::firstOrCreate(['name' => 'committeePosition.setting']);
        Permission::firstOrCreate(['name' => 'sms.setting']);
        Permission::firstOrCreate(['name' => 'onesignal.setting']);

        Permission::firstOrCreate(['name' => 'newPalika.store']);
        Permission::firstOrCreate(['name' => 'newPalika.edit']);
        Permission::firstOrCreate(['name' => 'newPalika.delete']);

        Permission::firstOrCreate(['name' => 'fiscalYear.store']);
        Permission::firstOrCreate(['name' => 'fiscalYear.edit']);
        Permission::firstOrCreate(['name' => 'fiscalYear.delete']);

        Permission::firstOrCreate(['name' => 'disease.store']);
        Permission::firstOrCreate(['name' => 'disease.edit']);
        Permission::firstOrCreate(['name' => 'disease.delete']);

        Permission::firstOrCreate(['name' => 'hospital.store']);
        Permission::firstOrCreate(['name' => 'hospital.edit']);
        Permission::firstOrCreate(['name' => 'hospital.delete']);

        Permission::firstOrCreate(['name' => 'committee.store']);
        Permission::firstOrCreate(['name' => 'committee.edit']);
        Permission::firstOrCreate(['name' => 'committee.delete']);

        Permission::firstOrCreate(['name' => 'member.store']);
        Permission::firstOrCreate(['name' => 'member.edit']);
        Permission::firstOrCreate(['name' => 'member.delete']);

        Permission::firstOrCreate(['name' => 'ward.store']);
        Permission::firstOrCreate(['name' => 'ward.edit']);
        Permission::firstOrCreate(['name' => 'ward.delete']);

        Permission::firstOrCreate(['name' => 'hospital_document']);
        Permission::firstOrCreate(['name' => 'disease_proved_document']);
        Permission::firstOrCreate(['name' => 'citizenship_card']);
        Permission::firstOrCreate(['name' => 'application']);
        Permission::firstOrCreate(['name' => 'doctor_recomandation']);
        Permission::firstOrCreate(['name' => 'bank_cheque']);
        Permission::firstOrCreate(['name' => 'decision_document']);



    }
}
