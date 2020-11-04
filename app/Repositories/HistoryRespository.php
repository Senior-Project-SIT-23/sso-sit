<?php

namespace App\Repositories;

use App\Model\History;
use Illuminate\Support\Arr;

class HistoryRepository implements HistoryRepositoryInterface
{
    public function createHistory($data)
    {
        $history = new History;
        $history->user_id = $data["user_id"];
        $history->key = $data["key"];
        $history->value = $data["value"];
        $history->save();
    }
    public function getHistory($key)
    {
        if ($key) {
            return  History::where("key", $key)->orderBy("created_at", "desc")->get();
        } else {
            return   History::orderBy("created_at", "desc")->get();
        }
    }
}
