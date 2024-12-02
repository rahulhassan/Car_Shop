<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\CarType;
use App\Models\City;
use App\Models\FavouriteCar;
use App\Models\FuelType;
use App\Models\Maker;
use App\Models\State;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){

        // $maker = Maker::factory()->create();
        // //dd($maker);

        // User::factory()->count(5)
        // ->create([
        //     'name'=> 'Rahul'
        // ]);
        // State::factory()
        // ->has(City::factory()->count(3) )
        // ->create();

        // Maker::factory()
        //     ->count(5)
        //     ->hasModels(5)
        //     ->create();

        // User::factory()
        //     ->has(Car::factory()->count(5), 'favouriteCars')->create();

        $cars = Car::where('published_at', '<', now())
            ->with(['primaryImage', 'maker', 'model', 'city', 'carType', 'fuelType'])
            ->orderBy('published_at', 'desc')
            ->limit(30)
            ->get();

        return view("home.index", ['cars'=> $cars] );
    }
}
