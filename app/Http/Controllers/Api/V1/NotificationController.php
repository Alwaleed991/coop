<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{


    public function index(Request $request)
    {
        return response()->json([
            'notificationsCount' => $request->user()->notifications->count(),
            'notifications' => $request->user()->notifications, // here notifications is a relationship but we did not create relationship inside the user model right ?? yes but we have Notifiable trait which have the notifications and unreadNotifications relation ships, one return all the notification thats related to spicific user and the other return the non readed notifcation for spicific user also
        ], 200);
    }

    public function markAllAsRead(Request $request)
    {
        $request->user()->notifications()->delete();

        return response()->json([
            'message' => "all the notification are deleted"
        ], 200);
    }

    public function notificationsCount(Request $request)
    {
        return response()->json([
            'notificationsCount' => $request->user()->notifications->count(),
        ], 200);
    }
}
