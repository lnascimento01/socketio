<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ChatController extends Controller
{
    public function index(Request $request)
    {
        $actualUser = $request->user;
        $userJson = File::get(public_path('usuarios-json.txt'));
        $users = json_decode($userJson);
        $messagesJson = File::get(public_path('messages/historico-conversas-participantes-json.json'));
        $histories = json_decode($messagesJson, true);
        $allMessages = [];
        $filteredMessages = [];
        $filteredUsers = [];

        foreach ($users as $user) {
            if ($actualUser != $user->nome) {
                $filteredUsers[] = $user;
            }
        }

        $desiredParticipants = [$actualUser, current($filteredUsers)->nome];

        foreach ($histories as $history) {
            $participants = $history['participantes'];

            if (!in_array($actualUser, $participants)) {
                continue;
            }


            foreach ($history['mensagens'] as $key => $usersMessages) {
                $date = Carbon::parse($usersMessages['data']);
                $date->locale('pt_BR');

                $history['mensagens'][$key]['date'] = ucfirst($date->isoFormat('dddd'));
            }

            if (array_intersect($desiredParticipants, $participants) == $desiredParticipants) {
                $filteredMessages = $history;
            }

            $allMessages[] = $history;
        }

        $filteredMessages = empty($filteredMessages) ? ['mensagens' => []] : $filteredMessages;

        return view(
            'chatTemplate',
            $request->all(),
            [
                'actualUser' => $actualUser,
                'users' => $filteredUsers,
                'initialMessages' => $filteredMessages,
                'messages' => json_encode($allMessages)
            ]
        );
    }
}
