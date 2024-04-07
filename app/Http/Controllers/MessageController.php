<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class MessageController extends Controller
{
    public function index(Request $request)
    {
        $messagesJson = File::get(public_path('messages/historico-conversas-participantes-json.json'));
        $data = json_decode($messagesJson, true);
        $participants = [$request->remetente, $request->receiver];
        $currentDate = date('Y-m-d');
        $currentHour = date('H:i');
        $newHistory = true;

        // Iterar sobre cada item do JSON
        foreach ($data as $key => $conversation) {
            $totalConversationParticipants = count($conversation['participantes']);
            $totalNewMessageParticipants = count($participants);
            if (
                $totalConversationParticipants === $totalNewMessageParticipants
                && empty(array_diff($participants, $conversation['participantes']))
            ) {
                $newHistory = false;

                $newMessage = [
                    "remetente" => $request->remetente,
                    "destinatario" => $request->receiver,
                    "data" => $currentDate,
                    "hora" => $currentHour,
                    "mensagem" => $request->mensagem,
                    "anexo" => $request->attachment,
                    "status" => $request->status ?? true
                ];

                $data[$key]['mensagens'][] = $newMessage;
            }
        }

        if ($newHistory) {
            $newMessage = [
                "remetente" => $request->remetente,
                "destinatario" => $request->receiver,
                "data" => $currentDate,
                "hora" => $currentHour,
                "mensagem" => $request->mensagem,
                "anexo" => $request->attachment,
                "status" => $request->status ?? true
            ];

            $data[] = [
                'participantes' => $participants,
                'mensagens' => [$newMessage]
            ];
        }

        $put = FILE::put(public_path('messages/historico-conversas-participantes-json.json'), json_encode($data));

        return $put;
    }

    public function update(Request $request)
    {
        $messagesJson = File::get(public_path('messages/historico-conversas-participantes-json.json'));
        $data = json_decode($messagesJson, true);
        $participants = [$request->remetente, $request->receiver];

        // Iterar sobre cada item do JSON
        foreach ($data as $key => $conversation) {
            $totalConversationParticipants = count($conversation['participantes']);
            $totalNewMessageParticipants = count($participants);
            if (
                $totalConversationParticipants === $totalNewMessageParticipants
                && empty(array_diff($participants, $conversation['participantes']))
            ) {
                foreach ($conversation as $messageKey => $messages) {
                    $data[$key]['mensagens'][$messageKey]['status'] = false;
                }
            }
        }

        $put = FILE::put(public_path('messages/historico-conversas-participantes-json.json'), json_encode($data));

        return $put;
    }
}
