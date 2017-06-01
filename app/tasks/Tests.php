<?php
    namespace OctoTask;

    use Octo\Arrays;
    use Octo\Config;
    use Octo\Cli;

    use function Octo\maker;
    use function Octo\lib;
    use function Octo\dd;

    class Tests
    {
        public static function run($dir = null)
        {
            lib('tests');

            Cli::show("Start of execution", 'COMMENT');

            if (empty($dir) || !is_dir($dir)) {
                $dir = Config::get('dir.tests', realpath(__DIR__ . '/../tests'));
            }

            if (is_dir($dir)) {
                $files = glob($dir . DS . '*Test.php');

                foreach ($files as $file) {
                    require_once $file;

                    Cli::show("Start of tests '" . str_replace('.php', '', Arrays::last(explode(DS, $file))) . "'", 'COMMENT');

                    $class = 'OctoTests\\' . str_replace('.php', '', Arrays::last(explode(DS, $file)));

                    $instance = maker($class);

                    $methods = get_class_methods($instance);

                    foreach ($methods as $method) {
                        if (fnmatch('test*', $method)) {
                            @$instance->$method();
                        }
                    }

                    $good   = $instance->assert->getGood();
                    $bad    = $instance->assert->getBad();

                    $goodtest   = $good > 1 ? 'tests' : 'test';
                    $badtest    = $bad > 1  ? 'tests' : 'test';

                    Cli::show("$good $goodtest OK", 'SUCCESS');

                    if (0 < $bad) {
                        Cli::show("$bad $badtest NOK", 'ERROR');

                        $errors = $instance->assert->getErrors();

                        Cli::show("List of $bad $badtest failed", 'COMMENT');

                        foreach ($errors as $error) {
                            extract($error);
                            Cli::show("$file [$test, line $line] => $code, error [$error]", 'ERROR');
                        }
                    }

                    $sum = $good + $bad;

                    Cli::show("End of $sum tests '" . str_replace('.php', '', Arrays::last(explode(DS, $file))) . "'", 'COMMENT');
                }
            }

            Cli::show("End of execution", 'COMMENT');
        }
    }
