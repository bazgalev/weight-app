<?php


use Faker\Factory;
use Phinx\Seed\AbstractSeed;

class UserSeeder extends BaseSeeder
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        $users = [];
        for ($i = 0; $i < 50; $i++) {
            $users[] = $this->generateUser();
        }
        $this->table('users')->insert($users)->saveData();
    }

    private function generateUser(): array
    {
        $name = $this->faker->name;
        $parts = explode(' ', $name);

        return [
            'fname' => $parts[0],
            'lname' => $parts[2]
        ];
    }
}
