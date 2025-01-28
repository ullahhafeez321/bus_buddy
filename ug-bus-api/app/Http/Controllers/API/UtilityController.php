<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Definition;
use App\Models\Word;
use App\Models\WordToWord;
use App\Models\PublishLog;
use App\Models\Example;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UtilityController extends Controller
{
    public function download(Request $request)
    {
        $version = $request->query('version') + 1;

        $oldestPublishinglog = PublishLog::where('version', $version)->first();
        $lastPublishLog = PublishLog::latest('id')->first();

        $words = Word::where('id', '>=', $oldestPublishinglog->start_id)->get();
        $wordRelations = WordToWord::all();
        $definitions = Definition::all();
        $examples = Example::all();

        $response = [
            "statusCode" => 200,
            "body" => count($words)." new words downloaded.",
            "words" => $words,
            "definitions" => $definitions,
            "examples" => $examples,
            "wordRelations" => $wordRelations,
            "newDBVersion" => $lastPublishLog->version,
        ];
        return response()->json($response);
    }

    
    public function upload(Request $request)
    {
        $words = $request->input('words');
        $wordRelations = $request->input('relations');

        foreach ($words as $row) {
            $word = new Word();
            $word->word = $row->word;
            $word->language = $row->language;
            $word->status = 0;
            $word->save();
        }
        foreach ($wordRelations as $row) {
            $wordRelation = new WordToWord();
            $wordRelation->balochi_id = $row->balochi_id;
            $wordRelation->urdu_id = $row->urdu_id;
            $wordRelation->english_id = $row->english_id;
            $wordRelation->roman_balochi_id = $row->roman_balochi_id;
            $wordRelation->save();
        }

        $response = [
            "statusCode" => 200,
            "body" => count($words)." new words uploaded.",
        ];
        return response()->json($response);
    }
}
