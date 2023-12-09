<?php

namespace App\Models;

use CodeIgniter\Model;

class Servicios extends Model
{
    protected $table = 'servicios';

    public function getServicioDetails($servicioId)
    {
        return $this->find($servicioId);
    }
}
