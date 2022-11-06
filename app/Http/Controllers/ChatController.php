<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    // 新着順にメッセージ一覧を取得
    public function index()
    {
        // 以下ではログイン情報をフロントで使えるように処理している
        Inertia::share(
            'user',
            fn (Request $request) => $request->user()
                ? $request->user()->only('id', 'name', 'email')
                : null
        );

        // メッセージを一覧表示するために取得
        $messages = Message::query()
            ->with([
                'user',
            ])
            ->latest()
            ->paginate(5);

        return Inertia::render(
            'Chat',
            [
                'messages' => $messages->items(),
                'pager' => $messages,
            ]
        );
    }

    // メッセージを登録
    public function create(Request $request)
    {

        DB::beginTransaction();
        try {

            $message = new Message;
            $message->user_id = Auth::id();
            $message->body = $request->body;
            $message->save();

            DB::commit();
        } catch (\PDOException $e) {
            \Log::debug($e->getMessage());
            DB::rollback();
        }
    }
}
