<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;
use App\Models\Room;

class RoomController extends Controller
{
    public function list()
    {
    	return view('rooms.list', [
            'rooms' => Room::where(['room_status' => 1])->paginate(6)
        ]);
    }

    public function detail($roomId)
    {
        return view('rooms.detail', [
            'room' => Room::find($roomId)
        ]);
    }

    public function add()
    {
    	return view('rooms.add');
    }

    public function store(Request $req)
    {
        // $lastId = $this->generateAutoId();

        $room = new Room();
        $room->room_name        = $req['room_name'];
        $room->room_size        = $req['room_size'];
        $room->room_capacity    = $req['room_capacity'];
        $room->room_locate      = $req['room_locate'];
        $room->room_pay_rate    = $req['room_pay_rate'];
        $room->room_reserv_max  = $req['room_reserve_max'];
        $room->room_contact_tel = $req['room_contact_tel'];
        $room->room_detail      = $req['room_detail'];
        $room->room_img1        = 'photo';
        $room->room_img2        = 'thumbnail';
        $room->room_status      = '1';

        /** Upload file */
        $file   = $req->file('room_img')[0];
        $name   = $req->file('room_img')[0]->getClientOriginalName();
        $ext    = $req->file('room_img')[0]->getClientOriginalExtension();        
        $image  = Image::make($file->getRealPath());

        if($room->save()) {
            $lastId     = $room->room_id;
        
            File::makeDirectory(public_path().'/uploads/rooms/'.$lastId, 0775, true);            
            $image_path = public_path().'/uploads/rooms/'.$lastId;

            $photo      = $image->resize(960, 540);
            $photo->save($image_path. '/photo.'.$ext);

            $thumbnail  = $image->resize(250, 141);
            $thumbnail->save($image_path. '/thumbnail.'.$ext);

            return [
                "status" => "success",
                "message" => "Insert success.",
            ];
        } else {
            return [
                "status" => "error",
                "message" => "Insert failed.",
            ];
        }
    }

    public function getById($roomId)
    {
        return [
            'room' => Room::find($roomId),
        ];
    }

    public function edit($roomId)
    {
        return view('rooms.edit', [
            'room' => Room::find($roomId)
        ]);
    }

    public function update(Request $req)
    {
        $room = Room::find($req['room_id']);

        $room->room_name        = $req['room_name'];
        $room->room_size        = $req['room_size'];
        $room->room_capacity    = $req['room_capacity'];
        $room->room_locate      = $req['room_locate'];
        $room->room_pay_rate    = $req['room_pay_rate'];
        $room->room_reserv_max  = $req['room_reserve_max'];
        $room->room_contact_tel = $req['room_contact_tel'];

        if($room->save()) {
            return [
                "status" => "success",
                "message" => "Update success.",
            ];
        } else {
            return [
                "status" => "error",
                "message" => "Update failed.",
            ];
        }
    }

    public function delete($roomId)
    {
        $room = Room::find($roomId);

        if($room->delete()) {
            return [
                "status" => "success",
                "message" => "Delete success.",
            ];
        } else {
            return [
                "status" => "error",
                "message" => "Delete failed.",
            ];
        }
    }
}
