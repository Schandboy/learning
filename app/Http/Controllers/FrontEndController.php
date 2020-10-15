<?php

namespace App\Http\Controllers;

use App\Series;
use Illuminate\Http\Request;

class FrontEndController extends Controller
{
   public function index(){
       $this->setSeo('Learning Home','Lets Learn');
       return view('welcome')->withSeries(Series::all());
   }

   public function series(Series $series){
       $this->setSeo('Learning Series','Lets Learn Series');
       return view('series')->withSeries($series);
   }
}
