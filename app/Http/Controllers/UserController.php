<?php

use App\Services\UserService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    protected $userService;

    // Injeção via Service Container
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function store(Request $request)
    {
        $data = $request->only(['name', 'email', 'bio']);

        $user = $this->userService->createUserWithProfile($data);

        return response()->json($user->load('profile'));
    }

    public function delete(Request $request, $id)
    {
        $this->userService->deleteUser($id);

        return response()->json(['message' => 'User deleted successfully']);
    }
}
