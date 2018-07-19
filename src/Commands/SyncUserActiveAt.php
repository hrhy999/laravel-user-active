<?php

namespace Cblink\ActiveUser\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Auth\User;

class SyncUserActiveAt extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cblink:sync-user-active-at';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '将用户最后登录时间从缓存同步到数据库中';

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
        $this->info('开始同步.');

        $user->syncUserActiveAt();

        $this->info('同步成功！');
    }
}
