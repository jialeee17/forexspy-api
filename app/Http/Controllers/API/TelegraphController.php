<?php

namespace App\Http\Controllers\API;

use Exception;
use Illuminate\Http\Request;
use App\Models\TelegraphChat;
use App\Http\Controllers\Controller;
use App\Http\Responses\ApiErrorResponse;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Responses\ApiSuccessResponse;

class TelegraphController extends Controller
{
    public function getPendingCommands(Request $request, $userUuid)
    {
        try {
            $chat = TelegraphChat::whereHas('user', function (Builder $query) use ($userUuid) {
                $query->where('uuid', $userUuid);
            })->firstOrFail();

            $pendingCommands = $chat->pending_commands;

            return new ApiSuccessResponse(
                $pendingCommands,
                str_replace(':name', 'Pending Commands', __('messages.retrieve.success')),
            );
        } catch (Exception $e) {
            return new ApiErrorResponse(
                $e->getMessage(),
                $e,
            );
        }
    }

    public function removePendingCommand(Request $request, $userUuid)
    {
        try {
            $request->validate([
                'command' => ['required', 'string']
            ]);

            $command = $request->command;

            $chat = TelegraphChat::whereHas('user', function (Builder $query) use ($userUuid) {
                $query->where('uuid', $userUuid);
            })->firstOrFail();

            $pendingCommands = $chat->pending_commands;

            if (!in_array($command, $pendingCommands)) {
                throw new Exception ('Command is not found in the list');
            }

            // Remove Command from Pending List
            $chat->update(['pending_commands' => array_diff($pendingCommands, [$command])]);

            return new ApiSuccessResponse(
                [],
                str_replace(':name', 'Pending Command', __('messages.update.success')),
            );
        } catch (Exception $e) {
            return new ApiErrorResponse(
                $e->getMessage(),
                $e,
            );
        }
    }
}
