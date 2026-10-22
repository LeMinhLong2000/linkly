<?php

namespace App\Services;

use App\Models\Link;
use Illuminate\Support\Str;
use RuntimeException;

class LinkService
{
    public function create(string $url): Link
    {
        for ($attempt = 0; $attempt < 5; $attempt++) {
            $code = Str::random(8);

            if (Link::where('code', $code)->exists()) {
                continue;
            }

            return Link::create([
                'original_url' => $url,
                'code' => $code,
                'is_active' => true,
            ]);
        }

        throw new RuntimeException(
            'Could not generate a unique short code.'
        );
    }
}


// 1. Sinh mã ngẫu nhiên.
// 2. Kiểm tra mã đã tồn tại hay chưa.
// 3. Nếu trùng, thử sinh mã khác.
// 4. Nếu không trùng, lưu bản ghi.
// 5. Nếu thử 5 lần vẫn không thành công, báo lỗi.