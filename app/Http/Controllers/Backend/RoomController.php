<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Amenity;
use App\Models\Photo;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManagerStatic as Image;

class RoomController extends Controller
{
    public function create(Request $request, $hotelId)
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

    public function showHotelForm($hotelId, $roomId)
    {
        $room = Room::with('photos', 'amenities')->findOrFail($roomId);
        $amenities = DB::table('amenities')->get();
        $roomTypes = DB::table('room_types')->get();

        return view('admin.room_show', compact('room', 'amenities', 'roomTypes'));
    }

    public function update(Request $request, $hotelId, $roomId)
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

    public function deletePhoto(Request $request, $roomId, $photoId)
    {
        $photo = Photo::findOrFail($photoId);

        if (file_exists(public_path($photo->path))) {
            unlink(public_path($photo->path));
        }

        $photo->delete();

        return redirect()->back()->with('status', 'Фото видалено!');
    }
}
