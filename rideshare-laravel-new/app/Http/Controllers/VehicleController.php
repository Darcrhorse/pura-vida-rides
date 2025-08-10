<?php
namespace App\Http\Controllers;
use App\Models\Vehicle; use Illuminate\Http\Request;
class VehicleController extends Controller{
  public function index(){
    return view('vehicles.index',[
      'vehicles' => auth()->user()->vehicles
    ]);
  }
  public function create(){
    return view('vehicles.create');
  }
  public function store(Request $r){
    $r->validate([
      'make' => 'required|string|max:50',
      'model' => 'required|string|max:50',
      'year' => 'required|digits:4',
      'color' => 'required|string|max:30',
      'license_plate' => 'required|string|max:15|unique:vehicles',
      'capacity' => 'required|integer|min:1|max:10',
      'features' => 'nullable|string'
    ]);
    auth()->user()->vehicles()->create($r->all());
    return redirect()->route('vehicles.index');
  }
  public function edit(Vehicle $v){
    return view('vehicles.edit',compact('v'));
  }
  public function update(Request $r,Vehicle $v){
    $r->validate([
      'make' => 'required|string|max:50',
      'model' => 'required|string|max:50',
      'year' => 'required|digits:4',
      'color' => 'required|string|max:30',
      'license_plate' => "required|string|max:15|unique:vehicles,license_plate,$v->id",
      'capacity' => 'required|integer|min:1|max:10',
      'features' => 'nullable|string'
    ]);
    $v->update($r->all());
    return redirect()->route('vehicles.index');
  }
  public function destroy(Vehicle $v){
    $v->delete();
    return back();
  }
}
