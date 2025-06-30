<?php
namespace App\Services;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Support\Facades\DB;
use Exception;

class UserService
{
    public function createUserWithProfile(array $data): User
    {
        DB::beginTransaction();

        try {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
            ]);

            $user->profile()->create([
                'bio' => $data['bio'] ?? '',
            ]);

            DB::commit();
            return $user;

        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function deleteUser(int $id): void
    {
        DB::beginTransaction();

        try {
            $user = User::findOrFail($id);
            $user->profile()->delete();
            $user->delete();

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
