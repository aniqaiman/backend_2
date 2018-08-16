<?php 

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
    protected $table = 'reminders';
    protected $primaryKey = 'id';
    public $timestamp = 'true';
    protected $fillable = [
        'user_id',
        'code',
        'completed'
    ];
}
