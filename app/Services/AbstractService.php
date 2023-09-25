<?php


namespace App\Services;

use Illuminate\Support\Facades\DB;

abstract class AbstractService
{



    public function startTranscation()
    {
        DB::beginTransaction();
    }

    public function commitTranscation()
    {
        DB::commit();
    }

    public function rollbackTranscation()
    {
        DB::rollBack();
    }

    
}

