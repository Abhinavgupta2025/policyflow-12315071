<?php

namespace App\Console\Commands;

use App\Enums\PolicyStatus;
use App\Models\PolicyRequest;
use App\Services\PolicyIssuanceService;
use Illuminate\Console\Command;

class ReconcilePoliciesCommand extends Command
{
    protected $signature = 'policy:reconcile {--id= : Specific policy ID to reconcile}';
    protected $description = 'Detect and reconcile stale PENDING_CONFIRMATION or NEEDS_RECONCILIATION policy requests with the insurer';

    public function handle(PolicyIssuanceService $service): int
    {
        $specificId = $this->option('id');

        $query = PolicyRequest::query();
        if ($specificId) {
            $query->where('id', $specificId);
        } else {
            $query->whereIn('status', [
                PolicyStatus::NEEDS_RECONCILIATION,
                PolicyStatus::PENDING_CONFIRMATION,
            ]);
        }

        $policies = $query->get();

        if ($policies->isEmpty()) {
            $this->info('No policies currently require reconciliation.');
            return self::SUCCESS;
        }

        $this->info("Found {$policies->count()} policy(ies) to reconcile.");

        $headers = ['ID', 'Client Request ID', 'Previous Status', 'New Status', 'Result'];
        $rows = [];

        foreach ($policies as $policy) {
            $prevStatus = $policy->status->value;
            $res = $service->reconcile($policy);

            $rows[] = [
                $policy->id,
                $policy->client_request_id,
                $prevStatus,
                $res['policy']->status->value,
                $res['message'],
            ];
        }

        $this->table($headers, $rows);

        return self::SUCCESS;
    }
}
