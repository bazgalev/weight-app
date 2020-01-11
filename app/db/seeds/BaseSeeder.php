<?php


use Faker\Factory;
use Phinx\Seed\AbstractSeed;

class BaseSeeder extends AbstractSeed
{
    protected Faker\Generator $faker;

    protected function init()
    {
        $this->faker = Factory::create('ru_RU');
        parent::init();
    }
}
