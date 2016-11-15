<?php
namespace Ohio\Core\Team;

use Ohio\Core\Role\Role;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Passwords\CanResetPassword as CanResetPasswordTrait;

class Team extends Model implements Authenticatable, CanResetPassword
{
    use CanResetPasswordTrait;
    use Notifiable;

    protected $morphClass = 'core/team';

    protected $table = 'teams';

    protected $guarded = ['id'];

    /**
     * Default values
     *
     * @var array
     */
    protected $attributes = [
        'is_active' => 1,
        'is_verified' => 0,
    ];

    public function __toString()
    {
        return (string) $this->email;
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'team_roles', 'team_id', 'role_id');
    }

    public function setIsVerifiedAttribute($value)
    {
        $this->attributes['is_verified'] = boolval($value);
    }

    public function setIsActiveAttribute($value)
    {
        $this->attributes['is_active'] = boolval($value);
    }

    public function setFirstNameAttribute($value)
    {
        $this->attributes['first_name'] = strtoupper(trim($value));
    }

    public function setLastNameAttribute($value)
    {
        $this->attributes['last_name'] = strtoupper(trim($value));
    }

    public function setMiAttribute($value)
    {
        $this->attributes['mi'] = substr(strtoupper(trim($value)), 0, 1) ?: '';
    }

    public function setPasswordAttribute($value)
    {
        if ($value && (strlen($value) != 60 || substr($value, 0, 1) != '$')) {
            $value = bcrypt(trim($value));
        }

        $this->attributes['password'] = trim($value);
    }

    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = strtolower(trim($value));
        $this->setTeamnameAttribute($value);
    }

    public function setTeamnameAttribute($value)
    {
        $this->attributes['teamname'] = strtolower(trim($value));
    }

    /**
     * Get the name of the unique identifier for the team.
     *
     * @return string
     */
    public function getAuthIdentifierName()
    {
        return 'id';
    }

    /**
     * Get the unique identifier for the team.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->id;
    }

    /**
     * Get the password for the team.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    /**
     * Get the token value for the "remember me" session.
     *
     * @return string
     */
    public function getRememberToken()
    {
        return $this->remember_token;
    }

    /**
     * Set the token value for the "remember me" session.
     *
     * @param  string $value
     * @return void
     */
    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }

    /**
     * Get the column name for the "remember me" token.
     *
     * @return string
     */
    public function getRememberTokenName()
    {
        return 'remember_token';
    }

    /**
     * Get the e-mail address where password reminders are sent.
     *
     * @return string
     */
    public function getReminderEmail()
    {
        return $this->email;
    }

    public function hasRole($name)
    {

        $name = strtoupper($name);

        $roleNames = $this->roles->pluck('name')->all();

        if (in_array('SUPER', $roleNames)) {
            return true;
        }

        if (in_array($name, $roleNames)) {
            return true;
        }

        return false;
    }

}