<?php
use Faker\Generator;
use Octo\Orm;
class SeederUser15107325967089
{
    public function seeds(Orm $db, Generator $faker)
    {
        for ($i = 0; $i < 100; $i++) {
            $row = [
                'name' => $faker->name
            ];

            $db->insert($row)->into('user')->run();
        }
    }
}