<?php

namespace App\Models;

use App\Models\Referral;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;



class Referral extends Model
{
    use HasFactory;
  

    protected $guarded = [];

    protected $dates = [
        'completed_at'
    ];

    public static function boot() {

       parent::boot(); 

        static::creating(function(Referral $referral) {
            $referral->token = Str::random(50);
        });
    }

    public function scopeWhereNotCompleted(Builder $builder) {
        return $builder->where('completed', false);
    }

    public function scopeWhereNotFromUser(Builder $builder, ?User $user) {

        if(!$user) {
            return $builder;
        }

        return $builder->where('user_id', '!=', $user->id);

    }

    public function complete() {
        $this->update([
            'completed' => true,
            'completed_at' => now()
        ]);
    }

}
