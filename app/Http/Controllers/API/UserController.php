<?php

namespace App\Http\Controllers\API;

use Throwable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\Http\Responses\ApiErrorResponse;
use App\Http\Responses\ApiSuccessResponse;

class UserController extends Controller
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function list(Request $request)
    {
        try {
            $data = $this->userRepository->list($request);

            return new ApiSuccessResponse(
                $data,
                'Retrieved User List Successfully.',
                Response::HTTP_CREATED
            );
        } catch (Throwable $exception) {
            return new ApiErrorResponse(
                $exception->getMessage(),
                $exception
            );
        }
    }
}
