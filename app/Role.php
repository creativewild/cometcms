<?php namespace App;

use Zizaco\Entrust\EntrustRole;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Role
 *
 * @property integer $id 
 * @property string $name 
 * @property string $display_name 
 * @property string $description 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property-read \Illuminate\Database\Eloquent\Collection|\Config::get('auth.model[] $users 
 * @property-read \Illuminate\Database\Eloquent\Collection|\Config::get('entrust.permission[] $perms 
 * @method static \Illuminate\Database\Query\Builder|\App\Role whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Role whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Role whereDisplayName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Role whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Role whereUpdatedAt($value)
 */
class Role extends EntrustRole {

    use SoftDeletes;

    protected $guarded = ['id'];

}