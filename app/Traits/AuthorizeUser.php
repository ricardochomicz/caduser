<?php

namespace App\Traits;

use App\Helpers\MessageHelper;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

trait AuthorizeUser
{
    protected function authorizeUser($id)
    {

        // Verifica se o usuário logado é um gerente
        $loggedUserId = Auth::id();

        if ($id === $loggedUserId) {
            return true;
        }
        $isManager = User::where('id', $loggedUserId)->value('manager_id') === null;
        if ($isManager) {
            $managedUserId = User::where('id', $id)->value('manager_id');
            if ($managedUserId === $loggedUserId) {
                return true;
            } else {
                MessageHelper::flashError("Você não tem permissão para acessar esse registro.");
                return redirect()->back();
            }
        }
        MessageHelper::flashError("Você não tem permissão para acessar esse registro.");
        return redirect()->back();
    }

    protected function managerAuthorize($id)
    {
        $loggedUser = Auth::id();
        $managerId = User::where('id', $loggedUser)->value('manager_id');
        if ($managerId) {
            MessageHelper::flashError("Você não tem permissão para acessar essa página.");
            return false;
        }
        return true;
    }
}
