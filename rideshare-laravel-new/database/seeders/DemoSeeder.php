<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder; 
use App\Models\{User,Trip,Booking,Post};

class DemoSeeder extends Seeder
{
  public function run(): void
  {
    $driver = User::factory()->create([
      'email' => 'driver@example.test',
      'email_verified_at' => now()
    ]);
    
    $rider = User::factory()->create([
      'email' => 'rider@example.test',
      'email_verified_at' => now()
    ]);

    Trip::factory()->count(3)->create([
      'driver_id' => $driver->id,
      'status' => 'open'
    ]);
  }
}
