<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UserService extends BaseService
{
    public function index(array $filters = [])
    {
        $query = $this->buildUserQuery();

        $query->filter($filters)->orderBy('name');

        return $query->paginate();
    }

    public function get($id)
    {
        $query = $this->buildUserQuery();
        return $query->find($id);
    }

    public function store($data)
    {

        return $this->executeTransaction(function () use ($data) {
            if (isset($data['password']) && !empty($data['password'])) {
                // Se a senha foi fornecida, hash
                $data['password'] = bcrypt($data['password']);
            } else {
                // Gerar uma senha aleatória e hashear
                $password = Str::random(8);
                $data['password'] = bcrypt($password);
            }

            $data['manager_id'] = Auth::id();

            $user = new User($data);
            $user->save();
            if (isset($password)) {
                Mail::to($data['email'])->send(new \App\Mail\UserCreated($user, $password));
            }
            return $user;
        });
    }

    public function update($data, $id)
    {
        return $this->executeTransaction(function () use ($data, $id) {
            $user = $this->get($id);
            $user->update($data);
            return true;
        });
    }

    public function destroy($id): bool
    {
        return $this->executeTransaction(function () use ($id) {
            $user = $this->get($id, true);
            $user->delete();
            return true;
        });
    }

    private function buildUserQuery()
    {
        $loggedUser = Auth::id();
        // Obtém o manager_id do usuário logado
        $managerId = User::where('id', $loggedUser)->value('manager_id');

        if ($managerId === null) {
            // Se o manager_id for null, retorna o usuário logado e os usuários com manager_id igual ao ID do usuário logado
            return User::where(function ($q) use ($loggedUser) {
                $q->where('id', $loggedUser)->orWhere('manager_id', $loggedUser);
            });
        } else {
            // Se o manager_id for diferente de null, retorna apenas o usuário logado
            return User::where('id', $loggedUser);
        }
    }
}
