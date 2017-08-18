<?php
namespace Belt\Core;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Class User
 * @package Belt\Core
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * @var string
     */
    protected $morphClass = 'users';

    /**
     * @var string
     */
    protected $table = 'users';

    /**
     * @var array
     */
    protected $fillable = ['email'];

    /**
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * @var array
     */
    protected $appends = ['fullname'];

    /**
     * Default values
     *
     * @var array
     */
    protected $attributes = [
        'is_active' => 1,
        'is_verified' => 0,
    ];

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->email;
    }

    /**
     * Associated User Roles
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles', 'user_id', 'role_id');
    }

    /**
     * Associated User Teams
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function teams()
    {
        return $this->belongsToMany(Team::class, 'team_users', 'user_id', 'team_id')
            ->orderBy('teams.name');
    }

    /**
     * Set is_verified attribute
     *
     * @param $value
     */
    public function setIsVerifiedAttribute($value)
    {
        $this->attributes['is_verified'] = boolval($value);
    }

    /**
     * Set is_active attribute
     *
     * @param $value
     */
    public function setIsActiveAttribute($value)
    {
        $this->attributes['is_active'] = boolval($value);
    }

    /**
     * Set first_name attribute
     *
     * @param $value
     */
    public function setFirstNameAttribute($value)
    {
        $this->attributes['first_name'] = strtoupper(trim($value));
    }

    /**
     * Set last_name attribute
     *
     * @param $value
     */
    public function setLastNameAttribute($value)
    {
        $this->attributes['last_name'] = strtoupper(trim($value));
    }

    /**
     * Set mi (middle initial) attribute
     *
     * @param $value
     */
    public function setMiAttribute($value)
    {
        $this->attributes['mi'] = substr(strtoupper(trim($value)), 0, 1) ?: '';
    }

    /**
     * Set password attribute
     *
     * @param $value
     */
    public function setPasswordAttribute($value)
    {
        if ($value && (strlen($value) != 60 || substr($value, 0, 1) != '$')) {
            $value = bcrypt(trim($value));
        }

        $this->attributes['password'] = trim($value);
    }

    /**
     * Set email attribute
     *
     * @param $value
     */
    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = strtolower(trim($value));
        $this->setUsernameAttribute($value);
    }

    /**
     * Set username attribute
     *
     * @param $value
     */
    public function setUsernameAttribute($value)
    {
        $this->attributes['username'] = strtolower(trim($value));
    }

    /**
     * Get full name
     *
     * Output full name based on given pattern
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        $fullname = sprintf('%s %s%s', $this->first_name, $this->mi ? $this->mi . '. ' : '', $this->last_name);

        return trim($fullname);
    }

    /**
     * Determine if user has particular role
     *
     * @param $name
     * @return bool
     */
    public function hasRole($name)
    {
        if ($this->is_super) {
            return true;
        }

        $roleNames = $this->roles->pluck('name')->all();

        if (in_array(strtoupper($name), $roleNames)) {
            return true;
        }

        return false;
    }

}