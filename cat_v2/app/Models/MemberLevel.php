<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberLevel extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'slug'];
    public function benefits()
    {
        return $this->belongsToMany(
            MemberBenefit::class,    
            'benefit_level',        
            'member_level_id',    
            'member_benefit_id'     
        );
    }
}
