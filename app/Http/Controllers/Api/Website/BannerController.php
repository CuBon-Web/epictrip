<?php

namespace App\Http\Controllers\Api\Website;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\models\website\Banner;

class BannerController extends Controller
{
    public function createOrUpdate(Request $request)
    {
        if ($request->data) {
            Banner::truncate();
            foreach ($request->data as $key => $value) {
                Banner::create([
                    'image'       => $value['image'] ?? '',
                    'status'      => isset($value['status']) ? (int) $value['status'] : 1,
                    'title'       => $this->normalizeMultilang($value['title'] ?? null),
                    'subtitle'    => $this->normalizeMultilang($value['subtitle'] ?? null),
                    'description' => $this->normalizeMultilang($value['description'] ?? null),
                    'link'        => $value['link'] ?? '',
                ]);
            }
        }

        return response()->json([
            'messenge' => 'success'
        ], 200);
    }

    public function list()
    {
        $data = Banner::orderBy('id', 'ASC')->get();

        return response()->json([
            'messenge' => 'success',
            'data'     => $data
        ], 200);
    }

    /**
     * Always store multi-language fields as a JSON-encoded array
     * of {lang_code, content} so languageName() helper can read it.
     */
    private function normalizeMultilang($value)
    {
        if (is_array($value)) {
            return json_encode(array_values($value), JSON_UNESCAPED_UNICODE);
        }

        if (is_string($value) && $value !== '') {
            $decoded = json_decode($value, true);
            if (is_array($decoded)) {
                return json_encode(array_values($decoded), JSON_UNESCAPED_UNICODE);
            }
            return json_encode([
                ['lang_code' => 'vi', 'content' => $value],
            ], JSON_UNESCAPED_UNICODE);
        }

        return json_encode([
            ['lang_code' => 'vi', 'content' => ''],
        ], JSON_UNESCAPED_UNICODE);
    }
}
