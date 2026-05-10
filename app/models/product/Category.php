<?php

namespace App\models\product;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use File;
use App\models\language\Language;
use App\models\product\Product;
use App\models\product\TypeProduct;
use App\models\tag\TagCate;

class Category extends Model
{
    protected $table = "product_category";
    public function rule()
    {
        return [
            
        ];
    }
    public function typeCate()
    {
        return $this->hasMany(TypeProduct::class,'cate_id','id')->where('status',1);
    }
    public function product()
    {
        return $this->hasMany(Product::class,'category','id')->where('home_status',1)->orderBy('id','DESC');
    }
    public function tagCate()
    {
        return $this->hasMany(TagCate::class,'cate_product_id','id');
    }
    public function saveCate($request)
    {
        $id = $request->id;
        if($id != "" ){
            $query = Category::where([
                'id' => $id
             ])->first();
            if ($query) {
                $query->name = json_encode($request->name);
                $query->slug = to_slug($request->name[0]['content']);
                $query->content = $this->normalizeMultilang($request->content);
                $query->content_table = $this->normalizeMultilang($request->content_table);
                $query->status = $request->status;
                $query->sort_order = $request->sort_order ?? $query->sort_order ?? 0;
                $query->avatar = $request->avatar;
                $query->imagehome = $request->imagehome;
                $query->save();
            }else{
                $query = new Category();
                $query->quiz_id = 0;
                $query->language = 0;
                $query->name = json_encode($request->name);
                $query->slug = to_slug($request->name[0]['content']);
                $query->content = $this->normalizeMultilang($request->content);
                $query->content_table = $this->normalizeMultilang($request->content_table);
                $query->status = $request->status;
                $query->sort_order = $request->sort_order ?? 0;
                $query->avatar = $request->avatar;
                $query->imagehome = $request->imagehome;
                $query->save();
            }
            
        }else{
            $query = new Category();
            $query->quiz_id = 0;
            $query->language = 0;
            $query->name = json_encode($request->name);
            $query->slug = to_slug($request->name[0]['content']);
            $query->content = $this->normalizeMultilang($request->content);
            $query->content_table = $this->normalizeMultilang($request->content_table);
            $query->status = $request->status;
            $query->sort_order = $request->sort_order ?? 0;
            $query->avatar = $request->avatar;
            $query->imagehome = $request->imagehome;
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
