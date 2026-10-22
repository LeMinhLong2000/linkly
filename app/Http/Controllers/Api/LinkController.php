<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLinkRequest;
use App\Services\LinkService;
use Illuminate\Http\JsonResponse;

class LinkController extends Controller
{
    public function store(
        StoreLinkRequest $request,
        LinkService $linkService
    ): JsonResponse {
        $link = $linkService->create(
            $request->validated('url')
        );

        return response()->json([
            'data' => [
                'code' => $link->code,
                'short_url' => url('/' . $link->code),
                'original_url' => $link->original_url,
            ],
        ], 201);
    }
}

// - Laravel tự inject StoreLinkRequest và LinkService qua dependency injection.
// - $request->validated('url') chỉ lấy dữ liệu đã qua validation.
// - HTTP 201 Created biểu thị việc tạo tài nguyên thành công.