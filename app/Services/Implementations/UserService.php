<?php

namespace App\Services\Implementations;

use App\Models\User;
use App\Services\UserInterface;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Password;

class UserService implements UserInterface
{

    public function destroy(int $userId): bool
    {
        return User::findOrFail($userId)->delete();
    }

    public function store(array $data): bool
    {
        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:' . User::class,
            'password' => 'required|confirmed',
            'role' => 'required|in:petugas,admin,manager|string|max:10',

        ]);

        if ($validator->fails()) {
            Log::warning('Request data failed: ' . $validator->errors());
        }

        $validatedData = $validator->validated();

        try {
            User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'role' => $validatedData['role']
            ]);
            return true;
        } catch (\Exception $e) {
            Log::warning('Gagal menambahkan user: ' . $e->getMessage());
            return false;
        }
    }

    public function update(int $userId, array $data): bool
    {
        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|',
            'password' => 'nullable|confirmed|',
            'role' => 'nullable|in:petugas,admin,manager|string|max:10',

        ]);

        if ($validator->fails()) {
            Log::warning('Request data failed: ' . $validator->errors());
        }

        $validatedData = $validator->validated();

        try {
            $user = User::findOrFail($userId);

            $user->update([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'role' => $validatedData['role']
            ]);
            return true;
        } catch (Exception $e) {
            Log::warning('Gagal mengupdate user: ' . $e->getMessage());
            return false;
        }
    }
}
