<?php
    namespace App;

    function ownNamespace($from = null, $to = 'Octo')
    {
        $from = empty($from) ? __NAMESPACE__ : $from;

        foreach (get_defined_functions() as $group) {
            foreach ($group as $function) {
                if (strstr($function, \Octo\Strings::lower($to) . '\\')) {
                    $native = \Octo\str_replace_first(\Octo\Strings::lower($to) . '\\', \Octo\Strings::lower($from) . '\\', $function);

                    if (!function_exists($native)) {
                        $fn = str_replace(\Octo\Strings::lower($from) . '\\', '', $native);

                        $code = 'namespace ' . $from . ' {
                            function '. $fn .' ()
                            {
                                return call_user_func_array("' . $function . '", func_get_args());
                            };
                        };';

                        eval($code);
                    }
                }
            }
        }
    }

    ownNamespace();
