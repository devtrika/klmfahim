<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invoice extends Model
{
    use \App\Models\Concerns\HasUuid;

    public const STATUSES = ['draft', 'unpaid', 'paid', 'cancelled'];

    protected $fillable = [
        'number', 'status', 'client_name', 'client_phone', 'client_email', 'client_address', 'client_trn',
        'issue_date', 'due_date', 'subtotal', 'discount', 'vat_rate', 'vat_amount', 'total', 'notes',
        'cost_request_id', 'created_by',
    ];

    protected $casts = [
        'issue_date' => 'date',
        'due_date' => 'date',
        'subtotal' => 'decimal:2',
        'discount' => 'decimal:2',
        'vat_rate' => 'decimal:2',
        'vat_amount' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(InvoiceItem::class)->orderBy('sort');
    }

    public function costRequest(): BelongsTo
    {
        return $this->belongsTo(CostRequest::class);
    }

    /** Next number in the form CF-2026-0001, restarting every year. */
    public static function nextNumber(): string
    {
        $prefix = 'CF-'.now()->year.'-';
        $last = static::where('number', 'like', $prefix.'%')->orderByDesc('number')->value('number');

        return $prefix.str_pad((string) ((int) substr((string) $last, strlen($prefix)) + 1), 4, '0', STR_PAD_LEFT);
    }
}
