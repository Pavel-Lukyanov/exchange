<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->firstname = 'Павел';
        $user->patronymic = 'Александрович';
        $user->surname = 'Лукьянов';
        $user->email = 'test@mail.ru';
        $user->password = bcrypt('12345678');
        $user->city = 'Сургут';
        $user->street = 'пр. Комсомольский';
        $user->house = '13';
        $user->flat = '11';
        $user->birthday = '1996-04-21';
        $user->date_medical_examination = '2020-04-21';
        $user->position = 'Директор';
        $user->phone = '+79526932995';
        $user->save();
    }
}
