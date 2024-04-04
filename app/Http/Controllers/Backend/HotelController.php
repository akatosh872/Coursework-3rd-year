<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    public function showCreateHotelForm ()
    {
        return view('admin.hotel_create');
    }

    public function showHotelForm ($id)
    {
        $hotel = Hotel::FindOrFail($id);
        return view('admin.hotel_show', compact('hotel'));
    }

    public function createHotel(Request $request)
    {
        // Валідація даних форми
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'location' => 'required|string',
            'stars' => 'required|integer|min:1|max:5',
            'price' => 'required|numeric|min:0',
        ]);

        if ($request->hasFile('photo')) {
            $photoName = time().'.'.$request->photo->extension();
            $request->photo->move(public_path('images'), $photoName);
            $photoPath = 'images/'.$photoName;
        }

        // Створення нового готелю
        Hotel::create([
            'name' => $request->name,
            'description' => $request->description,
            'location' => $request->location,
            'stars' => $request->stars,
            'price' => $request->price,
            'photo' => $photoPath,
            'admin_id' => auth('admin')->id(), // Підставляємо ID поточного адміна
        ]);

        // Повідомлення про успішне створення готелю та перенаправлення
//        return redirect()->route('admin.hotels.index')->with('success', 'Готель успішно створено!');
    }

    public function update(Request $request, $id)
    {
        $hotel = Hotel::findOrFail($id);

        // Валідація даних форми для оновлення готелю
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'required|string',
            'stars' => 'required|integer|min:1|max:5',
            'price' => 'required|numeric|min:0',
        ]);

        if ($request->hasFile('photo')) {
            $photoName = time().'.'.$request->photo->extension();
            $request->photo->move(public_path('images'), $photoName);
            $photoPath = 'images/'.$photoName;
        } else {
            $photoPath = $hotel->photo; // Якщо фото не було завантажено, зберігаємо старий шлях
        }

        $hotel->update([
            'name' => $request->name,
            'description' => $request->description,
            'location' => $request->location,
            'stars' => $request->stars,
            'price' => $request->price,
            'photo' => $photoPath,
        ]);

        return redirect()->route('hotel.show', $hotel->id)->with('success', 'Готель оновлено!');
    }
}
