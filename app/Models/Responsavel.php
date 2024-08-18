<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Responsavel extends Model
{
    use HasFactory;
    protected $fillable = [
        'Nome',
        'CPF',
        'Nascimento',
        'Telefone',
        'CEP',
        'Rua',
        'Numero',
        'Bairro',
        'Estado',
        'Cidade',
        'Zona',
        'Complemento',
        'Email',
        'Senha',
    ];
}
