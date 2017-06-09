<?php
    class ExampleTest extends TestCase
    {
        public function testBasicExample()
        {
            $db = $this->em('city');

            $db->persist(['name' => 'Paris']);

            return $this->assertEquals(1, $db->count());
        }
    }
