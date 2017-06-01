<?php
    namespace OctoTests;

    use Octo\Tests;

    class SimpleTest extends Tests
    {
        public function __construct()
        {
            parent::__construct();
        }

        /**
         * test coords
         *
         * @return void
         */
        public function testDummy()
        {
            $example = 1;
            $this->isEqual($example, 1);
        }
    }
