<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


class SearchMessageController extends Controller
{
    public function index(Request $request)
    {

        if ($request->has('param1') || $request->has('param2') || $request->has('param3')) {
            if ($request->has('param3')) {
                $sql = 'select ' . $request->param3;
            }

            if ($request->has('param2')) {
                $sql = 'select ' . $request->param2;
                if ($request->has('param3')) {
                    $sql = $sql . ',' . $request->param3;
                }
            }

            if ($request->has('param1')) {
                $sql = 'select ' . $request->param1;
                if ($request->has('param2')) {
                    $sql = $sql . ',' . $request->param2;
                }
                if ($request->has('param3')) {
                    $sql = $sql . ',' . $request->param3;
                }
            }




            $sql = $sql . ' from messages m inner join users u on u.id = m.user_id';

            if ($request->has('message')) {
                $sql = $sql . ' where m.body like "%' . $request->message . '%";';
            }


            // $sql = 'select * from users';
            $viewVariable = DB::select($sql);
            $viewVariable = json_decode(json_encode($viewVariable), true);
            // dd($viewVariable);
        } else {
            $viewVariable = [];
        }

        // dd($viewVariable);
        return view('search_messages', ['all' =>  $viewVariable]);
    }
}
