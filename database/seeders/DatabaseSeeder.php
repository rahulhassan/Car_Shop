<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Car;
use App\Models\CarImage;
use App\Models\CarType;
use App\Models\City;
use App\Models\FuelType;
use App\Models\Maker;
use App\Models\Model;
use App\Models\State;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        CarType::factory()
        ->sequence(
            ['name' =>'Sedan'], 
            ['name' =>'SUV'], 
            ['name' =>'Truck'], 
            ['name' =>'Van'], 
            ['name' =>'Coupe'], 
            ['name' =>'Crossover'],
            ['name' =>'Hatchback'],
            ['name' =>'Sports Car'],
            ['name' =>'Jeep']
        )
        ->count(9)
        ->create();

        FuelType::factory()
        ->sequence(
            ['name' => 'Diesel'], 
            ['name' => 'Petrol'], 
            ['name' => 'LPG'], 
            ['name' => 'Electricity'], 
            ['name' => 'Ethanol'], 
            ['name' => 'Hydrogen']
        )
        ->count(6)
        ->create();

        $states = [
            "California" => ["Los Angeles", "San Francisco", "San Diego", "Sacramento"],
            "Texas" => ["Houston", "Austin", "Dallas", "San Antonio"],
            "Florida" => ["Miami", "Orlando", "Tampa", "Jacksonville"],
            "New York" => ["New York City", "Buffalo", "Rochester", "Albany"],
            "Illinois" => ["Chicago", "Aurora", "Naperville", "Peoria"],
            "Nevada" => ["Las Vegas", "Reno", "Henderson", "Carson City"],
            "Georgia" => ["Atlanta", "Augusta", "Columbus", "Savannah"],
            "Ohio" => ["Columbus", "Cleveland", "Cincinnati", "Toledo"],
            "Washington" => ["Seattle", "Spokane", "Tacoma", "Bellevue"],
            "Arizona" => ["Phoenix", "Tucson", "Mesa", "Chandler"]
        ];

        foreach($states as $state => $cities){
            State::factory()
            ->state(['name'=>$state])
            ->has(
                City::factory()
                ->count(count($cities))
                ->sequence(...array_map(fn($city)=>['name'=>$city], $cities))
            )
            ->create();
        }


        $makers = [
            "Toyota" => ["Corolla", "Camry", "RAV4", "Highlander"],
            "Ford" => ["F-150", "Mustang", "Explorer", "Focus"],
            "Honda" => ["Civic", "Accord", "CR-V", "Pilot"],
            "Chevrolet" => ["Silverado", "Malibu", "Equinox", "Traverse"],
            "BMW" => ["3 Series", "X5", "5 Series", "M4"],
            "Mercedes-Benz" => ["C-Class", "E-Class", "S-Class", "GLC"],
            "Audi" => ["A4", "Q5", "A6", "Q7"],
            "Volkswagen" => ["Golf", "Passat", "Tiguan", "Jetta"],
            "Nissan" => ["Altima", "Sentra", "Rogue", "Murano"],
            "Hyundai" => ["Elantra", "Sonata", "Tucson", "Santa Fe"]
        ];
        foreach($makers as $maker => $models)
        Maker::factory()
        ->state(['name'=>$maker])
        ->has(
            Model::factory()
            -> Count(count($models))
            ->sequence(...array_map(fn($model)=>['name'=>$model], $models))
            
        )
        ->create();

        User::factory()
        ->count(3)
        ->create();

        User::factory()
        ->count(2)
        ->has(
            Car::factory()
            ->count(50)
            ->has(
                CarImage::factory()
                ->count(5)
                ->sequence(fn (Sequence $sequence)=>['position'=>$sequence->index % 5 + 1]),
                'images'
            )
            ->hasFeatures(),
             'favouriteCars'
        )
        ->create();
    }
}
