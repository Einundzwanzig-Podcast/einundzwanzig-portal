<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;
use ParagonIE\CipherSweet\BlindIndex;
use ParagonIE\CipherSweet\EncryptedRow;
use ParagonIE\CipherSweet\JsonFieldMap;
use QCod\Gamify\Gamify;
use Spatie\Comments\Models\Concerns\InteractsWithComments;
use Spatie\Comments\Models\Concerns\Interfaces\CanComment;
use Spatie\LaravelCipherSweet\Concerns\UsesCipherSweet;
use Spatie\LaravelCipherSweet\Contracts\CipherSweetEncrypted;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail, CanComment, CipherSweetEncrypted
{
    use UsesCipherSweet;
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use HasTeams;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;
    use InteractsWithComments;
    use Gamify;

    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public static function configureCipherSweet(EncryptedRow $encryptedRow): void
    {
        $map = (new JsonFieldMap())
            ->addTextField('url')
            ->addTextField('read_key')
            ->addTextField('wallet_id');

        $encryptedRow
            ->addField('public_key')
            ->addField('lightning_address')
            ->addField('lnurl')
            ->addField('node_id')
            ->addField('email')
            ->addField('paynym')
            ->addJsonField('lnbits', $map)
            ->addBlindIndex('public_key', new BlindIndex('public_key_index'))
            ->addBlindIndex('lightning_address', new BlindIndex('lightning_address_index'))
            ->addBlindIndex('lnurl', new BlindIndex('lnurl_index'))
            ->addBlindIndex('node_id', new BlindIndex('node_id_index'))
            ->addBlindIndex('paynym', new BlindIndex('paynym_index'))
            ->addBlindIndex('email', new BlindIndex('email_index'));
    }

    public function orangePills()
    {
        return $this->hasMany(OrangePill::class);
    }

    public function meetups()
    {
        return $this->belongsToMany(Meetup::class);
    }

    public function reputations()
    {
        return $this->morphMany('QCod\Gamify\Reputation', 'subject');
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    public function paidArticles()
    {
        return $this->belongsToMany(LibraryItem::class, 'library_item_user', 'user_id', 'library_item_id');
    }
}
