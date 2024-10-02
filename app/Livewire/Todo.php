<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\DatabaseConnectionService;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class Todo extends Component
{
    public array $todos = [];

    protected DatabaseConnectionService $dbService;

    public function mount()
    {
        $this->dbService = new DatabaseConnectionService();
        $this->getTodoData();
    }


    public function updateTodoMarkDone($todoId,$finished){
        try {
            $this->dbService = new DatabaseConnectionService();
            $this->dbService->setConnection(auth()->id());

            $updated = DB::connection('user_db')->table('todo')->where('id', $todoId)->update(['isFinish'=>$finished]);

            if($updated){
                session()->flash('message', 'Todo başarıyla güncellendi.');
                $this->getTodoData();
            }else{
                session()->flash('error', 'Todo bulunamadı.');
            }

        } catch (\Exception $e) {
            \Log::error('Todo verileri güncelleyemedi: ' . $e->getMessage());
            session()->flash('error', 'Veriler güncellenmedi.');

        }
    }

    public function getTodoData()
    {
        try {
            $this->dbService = new DatabaseConnectionService();

            $this->dbService->setConnection(auth()->id());

            $this->todos = DB::connection('user_db')->table('todo')->get()->toArray();
        } catch (\Exception $e) {
            \Log::error('Todo verileri çekilemedi: ' . $e->getMessage());
            session()->flash('error', 'Veriler alınamadı.');
        }
    }

    public function deleteTodo($todoId)
    {
        try {
            $this->dbService = new DatabaseConnectionService();

            $this->dbService->setConnection(auth()->id());

            $deleted = DB::connection('user_db')->table('todo')->where('id', $todoId)->delete();

            if ($deleted) {
                session()->flash('message', 'Todo başarıyla silindi.');
                $this->getTodoData();
            } else {
                session()->flash('error', 'Todo bulunamadı.');
            }
        } catch (\Exception $e) {
            \Log::error('Todo silinemedi: ' . $e->getMessage());
            session()->flash('error', 'Todo silinemedi.');
        }
    }

    public string $todoText = '';

    public function addTodo()
    {

            $this->validate([
                'todoText' => 'required'
            ]);

            $this->dbService = new DatabaseConnectionService();
            $this->dbService->setConnection(auth()->id());

            DB::connection('user_db')->table('todo')->insert([
                'todo' => $this->todoText,
                'isFinish' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            session()->flash('message', 'Todo başarıyla eklendi.');
            $this->todoText = '';
            $this->getTodoData();

    }

    public function render()
    {
        return view('livewire.todo');
    }
}
