<?php

namespace App\models\tag;

use Illuminate\Database\Eloquent\Model;
use App\models\tag\TagCate;
use App\models\product\Category;

class Tags extends Model
{
    protected $table = "tags";
    public function FunctionName() : Returntype {
        
    }
    public function cateTag()
    {
        return $this->hasOne(TagCate::class,'id','cate_tag_id');
    }
    public function catePro()
    {
        return $this->hasOne(Category::class,'id','cate_product_id');
    }
    public function saveTags($request)
    {
        $cat = TagCate::where('id', $request->cate_tag_id)->first();
        $id = $request->id;
        $nameJson = $this->normalizeMultilang($request->name);
        $slugSource = $this->extractFirstContent($request->name);

        if ($id != "") {
            $query = Tags::where(['id' => $id])->first();
            if (!$query) {
                $query = new Tags();
            }
        } else {
            $query = new Tags();
        }

        $query->name = $nameJson;
        $query->slug = to_slug($slugSource);
        $query->cate_tag_id = $request->cate_tag_id;
        $query->cate_tag_slug = $cat ? $cat->slug : '';
        $query->cate_product_id = 0;
        $query->status = $request->status;
        $query->image = $request->image;
        $query->content = $this->normalizeMultilang($request->content);
        $query->save();

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

    private function extractFirstContent($value)
    {
        if (is_array($value)) {
            foreach ($value as $row) {
                if (!empty($row['content'])) {
                    return $row['content'];
                }
            }
            return '';
        }
        if (is_string($value) && $value !== '') {
            $decoded = json_decode($value, true);
            if (is_array($decoded)) {
                foreach ($decoded as $row) {
                    if (!empty($row['content'])) {
                        return $row['content'];
                    }
                }
                return '';
            }
            return $value;
        }
        return '';
    }
}
