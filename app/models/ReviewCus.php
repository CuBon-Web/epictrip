<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class ReviewCus extends Model
{
    protected $table = "reviewcus";
    public function saveReviewCus($request)
    {
    	$id = $request->id;
        if($id != ""){
            $query = ReviewCus::where([
                'id' => $id
             ])->first();
            if ($query) {
                $query->name = $this->normalizeMultilang($request->name);
                $query->position = $this->normalizeMultilang($request->position);
                $query->content = $this->normalizeMultilang($request->content);
                $query->status = $request->status;
                $query->avatar = $request->avatar;
                $query->save();
            }else{
                $query = new ReviewCus();
                $query->name = $this->normalizeMultilang($request->name);
                $query->position = $this->normalizeMultilang($request->position);
                $query->content = $this->normalizeMultilang($request->content);
                $query->status = $request->status;
                $query->avatar = $request->avatar;
                $query->save();
            }
            
        }else{
                $query = new ReviewCus();
                $query->name = $this->normalizeMultilang($request->name);
                $query->position = $this->normalizeMultilang($request->position);
                $query->content = $this->normalizeMultilang($request->content);
                $query->status = $request->status;
                $query->avatar = $request->avatar;
                $query->save();
            
        }
        return $query;
    }

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
                ['lang_code' => 'en-US', 'content' => $value],
            ], JSON_UNESCAPED_UNICODE);
        }

        return json_encode([
            ['lang_code' => 'en-US', 'content' => ''],
        ], JSON_UNESCAPED_UNICODE);
    }
}
