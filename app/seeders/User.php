<?php
    namespace App\seeders;

    class User
    {
        public function run($entityManager, $faker)
        {
            $seeds = 100;

            for ($i = 1; $i <= $seeds; $i++) {
                $row = [
                    'name'      => $faker->lastName,
                    'firstname' => $faker->firstName,
                    'email'     => $faker->safeEmail,
                    'password'  => $faker->password
                ];

                $entityManager->store($row);
            }

            return $seeds;
        }
    }
