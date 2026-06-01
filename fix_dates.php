<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$investments = \App\Models\Investment::where('status', 'active')->get();
$fixed = 0;

foreach ($investments as $inv) {
    $date = \Carbon\Carbon::parse($inv->next_payout_at);
    if (!$date->isMonday()) {
        $nextMon = $date->copy()->next(\Carbon\Carbon::MONDAY);
        $inv->update(['next_payout_at' => $nextMon]);
        echo "Fixed ID {$inv->id} from {$date->format('Y-m-d')} to {$nextMon->format('Y-m-d')}\n";
        $fixed++;
    }
}

echo "Fixed {$fixed} investments.\n";
