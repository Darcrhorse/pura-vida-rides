<?php
namespace App\Http\Controllers;
use App\Models\Trip; use Illuminate\Http\Request;
class SearchController extends Controller{
  public function index(Request $r){
    $trips=collect();
    if($r->filled(["from","to"])||$r->filled("date")){
      $q=Trip::with("driver")->where("status","open");
      if($r->from) $q->where("start_city","like","%".$r->from."%");
      if($r->to)   $q->where("end_city","like","%".$r->to."%");
      if($r->date) $q->whereDate("depart_at",$r->date);
      $trips=$q->orderBy("depart_at")->get();
    }
    return view("search.index",compact("trips"));
  }
}
