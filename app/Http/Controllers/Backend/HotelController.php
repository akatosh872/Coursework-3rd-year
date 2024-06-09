<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Amenity;
use App\Models\Hotel;
use App\Models\RoomType;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Intervention\Image\ImageManagerStatic as Image;

class HotelController extends Controller
{
    /**
     * Повертає форму для створення готелю
     *
     * @return Application|Factory|View
     */
    public function showCreateHotelForm ()
    {
        return view('admin.hotel-create');
    }

    /**
     * Повертає сторінку готелю за id
     *
     * @param $id
     * @return Application|Factory|View
     */
    public function showHotelForm ($id)
    {
        $hotel = Hotel::FindOrFail($id);
        $roomTypes = RoomType::all();
        $amenities = Amenity::all();

        return view('admin.hotel-show', compact('hotel', 'roomTypes', 'amenities'));
    }

    /**
     * Повертає всі готелі адміна
     *
     * @return Application|Factory|View
     */
    public function showHotelsView()
    {
        $hotels = Hotel::where('admin_id', auth('admin')->id())->get();
        return view('admin.hotels', compact('hotels'));
    }

    /**
     * Видалення готелю за id. У моделі реалізовано каскадне видалення також номерів та бронювань
     *
     * @param Request $request
     * @param $id
     * @return RedirectResponse
     */
    public function deleteHotel(Request $request, $id): RedirectResponse
    {
        $hotel = Hotel::findOrFail($id);
        if ($hotel && $hotel->admin_id == auth('admin')->id()) {
            $hotel->delete();
            return redirect()->route('admin.hotels.list')->with('status', 'Готель успішно видалено!');
        }
        return redirect()->route('admin.hotels.list')->with('error', 'Готель не знайдено!');
    }


    /**
     * Створення готелю адміном
     * Валідація йде за всіма полями
     * Реалізовано ресайз зображень розміром 1280x720
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function createHotel(Request $request): RedirectResponse
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

        Hotel::create([
            'name' => $request->name,
            'description' => $request->description,
            'location' => $request->location,
            'stars' => $request->stars,
            'photo' => $photoPath,
            'admin_id' => auth('admin')->id(), // Підставляємо ID поточного адміна
        ]);

        return redirect()->route('admin.hotels.list')->with('status', 'Готель успішно створено!');
    }

    /**
     * Оновлення готелю за id
     * Валідація йде за всіма полями
     *
     * @param Request $request
     * @param $id
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $hotel = Hotel::findOrFail($id);

        $this->validate($request, [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'required|string',
            'stars' => 'required|integer|min:1|max:5',
        ]);

        if ($request->hasFile('photo')) {
            $photoName = time().'.'.$request->photo->extension();
            $photoPath = 'images/'.$photoName;

            $image = Image::make($request->photo->path());

            $image->resize(1280, 720);

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

        return redirect()->route('admin.hotel.details', $hotel->id)->with('status', 'Готель оновлено!');
    }
}
