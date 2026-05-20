<?php

namespace App\Http\Controllers\Api\Website;

use App\Http\Controllers\Controller;
use App\models\website\WhyTravelWith;
use Illuminate\Http\Request;

class WhyTravelWithController extends Controller
{
    private function encodeMultilang($value)
    {
        if (is_array($value)) {
            return json_encode(array_values($value), JSON_UNESCAPED_UNICODE);
        }

        if (is_string($value) && $value !== '') {
            $decoded = json_decode($value, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                return json_encode(array_values($decoded), JSON_UNESCAPED_UNICODE);
            }

            return json_encode([
                ['lang_code' => 'en-US', 'content' => $value],
            ], JSON_UNESCAPED_UNICODE);
        }

        return json_encode([
            ['lang_code' => 'en-US', 'content' => ''],
        ], JSON_UNESCAPED_UNICODE);
    }

    public function createOrUpdate(Request $request)
    {
        $items = $request->data ?? $request->items;

        if ($items) {
            WhyTravelWith::truncate();

            foreach ($items as $key => $value) {
                WhyTravelWith::create([
                    'image' => $value['image'] ?? '',
                    'status' => $value['status'] ?? 1,
                    'sort_order' => $value['sort_order'] ?? $key,
                    'title' => $this->encodeMultilang($value['title'] ?? ''),
                    'description' => $this->encodeMultilang($value['description'] ?? ''),
                ]);
            }
        }

        return response()->json([
            'messenge' => 'success',
        ], 200);
    }

    public function list()
    {
        $data = WhyTravelWith::orderBy('sort_order')->orderBy('id')->get();

        return response()->json([
            'messenge' => 'success',
            'data' => $data,
        ], 200);
    }
}
