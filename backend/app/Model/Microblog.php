<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $id 
 * @property string $content 
 * @property int $creater_uid 
 * @property string $create_at 
 * @property string $update_at 
 */
class Microblog extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'microblog';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['id' => 'integer', 'creater_uid' => 'integer'];

    const CREATED_AT = 'create_at';
    const UPDATED_AT = 'update_at';
}