<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function markAsRead($id){
        $notification = auth()->user()->notifications()->findOrFail($id);

        $notification->markAsRead();

        return redirect($notification->data['url']);
    }

    public function markAllRead(){
        $notifications = auth()->user()->unreadNotifications->markAsRead();

        return back();
    }
}
