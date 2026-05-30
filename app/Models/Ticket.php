<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class Ticket extends Model implements HasMedia
{
    /** @use HasFactory<\Database\Factories\TicketFactory> */
    use HasFactory;
    use InteractsWithMedia;

    protected $fillable = ['customer_id', 'subject', 'message', 'status', 'manager_replied_at'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function scopeForDay(Builder $query): Builder
    {
        return $query->where('created_at', '>=', Carbon::now()->subDay());
    }

    public function scopeForWeek(Builder $query): Builder
    {
        return $query->where('created_at', '>=', Carbon::now()->subWeek());
    }

    public function scopeForMonth(Builder $query): Builder
    {
        return $query->where('created_at', '>=', Carbon::now()->subMonth());
    }
}
