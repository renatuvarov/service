<?php

namespace App\Http\Controllers\Ajax;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class StatusController extends Controller
{
    public function toggleStatus($id, $ticket)
    {
        $query = DB::table('ticket_user')
            ->where('user_id', $id)
            ->where('ticket_id', $ticket);

        $status = $query->first()->status;
        $newStatus = $status === 'waiting' ? 'arrived' : 'waiting';

        $query->update(['status' => $newStatus]);

        return json_encode(['status' => $newStatus]);
    }
}
