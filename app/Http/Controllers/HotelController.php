<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    public function showHotelsForm()
    {
        $hotels = Hotel::all();
        return view('hotels', compact('hotels'));
    }
}
