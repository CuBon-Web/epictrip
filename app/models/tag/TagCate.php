<?php

namespace App\models\tag;

use Illuminate\Database\Eloquent\Model;
use App\models\tag\Tags;
use App\models\product\Category;
use App\models\product\Product;
class TagCate extends Model
{
    protected $table = "tag_cate";
    public function cateProduct()
    {
        return $this->hasOne(Category::class,'id','cate_product_id');
    }
    public function product()
    {
        return $this->hasMany(Product::class,'tag_cate','id')->where('home_status',1)->orderBy('id','DESC');
    }
    public function tags()
    {
        return $this->hasMany(Tags::class,'cate_tag_id','id')->orderBy('sort_order','ASC')->orderBy('id','ASC');
    }
    public function saveCate($request)
    {
        $id = $request->id;
        $nameJson = $this->normalizeMultilang($request->name);
        $slugSource = $this->extractFirstContent($request->name);

        if ($id != "") {
            $query = TagCate::where(['id' => $id])->first();
            if (!$query) {
                $query = new TagCate();
            }
        } else {
            $query = new TagCate();
        }

        $query->name = $nameJson;
        $query->slug = to_slug($slugSource);
        $query->cate_product_id = 0;
        $query->cate_product_slug = '';
        $query->status = $request->status;
        $query->status_filter = $request->status_filter;
        if ($id == "") {
            $query->sort_order = (int) TagCate::max('sort_order') + 1;
        }
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
