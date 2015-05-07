<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

    const CACHE_LIST_KEY = 'usersList';

    public static $validation = array(
        'register'      => array(
            'email'     => 'required|email|unique:users',
            'username'  => 'required|alpha_num|unique:users',
            'password'  => 'required|confirmed|min:6',
        ),

        'register-vk'   => array(
            'email'     => 'email|unique:users',
            'username'  => 'required|alpha_num|unique:users',
        ),
    );

    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password');

    protected $fillable = array('username', 'email', 'password');

	public static function findByVkId($vkId) {
        return self::where('vkid', '=', $vkId)->first();
    }

    /**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
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

    public function planets() {
        return $this->hasMany('Planet', 'author');
    }

    public function register() {
        $this->password = Hash::make($this->password);
        $this->activationCode = $this->generateCode();
        $this->save();
        Log::info("User [{$this->email}] registered. Activation code: {$this->activationCode}");

        $this->sendActivationMail();

        return $this->userId;
    }

    public function sendActivationMail() {
        $activationUrl = action(
            'UsersController@getActivate',
            array(
                'userId' => $this->id,
                'activationCode'    => $this->activationCode,
            )
        );

        $that = $this;
        Mail::send('emails/activation',
            array('activationUrl' => $activationUrl),
            function ($message) use($that) {
                $message->to($that->email)->subject('Спасибо за регистрацию!');
            }
        );
    }

    public function activate() {
        $this->activationCode = '';
        $this->isActive = true;
        $this->save();
        Event::fire('user.activated', array($this));
        Log::info("User [{$this->email}] successfully activated");
    }

    public function generateCode() {
        return hash('md5', $this->email . ':' . mt_rand() . ':' . uniqid() . ':' . Config::get('app.key'));
    }

    public function scopeActive($query) {
        return $query->where('isActive', true);
    }
}
