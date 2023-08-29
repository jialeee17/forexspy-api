<?php

namespace App\Repositories;

use App\Interfaces\TelegramUserRepositoryInterface;
use App\Models\TelegramUser;

class TelegramUserRepository implements TelegramUserRepositoryInterface
{
    public function list($request)
    {
        $offset = $request->offset;
        $limit = $request->limit;
        $page = $offset == 0 ? 1 : ($offset / $limit) + 1; // The page number to use as the starting point for pagination.
        $sort = $request->sort ?? 'id';
        $order = $request->order ?? 'asc';
        $searchUuid = $request->searchUuid;
        $searchMemberUuid = $request->searchMemberUuid;
        $searchTelegraphChatId = $request->searchTelegraphChatId;
        $searchUsername = $request->searchUsername;
        $searchFirstName = $request->searchFirstName;
        $searchLastName = $request->searchLastName;
        $searchLanguageCode = $request->searchLanguageCode;
        $isUnlinked = $request->isUnlinked; // To filter unlinked telegram users

        $telegramUsersBuilder = TelegramUser::when($isUnlinked, function ($query) {
            $query->whereNull('member_uuid');
        })
        ->when($searchUuid, function ($query) use ($searchUuid) {
            $query->where('uuid', $searchUuid);
        })
        ->when($searchMemberUuid, function ($query) use ($searchMemberUuid) {
            $query->where('member_uuid', $searchMemberUuid);
        })
        ->when($searchTelegraphChatId, function ($query) use ($searchTelegraphChatId) {
            $query->whereIn('telegraph_chat_id', $searchTelegraphChatId);
        })
        ->when($searchUsername, function ($query) use ($searchUsername) {
            $query->where('username', 'like', "%$searchUsername%");
        })
        ->when($searchFirstName, function ($query) use ($searchFirstName) {
            $query->where('first_name', 'like', "%$searchFirstName%");
        })
        ->when($searchLastName, function ($query) use ($searchLastName) {
            $query->where('last_name', 'like', "%$searchLastName%");
        })
        ->when($searchLanguageCode, function ($query) use ($searchLanguageCode) {
            $query->where('language_code', $searchLanguageCode);
        })
        ->when($searchLanguageCode, function ($query) use ($searchLanguageCode) {
            $query->where('language_code', $searchLanguageCode);
        })
        ->orderBy($sort, $order);

        if (isset($offset) && isset($limit)) {
            // Get the total number of records, regardless of pagination or filtering.
            $telegramUserNotFiltered = TelegramUser::count();

            $telegramUsers = $telegramUsersBuilder->paginate($limit, ['*'], 'page', $page);

            $data = [
                'total' => $telegramUsers->total(),
                'totalNotFiltered' => $telegramUserNotFiltered,
                'rows' => $telegramUsers->items(),
            ];

            return $data;
        }

        $telegramUsers = $telegramUsersBuilder->get();

        return $telegramUsers;
    }
}