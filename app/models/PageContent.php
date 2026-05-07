<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use App\models\language\Language;

class PageContent extends Model
{
    protected $table = "page_contents";
    public function rule()
    {
        
    }
    public function savePageContent($request)
    {
        $quiz_id = $request->quiz_id;
        $language = $request->language;
        $nextId = (PageContent::max('quiz_id') ?? 0) + 1;
        $listLanguage = Language::get(['code'])->toArray();

        if ($quiz_id != "" && $language != "") {
            $titleInput = $request->title;
            $contentInput = $request->content;
            $descriptionInput = $request->description;
            $isMultilangPayload = is_array($titleInput) || is_array($contentInput) || is_array($descriptionInput);

            if ($isMultilangPayload) {
                foreach ($listLanguage as $item) {
                    $langCode = $item['code'];
                    $query = PageContent::where([
                        'quiz_id' => $quiz_id,
                        'language' => $langCode
                    ])->first();

                    if (!$query) {
                        $query = new PageContent();
                        $query->quiz_id = $quiz_id;
                        $query->language = $langCode;
                    }

                    $title = $this->extractLangContent($titleInput, $langCode);
                    $query->title = $title;
                    $query->content = $this->extractLangContent($contentInput, $langCode);
                    $query->description = $this->extractLangContent($descriptionInput, $langCode);
                    $query->status = $request->status;
                    $query->type = $request->type;
                    $query->image = $request->image;
                    $query->slug = to_slug($title);
                    $query->save();
                }
                $query = PageContent::where(['quiz_id' => $quiz_id, 'language' => $language])->first();
            } else {
                $query = PageContent::where([
                    'quiz_id' => $quiz_id,
                    'language'=> $language
                 ])->first();
                if ($query) {
                    $query->title = $request->title;
                    $query->content = $request->content;
                    $query->status = $request->status;
                    $query->type = $request->type;
                    $query->image = $request->image;
                    $query->description = $request->description;
                    $query->save();
                } else {
                    $query = new PageContent();
                    $query->quiz_id = $quiz_id;
                    $query->language = $language;
                    $query->title = $request->title;
                    $query->content = $request->content;
                    $query->status = $request->status;
                    $query->type = $request->type;
                    $query->image = $request->image;
                    $query->slug = to_slug($request->title);
                    $query->description = $request->description;
                    $query->save();
                }
            }
        } else {
            foreach ($listLanguage as $item) {
                $langCode = $item['code'];
                $title = $this->extractLangContent($request->title, $langCode);
                $query = new PageContent();
                $query->quiz_id = $nextId;
                $query->language = $langCode;
                $query->title = $title;
                $query->content = $this->extractLangContent($request->content, $langCode);
                $query->status = $request->status;
                $query->type = $request->type;
                $query->image = $request->image;
                $query->slug = to_slug($title);
                $query->description = $this->extractLangContent($request->description, $langCode);
                $query->save();
            }
        }
        return $query;
    }

    private function extractLangContent($input, $langCode)
    {
        if (is_array($input)) {
            foreach ($input as $row) {
                if (isset($row['lang_code']) && $row['lang_code'] === $langCode) {
                    return $row['content'] ?? '';
                }
            }
            return $input[0]['content'] ?? '';
        }
        return (string) $input;
    }
}
