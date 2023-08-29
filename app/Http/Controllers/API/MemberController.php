<?php

namespace App\Http\Controllers\API;

use Throwable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Repositories\MemberRepository;
use App\Http\Responses\ApiErrorResponse;
use App\Http\Responses\ApiSuccessResponse;

class MemberController extends Controller
{
    private $memberRepository;

    public function __construct(MemberRepository $memberRepository)
    {
        $this->memberRepository = $memberRepository;
    }

    public function list(Request $request)
    {
        try {
            $data = $this->memberRepository->list($request);

            return new ApiSuccessResponse(
                $data,
                'Retrieved Member List Successfully.',
                Response::HTTP_OK
            );
        } catch (Throwable $exception) {
            return new ApiErrorResponse(
                $exception->getMessage(),
                $exception
            );
        }
    }

    public function details(Request $request, $id)
    {
        try {
            $data = $this->memberRepository->details($request, $id);

            return new ApiSuccessResponse(
                $data,
                'Retrieved Member Details Successfully.',
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
