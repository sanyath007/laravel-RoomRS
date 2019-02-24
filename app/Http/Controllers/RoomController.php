<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        $room->room_status = '1';

        if($room->save()) {
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
