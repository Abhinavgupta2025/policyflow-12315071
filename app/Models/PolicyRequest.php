<?php

namespace App\Models;

use App\Enums\PolicyStatus;
use App\Exceptions\InvalidStateTransitionException;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class PolicyRequest extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'date_of_birth' => 'date',
        'trip_start' => 'date',
        'trip_end' => 'date',
        'sum_insured' => 'integer',
        'travel_days' => 'integer',
        'calculated_premium' => 'decimal:2',
        'pricing_breakdown' => 'array',
        'status' => PolicyStatus::class,
        'attempt_count' => 'integer',
        'issued_at' => 'datetime',
    ];

    public function attempts(): HasMany
    {
        return $this->hasMany(IssuanceAttempt::class)->orderBy('attempt_number', 'asc');
    }

    public function stateHistories(): HasMany
    {
        return $this->hasMany(PolicyStateHistory::class)->orderBy('id', 'asc');
    }

    /**
     * Safely transition the policy to a new state and record audit trail in a database transaction.
     *
     * @throws InvalidStateTransitionException
     */
    public function transitionTo(PolicyStatus|string $targetStatus, ?string $reason = null, array $metadata = []): void
    {
        $target = is_string($targetStatus) ? PolicyStatus::from($targetStatus) : $targetStatus;
        $current = $this->status;

        if ($current === $target) {
            return; // Idempotent no-op
        }

        if (! $current->canTransitionTo($target)) {
            throw new InvalidStateTransitionException(
                $current->value,
                $target->value,
                "Cannot transition policy {$this->id} from {$current->value} to {$target->value}"
            );
        }

        DB::transaction(function () use ($current, $target, $reason, $metadata) {
            $this->status = $target;
            if ($target === PolicyStatus::ISSUED && ! $this->issued_at) {
                $this->issued_at = Carbon::now();
            }
            $this->save();

            $this->stateHistories()->create([
                'from_state' => $current->value,
                'to_state' => $target->value,
                'reason' => $reason,
                'metadata' => $metadata ?: null,
            ]);
        });
    }

    public function isIssued(): bool
    {
        return $this->status === PolicyStatus::ISSUED;
    }

    public function canRetry(): bool
    {
        return in_array($this->status, [
            PolicyStatus::VALIDATED,
            PolicyStatus::FAILED,
        ], true);
    }

    public function canReconcile(): bool
    {
        return in_array($this->status, [
            PolicyStatus::PENDING_CONFIRMATION,
            PolicyStatus::NEEDS_RECONCILIATION,
            PolicyStatus::SUBMITTED,
        ], true);
    }
}
