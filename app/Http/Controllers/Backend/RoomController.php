<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Amenity;
use App\Models\Photo;
use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManagerStatic as Image;

class RoomController extends Controller
{
    /**
     * Створення номеру до готеля
     * Метод обробляє та зберігає лише 3 зображення
     * Ресайз зображень 1280x720
     *
     * @param Request $request
     * @param $hotelId
     * @return RedirectResponse
     */
    public function create(Request $request, $hotelId): RedirectResponse
    {
        $room = new Room();
        $room->hotel_id = $hotelId;
        $room->type_id = $request->type_id;
        $room->beds = $request->beds;
        $room->price_per_night = $request->price_per_night;
        $room->square_meters = $request->square_meters;
        $room->number = $request->number;
        $room->save();

        for ($i = 1; $i <= 3; $i++) {
            $photoField = 'photo' . $i;
            if ($request->hasFile($photoField)) {
                $photoName = time() . '_' . $i . '.' . $request->$photoField->extension();
                $photoPath = 'images/' . $photoName;

                $image = Image::make($request->$photoField->path());

                $image->resize(1280, 720);

                $image->save(public_path($photoPath));

                $photo = new Photo();
                $photo->path = $photoPath;
                $photo->room_id = $room->id;
                $photo->save();
            }
        }

        $room->amenities()->sync($request->amenities);

        return redirect()->back()->with('status', 'Номер створено!');
    }

    /**
     * Метод повертає сторінку номеру готеля
     *
     * @param $hotelId
     * @param $roomId
     * @return Application|Factory|View
     */
    public function showRoomForm($hotelId, $roomId)
    {
        $room = Room::with('photos', 'amenities')->findOrFail($roomId);
        $amenities = Amenity::all();
        $roomTypes = RoomType::all();

        return view('admin.room_show', compact('room', 'amenities', 'roomTypes'));
    }

    /**
     * Оновлення номеру готеля
     * При оновленні можна завантажити більше 3 зображень
     *
     * @param Request $request
     * @param $hotelId
     * @param $roomId
     * @return RedirectResponse
     */
    public function update(Request $request, $hotelId, $roomId): RedirectResponse
    {
        $room = Room::findOrFail($roomId);

        if ($request->has('photos')) {
            foreach ($request->file('photos') as $file) {
                $photoName = time() . '_' . $file->getClientOriginalName();
                $photoPath = 'images/' . $photoName;

                $image = Image::make($file->path());
                $image->resize(1280, 720);
                $image->save(public_path($photoPath));

                $photo = new Photo();
                $photo->path = $photoPath;
                $photo->room_id = $room->id;
                $photo->save();
            }
        }

        $room->update($request->all());

        $room->amenities()->sync($request->amenities);

        return redirect()->back()->with('status', 'Номер оновлено!');
    }

    /**
     * Видалення фото з БД та файлу
     *
     * @param Request $request
     * @param $roomId
     * @param $photoId
     * @return RedirectResponse
     */
    public function deletePhoto(Request $request, $roomId, $photoId): RedirectResponse
    {
        $photo = Photo::findOrFail($photoId);

        if (file_exists(public_path($photo->path))) {
            unlink(public_path($photo->path));
        }

        $photo->delete();

        return redirect()->back()->with('status', 'Фото видалено!');
    }
}
