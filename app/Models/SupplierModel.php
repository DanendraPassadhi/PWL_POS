<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierModel extends Model
{
    use HasFactory;

    protected $table = 'm_supplier';
    protected $primaryKey = 'id';
    protected $fillable = ['supplier_nama', 'supplier_alamat', 'supplier_telp'];

    public function barang()
    {
        return $this->hasMany(BarangModel::class, 'supplier_id', 'id');
    }
} 