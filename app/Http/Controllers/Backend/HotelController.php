<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManagerStatic as Image;

class HotelController extends Controller
{
    public function showCreateHotelForm ()
    {
        return view('admin.hotel_create');
    }

    public function showHotelForm ($id)
    {
        $hotel = Hotel::FindOrFail($id);
        $roomTypes = DB::table('room_types')->get();
        $amenities = DB::table('amenities')->get();

        return view('admin.hotel_show', compact('hotel', 'roomTypes', 'amenities'));
    }

    public function showHotelsView()
    {
        $hotels = Hotel::where('admin_id', auth('admin')->id())->get();
        return view('admin.hotels', compact('hotels'));
    }

    public function deleteHotel(Request $request, $id)
    {
        $hotel = Hotel::findOrFail($id);
        if($hotel && $hotel->admin_id == auth('admin')->id()) {
            $hotel->delete();
            return redirect()->route('admin.hotels.show')->with('status', 'Готель успішно видалено!');
        }
        return redirect()->route('admin.hotels.show')->with('error', 'Готель не знайдено!');
    }


    public function createHotel(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string|min:10',
            'location' => 'required|string',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'stars' => 'required|integer|min:1|max:5',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        if ($request->hasFile('photo')) {
            $photoName = time().'.'.$request->photo->extension();
            $photoPath = 'images/'.$photoName;

            $image = Image::make($request->photo->path());
            $image->resize(1280, 720);

            $image->save(public_path($photoPath));
        }

        // Створення нового готелю
        Hotel::create([
            'name' => $request->name,
            'description' => $request->description,
            'location' => $request->location,
            'stars' => $request->stars,
            'photo' => $photoPath,
            'admin_id' => auth('admin')->id(), // Підставляємо ID поточного адміна
        ]);

        // Повідомлення про успішне створення готелю та перенаправлення
        return redirect()->route('admin.hotels.show')->with('status', 'Готель успішно створено!');
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
        ]);

        if ($request->hasFile('photo')) {
            $photoName = time().'.'.$request->photo->extension();
            $photoPath = 'images/'.$photoName;

            // Завантажте зображення
            $image = Image::make($request->photo->path());

            // Змініть розмір зображення до 1280x720
            $image->resize(1280, 720);

            // Збережіть зображення
            $image->save(public_path($photoPath));
        } else {
            $photoPath = $hotel->photo; // Якщо фото не було завантажено, зберігаємо старий шлях
        }

        $hotel->update([
            'name' => $request->name,
            'description' => $request->description,
            'location' => $request->location,
            'stars' => $request->stars,
            'photo' => $photoPath,
        ]);

        return redirect()->route('admin.hotel.show', $hotel->id)->with('status', 'Готель оновлено!');
    }
}
