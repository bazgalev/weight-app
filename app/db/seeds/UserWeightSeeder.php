<?php


use Phinx\Seed\AbstractSeed;

class UserWeightSeeder extends BaseSeeder
{
    public function getDependencies()
    {
        return [
            'UserSeeder'
        ];
    }

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
        $ids = $this->getUsersIds();

        $weights = [];
        for ($i = 0; $i < 200; $i++) {
            $userId = $ids[array_rand($ids)];
            $weights[] = [
                'user_id' => $userId,
                'weight_date' => $this->faker->date(),
                'weight_value' => $this->faker->numberBetween(500,300000)
            ];
        }
        $this->table('users_weight')->insert($weights)->saveData();
    }

    /**
     * @return int[]
     */
    private function getUsersIds(): array
    {
        $ids = $this->adapter->fetchAll('select * from users');
        return array_map(fn($ids) => (int)$ids['id'], $ids);
    }
}
