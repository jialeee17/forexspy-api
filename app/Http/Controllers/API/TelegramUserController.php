<?php

namespace App\Http\Controllers\API;

use Throwable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Repositories\TelegramUserRepository;
use App\Http\Responses\ApiErrorResponse;
use App\Http\Responses\ApiSuccessResponse;

class TelegramUserController extends Controller
{
    private $telegramUserRepository;

    public function __construct(TelegramUserRepository $telegramUserRepository)
    {
        $this->telegramUserRepository = $telegramUserRepository;
    }

    public function list(Request $request)
    {
        try {
            $data = $this->telegramUserRepository->list($request);

            return new ApiSuccessResponse(
                $data,
                'Retrieved Telegram User List Successfully.',
                Response::HTTP_OK
            );
        } catch (Throwable $exception) {
            return new ApiErrorResponse(
                $exception->getMessage(),
                $exception
            );
        }
    }
}
