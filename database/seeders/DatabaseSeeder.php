<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Property;
use App\Models\PropertyType;
use App\Models\SearchProfile;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //property type seeder
        PropertyType::create([
            'type' =>  Str::uuid()->toString(),
        ]);


        //property seeder
      $search_fields=[
            "area"=>[0,rand()],
            "yearOfConstruction"=>["2020",null],
            "rooms"=>["4,",null],
            "heatingType"=>'Gas',
            "parking"=>true,
            "returnActual"=>12.8,
            "price"=>'150000',
        ];
       $property_type_id= PropertyType::first();
       Property::create([
            'name' => Str::random(10),
            'address'=>Str::random(10),
            'property_type_id' =>  $property_type_id->id,
            'fields' =>json_encode($search_fields) ,
        ]);

         //search profile seeder
        $search_fields=[
            "price"=>[0,rand()],
            "area"=>[rand(), null],
            "yearOfConstruction"=>["2020",null],
            "rooms"=>["4,",null],
            "returnActual"=>["15",null]
        ];
       $property_type_id= PropertyType::first();
        SearchProfile::create([
            'name' => Str::random(10),
            'property_type_id' =>  $property_type_id->id,
            'search_fields' =>json_encode($search_fields) ,
        ]);
    }
}
