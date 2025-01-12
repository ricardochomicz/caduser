<?php

namespace App\Http\Controllers;

use App\Helpers\MessageHelper;
use App\Http\Requests\UserRequest;
use App\Services\UserService;
use App\Traits\AuthorizeUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    use AuthorizeUser;

    public function __construct(protected UserService $userService) {}
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $view = [
            'users' => $this->userService->index($request->all())
        ];
        return view('pages.users.index', $view);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $managerUser = $this->managerAuthorize(Auth::id());
        if (!$managerUser) {
            return back();
        }

        return view('pages.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        try {
            $this->userService->store($request->all());
            MessageHelper::flashSuccess('Usuário cadastrado com sucesso!');
            return redirect()->route('users.index');
        } catch (\Throwable $e) {
            MessageHelper::flashError('Erro ao cadastrar a usuário!' . $e->getMessage());
            return back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = $this->userService->get($id);
        if (!$data) {
            MessageHelper::flashError("Ops! Usuário não encontrado.");
            return back();
        }
        // Verifica se o usuário autenticado é o mesmo que o usuário que está sendo editado
        if (!$this->authorizeUser($data->id)) {
            return back();
        }
        $view = [
            'data' => $data,
        ];
        return view('pages.users.edit', $view);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, string $id)
    {
        try {
            $this->userService->update($request->all(), $id);
            MessageHelper::flashSuccess('Usuário atualizado com sucesso.');
            return redirect()->route('users.index');
        } catch (\Throwable $e) {
            MessageHelper::flashError("Ops! Erro ao atualizar." . $e->getMessage());
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $this->userService->destroy($id);
            MessageHelper::flashSuccess('Usuário deletado com sucesso.');
            return redirect()->route('users.index');
        } catch (\Throwable $th) {
            MessageHelper::flashError("Ops! Erro ao desativar.");
            return back();
        }
    }
}
