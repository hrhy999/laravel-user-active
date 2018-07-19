<?php

namespace Cblink\ActiveUser\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Auth\User;

class RecordUserActiveLog extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cblink:record-user-active-logs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '用户每日活跃记录';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @param \Illuminate\Foundation\Auth\User $user
     *
     * @return mixed
     */
    public function handle(User $user)
    {
        $this->info('开始记录.');

        $user->recordUserActiveLog();

        $this->info('记录成功！');
    }
}
