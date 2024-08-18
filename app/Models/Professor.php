<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Professor extends Model
{
    use HasFactory;
    protected $table = 'professores';
    protected $fillable = [
        'Nome',
        'CPF',
        'Nascimento',
        'Telefone',
        'Formacao',
        'Token',
        'Email',
        'Senha',
    ];
}
