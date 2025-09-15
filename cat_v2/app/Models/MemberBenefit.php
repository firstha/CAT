<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberBenefit extends Model
{
    use HasFactory;
    protected $fillable = ['name'];
    public function levels()
    {
        return $this->belongsToMany(
            MemberLevel::class,      
            'benefit_level',        
            'member_benefit_id',     
            'member_level_id'    
        );
    }
}
