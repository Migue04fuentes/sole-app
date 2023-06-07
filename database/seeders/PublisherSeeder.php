<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Publisher;

class PublisherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $publisher = new Publisher();
        $publisher->name = 'AlfaOmega';
        $publisher->country='Mexico';
        $publisher->website='https://www.alfaomega.com.mx/';
        $publisher->email='alfaomega@correo.com';
        $publisher->description='Distribuidora de libros con más de 40 años de experiencia especializada en el bienestar y el desarrollo personal.';
        $publisher->save();


        $publisher1 = new Publisher();
        $publisher1->name='Sexto Piso';
        $publisher1->country='Mexico';
        $publisher1->website='https://www.sextopiso.es/';
        $publisher1->email='sextopiso@correo.com';
        $publisher1->description='	Filosofía, literatura y reflexiones sobre cuestiones y conflictos contemporáneos';
        $publisher1->save();
    }
}
