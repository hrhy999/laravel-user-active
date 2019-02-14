<h1 align="center">Laravel-User-Active</h1>
<p align="center">
<a href="https://travis-ci.org/cblink/user-active"><img src="https://travis-ci.org/cblink/user-active.svg?branch=master" alt="Build Status"></a>
</p>

## Installation

```shell
$ composer require "cblink/user-active" -vvv
```
or in composer.json
```php
"repositories": [
        {
              "type": "vcs",
              "url": "https://github.com/hrhy999/laravel-user-active"
        }
],
"require": {
	"cblink/user-active":"dev-master",
}
```
## Useage

use traits in User Model
```php
<?php

namespace App\Models\User;

use Cblink\ActiveUser\Traits\LastActiveAtHelper;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use LastActiveAtHelper;
}
```

use middleware in App\Http\Kernel
```php
<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    protected $middlewareGroups = [
        'web' => [
            // 记录用户最后活跃时间
            \Cblink\ActiveUser\Http\Middleware\RecordLastActiveTime::class,
        ],
        
        'api' => [
            // 记录用户最后活跃时间
            \Cblink\ActiveUser\Http\Middleware\RecordLastActiveTime::class,
        ],
    ];
}
```

register corn in your console kernel
```php
<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule)
    {
        // 每日零时执行一次
        $schedule->command('cblink:sync-user-active-at')->dailyAt('00:20')->timezone('Asia/Shanghai')->withoutOverlapping();
        
        // 每日四点执行一次，需要先执行 cblink:sync-user-active-at 再执行该命令
        $schedule->command('cblink:record-user-active-logs')->dailyAt('04:00')->timezone('Asia/Shanghai')->withoutOverlapping();
    }
}
```
change the user model in src/Commands/SyncUserActiveAt.php and Commands/RecordUserActiveLog.php to yours
```php
<?php
namespace Cblink\ActiveUser\Commands;
use Illuminate\Console\Command;
use Illuminate\Foundation\Auth\User;//replace this by your user model
```

