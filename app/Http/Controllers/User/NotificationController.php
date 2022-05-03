<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

class NotificationController extends Controller
{
    public function markAsRead($order_id, $id)
    {
        $userUnreadNoti = auth()->user()->unreadNotifications->where('id', $id)->first();
    
        if ($userUnreadNoti) {
            $userUnreadNoti->markAsRead();
        }
        
        return redirect()->route('order.detail', $order_id);
    }

    public function markAsReadAll()
    {
        $userUnreadNoti = auth()->user()->unreadNotifications;
    
        if ($userUnreadNoti) {
            $userUnreadNoti->markAsRead();
        }

        return redirect()->back();
    }
}
