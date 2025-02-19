<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use App\Models\Responsavel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AlunoController
{
    public function create(Request $req)
    {
        $senha = $req->input('senha');
        $c_senha = $req->input('c_senha');
        $validator = Validator::make($req->all(), [
            'nome_aluno' => 'required|string|max:255',
            'cpf_aluno' => 'required|string|size:14|unique:alunos,CPF',
            'aniversario_aluno' => 'required|date',
            'nome_resp' => 'required|string|max:255',
            'cpf_resp' => 'required|string|size:14',
            'aniversario_resp' => 'required|date',
            'telefone' => 'required|string|max:15',
            'cep' => 'nullable|string|max:10',
            'rua' => 'nullable|string|max:255',
            'number' => 'nullable|string|max:5',
            'bairro' => 'nullable|string|max:255',
            'estado' => 'nullable|string|size:2',
            'cidade' => 'nullable|string|max:50',
            'complemento' => 'required|string|max:255',
            'email' => 'required|email|unique:alunos,Email',
            'senha' => 'required|string|min:8',
            'c_senha' => 'required|string|same:senha',
        ], [
            'nome_aluno.required' => 'O campo nome do aluno deve ser preenchido',
            'cpf_aluno.required' => 'O campo CPF do aluno deve ser preenchido',
            'cpf_aluno.size' => 'O CPF do aluno deve ter exatamente :size caracteres',
            'aniversario_aluno.required' => 'O campo data de nascimento do aluno deve ser preenchido',
            'nome_resp.required' => 'O campo nome do responsável deve ser preenchido',
            'cpf_resp.required' => 'O campo CPF do responsável deve ser preenchido',
            'cpf_resp.size' => 'O CPF do responsável deve ter exatamente :size caracteres',
            'aniversario_resp.required' => 'O campo data de nascimento do responsável deve ser preenchido',
            'telefone.required' => 'O campo telefone deve ser preenchido',
            'rua.required' => 'O campo endereço deve ser preenchido',
            'cep.required' => 'O campo CEP deve ser preenchido',
            'estado.required' => 'O campo estado deve ser preenchido',
            'estado.size' => 'O estado deve ter exatamente :size caracteres',
            'cidade.required' => 'O campo cidade deve ser preenchido',
            'complemento.required' => 'O campo complemento deve ser preenchido',
            'email.required' => 'O campo e-mail deve ser preenchido',
            'email.email' => 'O campo e-mail deve ser um endereço de e-mail válido',
            'email.unique' => 'O e-mail informado já está em uso',
            'senha.required' => 'O campo senha deve ser preenchido',
            'senha.min' => 'A senha deve ter pelo menos :min caracteres',
            'c_senha.required' => 'O campo confirmação de senha deve ser preenchido',
            'c_senha.same' => 'A confirmação da senha não coincide com a senha',
        ]);


        if ($validator->fails()) return redirect()->back()->withErrors($validator)->withInput();


        $responsavel = new Responsavel();
        $responsavel->Nome = $req->input('nome_resp');
        $responsavel->CPF = $req->input('cpf_resp');
        $responsavel->Nascimento = $req->input('aniversario_resp');
        $responsavel->Telefone = $req->input('telefone');
        $responsavel->CEP = $req->input('cep');
        $responsavel->Rua = $req->input('rua');
        $responsavel->Numero = $req->input('number');
        $responsavel->Bairro = $req->input('bairro');
        $responsavel->Estado = $req->input('estado');
        $responsavel->Cidade = $req->input('cidade');
        $responsavel->Complemento = $req->input('complemento');
        $responsavel->Email = $req->input('email');
        $responsavel->Senha = Hash::make($senha);

        if ($c_senha !== $senha) return redirect()->back()->withInput()->withErrors(['senha' => 'senhas não coincidem']);

        $query = $responsavel->save();
        if ($query === true) {
            $resp_data = Responsavel::where('email', $req->input('email'))->first();

            $aluno = new Aluno();
            $aluno->Nome = $req->input('nome_aluno');
            $aluno->Email = $req->input('email');
            $aluno->CPF = $req->input('cpf_aluno');
            $aluno->Nascimento = $req->input('aniversario_aluno');
            $aluno->Id_Responsavel = $resp_data->Id_Responsavel;

            $aluno->save();
        }

        Session::put('aluno', $aluno);
        Session::put('responsavel', $responsavel);
        return redirect('/aluno/account');
    }
}
