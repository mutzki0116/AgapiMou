<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\tbl_notifications;
use Dotenv\Regex\Success;

class notificationController extends Controller
{
    

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getNotifs() {
        $weight = \DB::select(\DB::raw('CHECKSUM TABLE tbl_notifications'));
        $notifs = tbl_notifications::select('tbl_notifications.id', 'notif_title', 'notif_message', 'isRead', 'link', 'users.name', 'tbl_notifications.created_at')->where('notif_destination_user_id', \Auth::user()->id)->join('users', 'users.id', '=', 'tbl_notifications.notif_source_user_id')->get();
        return response([
            'notifications' => $notifs,
            'checksum' => $weight
        ]);
    }

    public function changeStatus(Request $request, $id) {
        $validator = \Validator::make($request->all(), [
            'status' => 'required'
        ]);

        if($validator->fails()) {
            return response([
                'success' => false
            ]);
        }

        tbl_notifications::where('id', $id)->update([
            'isRead' => $request->status
        ]);


        return response([
            'success' => true
        ]);
    }

}
