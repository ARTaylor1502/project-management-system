<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientPassword extends Model
{
    protected $fillable = [
        'client_id', 'name', 'url', 'details', 'password'
    ];

    protected $appends = array('decrypted_password');

    public function getDecryptedPasswordAttribute() {
        $encryption = resolve('App\Helper\Encryption');

        return $encryption->decrypt($this->password);
    }
}
