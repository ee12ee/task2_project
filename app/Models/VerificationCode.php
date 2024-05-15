<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Schema\ForeignKeyDefinition;

class VerificationCode extends Model
{
    use HasFactory;
    protected $dispatchesEvents=[
        'created'=> \App\Events\VerificationCodeGenerated::class
    ];
    protected $fillable=['code','expires_at','user_id'];
    protected $dates=['expires_at'];
    public function user():BelongsTo
    {
        return $this->belongsTo(User::class,foreignKey:'user_id');
    }
}
