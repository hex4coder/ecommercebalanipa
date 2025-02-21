<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Illuminate\Support\Facades\DB;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'name',
        'email',
        'role',
        'password',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function canAccessPanel(Panel $panel): bool
    {
        $domain = env('APP_DOMAIN', 'smkncampalagian.sch.id');
        // return str_ends_with($this->email, "@$domain") && $this->role == 0;
        return true;
        // return str_ends_with($this->email, "@$domain") && $this->hasVerifiedEmail();
    }

    public function address() {
        return $this->hasOne(Address::class, 'user_id');
    }

    public function pesanan() {
        return $this->hasMany(Pesanan::class, 'user_id');
    }

    public function full_address() {
        // $address = Address::where('user_id', $this->id)->first();
        $address = DB::table('addresses')
        ->where('user_id', $this->id)->first();
        if($address) {
            return $address->jalan . " " . $address->dusun . " Desa/Kel. " . $address->desa . " Kec. " . $address->kecamatan . ", " . $address->kota . " Provinsi " . $address->provinsi . " Kode Pos " . $address->kodepos . "\nNomor Telpon: " . $address->nomorhp;
        }
        return "Tidak ada alamat";
    }
}
