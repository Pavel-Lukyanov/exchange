<?php

namespace Database\Seeders;

use App\Models\ServicedObject;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServicedObjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new ServicedObject();
        $user->name = 'Магазин24';
        $user->country = 'Россия';
        $user->city = 'Сургут';
        $user->street = 'Московская';
        $user->house = '32';
        $user->contract_number = '123532';
        $user->services_schedule = '{"json": "123"}';
        $user->contract_date_start = '10.07.2023';
        $user->contract_date_end = '10.07.2023';
        $user->type_installation = 'ОПС, ПС, КТС';
        $user->name_organization_do_project = 'Альфа Щит';
        $user->project_release_date = '10.07.2023';
        $user->organization_name_mounting = 'Альфа Щит';
        $user->date_delivery_object = '10.07.2023';
        $user->description_object = 'Объект находится по адресу проспект Комсомольский, д.29. Представляет из себя одноэтажное здание. Вход со стороны дороги проспекта Комсомольский. Дверь металлическая, черного цвета. Объектовый прибор находится возле запасного входа. Клавиатура объектового прибора находится возле главного входа.';
        $user->organization_name_mounting = 'Альфа Щит';
        $user->save();
    }
}
