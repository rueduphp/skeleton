<?php
    namespace App\events;

    class Example
    {
        public function getEvents()
        {
            return [
                'example.test' => 'test'
            ];
        }

        public function test()
        {
            /**
                Type event code here
            **/
        }
    }
