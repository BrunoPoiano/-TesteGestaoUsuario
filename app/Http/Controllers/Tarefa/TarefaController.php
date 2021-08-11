<?php

namespace App\Http\Controllers\Tarefa;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tarefa\TarefaRequest;
use App\Models\Prioridade\Prioridade;
use App\Models\Tarefa\Tarefa;
use Illuminate\Support\Facades\Auth;

class TarefaController extends Controller
{

    public function index()
    {
  
    }

    public function userTarefas()
    {
        return Tarefa::join('prioridades', 'tarefas.prioridade', 'prioridades.id')
        ->orderby('tarefas.prioridade', 'asc')
        ->where('tarefas.user_id', Auth::id())
        ->where('tarefas.status', false)
        ->get(['tarefas.*', 'prioridades.nome']);
    }
    //Get Tarefas Finalizadas
    public function tarefasFinalizadas()
    {

        return Tarefa::join('prioridades', 'tarefas.prioridade', 'prioridades.id')
            ->orderby('tarefas.prioridade', 'asc')
            ->where('tarefas.user_id', Auth::id())
            ->where('tarefas.status', true)
            ->get(['tarefas.*', 'prioridades.nome']);
    }
    //Get Prioridades
    public function prioridades()
    {
        return Prioridade::orderby('id', 'asc')->get();
    }

    public function create()
    {
        //
    }

    public function store(TarefaRequest $request)
    {
        if ($request) {
            Tarefa::create([
                'user_id' => Auth::id(),
                'tarefa' => $request->tarefa,
                'status' => false,
                'prioridade' => $request->prioridade,
            ]);
            return response([
                'message' => 'Tarefa criada com sucesso',
            ]);
        }
        return response([
            'message' => 'Erro ao receber Dados',
        ]);
    }


    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        if ($id) {
            $edtTarefa = Tarefa::find($id);
            $edtTarefa->status = true;
            $edtTarefa->update();
            return response([
                'message' => 'Tarefa Finalizada com sucesso',
            ]);
        }
        return response([
            'message' => 'erro ao receber dados',
        ]);
    }


    public function update(TarefaRequest $request, $id)
    {
        if ($request) {
            $updTarefa = Tarefa::find($id);
            $updTarefa->tarefa = $request->tarefa;
            $updTarefa->prioridade = $request->prioridade;
            $updTarefa->update();
            return response([
                'message' => 'Tarefa atualizada com sucesso',
            ]);
        }
        return response([
            'message' => 'erro ao receber dados',
        ]);
    }


    public function destroy($id)
    {
        if ($id) {
            $desTarefa = Tarefa::find($id);
            $desTarefa->delete();
            return response([
                'message' => 'tarefa excluida com sucesso',
            ]);
        }
        return response([
            'message' => 'erro ao receber dados',
        ]);
    }
}
