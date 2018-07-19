<?php

namespace Cblink\ActiveUser\Traits;

use App\Models\RecordUserActiveAtLog;

trait HasRecordUserActiveAtLog
{
    public function recordUserActiveAtLogs()
    {
        return $this->hasMany(RecordUserActiveAtLog::class);
    }
}
