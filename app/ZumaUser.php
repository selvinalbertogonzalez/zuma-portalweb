<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ZumaUser extends Model {
    use Notifiable;
    protected $primaryKey = 'IdUsuario';
    protected $table = 'usuario';
    public $timestamps = false;
    /**
     * Route notifications for the mail channel.
     *
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return array|string
     */
    public function routeNotificationForMail($notification) {
        // Return email address only...
        return $this->Correo;

    }
}
