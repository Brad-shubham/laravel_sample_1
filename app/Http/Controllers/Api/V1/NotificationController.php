<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function getNotification(Request $request)
    {
        $page_no = is_null($request->input('page')) ? 1 : $request->input('page');
        $page_size = $request->input('page_size');
        $user = Auth::user();
        $per_page = is_null($page_size) ? 10 : $page_size;
        $offset = (is_null($page_no) || $page_no == 1) ? 0 : ($page_no - 1) * $per_page;

        $user_notifications = [];

        $total_page = (int)ceil(count($user->notifications) / $per_page);

        foreach ($user->notifications as $notification) {
            array_push($user_notifications, (object)['notification' => $notification->data,
                'read_at' => $notification->read_at,
                'created_at' => $notification->created_at,
                'updated_at' => $notification->updated_at,]);
        }

        $data = ['data' => array_slice($user_notifications, $offset, $per_page), 'page' => $page_no, 'page_size' => $per_page, 'total_page' => $total_page];
        return response()->json($data, 200);
    }
}
