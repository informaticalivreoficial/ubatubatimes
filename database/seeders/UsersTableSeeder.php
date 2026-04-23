<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Criar roles
        Role::firstOrCreate(['name' => 'super-admin']);
        Role::firstOrCreate(['name' => 'employee']);

        // Criar ou recuperar admin
        $user = User::firstOrCreate(
            ['email' => env('ADMIN_EMAIL')],
            [
                'name' => env('ADMIN_NOME'),
                'email_verified_at' => now(),
                'password' => bcrypt(env('ADMIN_PASS')),
                'remember_token' => \Illuminate\Support\Str::random(10),
                'status' => 1,
            ]
        );

        // Garantir role
        if (!$user->hasRole('super-admin')) {
            $user->assignRole('super-admin');
        }

        // Criar usuários fake + roles
        User::factory()
            ->count(20)
            ->create()
            ->each(function ($user) {
                $user->assignRole('employee');
            });
    }
}
