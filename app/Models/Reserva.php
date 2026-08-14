<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    use HasFactory;

    const STATUS_PENDENTE = 'pendente';
    const STATUS_CONFIRMADA = 'confirmada';
    const STATUS_CANCELADA = 'cancelada';

    protected $fillable = ['aluno_id', 'livro_id', 'data_retirada', 'status'];

    protected $casts = [
        'data_retirada' => 'date',
    ];

    public function aluno()
    {
        return $this->belongsTo(Aluno::class);
    }

    public function livro()
    {
        return $this->belongsTo(Livro::class);
    }

    public function scopePendentes($query)
    {
        return $query->where('status', self::STATUS_PENDENTE);
    }
}
