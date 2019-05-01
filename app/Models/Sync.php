<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sync extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sync';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var boolean
     */
    public $timestamps = true;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'post_id',
        'server',
        'remote_id',
        'add',
        'edit',
        'delete',
        'created_at',
    ];

    static $servers = [
        'sreality',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }

    /*
	|--------------------------------------------------------------------------
	| SCOPES
	|--------------------------------------------------------------------------
	*/
    public function scopeSreality($builder)
    {
        $builder->where('server', 'sreality');

        return $builder;
    }
}