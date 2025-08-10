<?php
namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory; 
use App\Models\Trip;

class TripFactory extends Factory
{
  protected $model = Trip::class;

  public function definition()
  {
    return [
      "start_city" => $this->faker->city(),
      "start_lat" => $this->faker->latitude(),
      "start_lng" => $this->faker->longitude(),
      "end_city" => $this->faker->city(),
      "end_lat" => $this->faker->latitude(),
      "end_lng" => $this->faker->longitude(),
      "depart_at" => now()->addDays(rand(1,10)),
      "max_seats" => rand(2,5),
      "price_per_seat" => rand(1000,5000),
      "status" => "open",
      "notes" => null
    ];
  }
}
