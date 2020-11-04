<?php

namespace App\Repositories;


interface HistoryRepositoryInterface
{
    public function createHistory($data);
    public function getHistory($key);
}
