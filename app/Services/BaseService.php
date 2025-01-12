<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BaseService
{
    protected function beginTransaction()
    {
        DB::beginTransaction();
    }

    protected function commitTransaction()
    {
        DB::commit();
    }

    protected function rollBackTransaction()
    {
        DB::rollBack();
    }

    protected function executeTransaction(callable $callback)
    {
        try {
            $this->beginTransaction();
            $result = $callback();
            $this->commitTransaction();
            return $result;
        } catch (\Throwable $e) {
            $this->rollBackTransaction();
            throw $e;
        }
    }

    public function buildQuery($model)
    {
        $loggedUser = Auth::id();
        $managerId = User::where('id', $loggedUser)->value('manager_id');
        $query = $model::query();
        if ($managerId === null) {
            $query->where(function ($q) use ($loggedUser) {
                $q->where('user_id', $loggedUser)
                    ->orWhereIn('user_id', function ($subQuery) use ($loggedUser) {
                        $subQuery->select('id')->from('users')->where('manager_id', $loggedUser);
                    });
            });
        } else {
            if (method_exists($model, 'users')) {
                $query->with('users')->where(function ($q) use ($loggedUser) {
                    $q->where('user_id', $loggedUser)->orWhereHas('users', function ($subQuery) use ($loggedUser) {
                        $subQuery->where('users.id', $loggedUser);
                    });
                });
            } else {
                $query->where('user_id', $loggedUser);
            }
        }
        return $query;
    }
}
