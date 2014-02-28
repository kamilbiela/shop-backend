<?php

namespace Shop\Lib;

use Doctrine\DBAL\Logging\SQLLogger;
use Symfony\Component\Console\Output\ConsoleOutput;

class ShopSQLLogger implements SQLLogger
{
    /**
     * {@inheritdoc}
     */
    public function startQuery($sql, array $params = null, array $types = null)
    {
        $output = new ConsoleOutput();
        if ($c = count($params)) {
            foreach ($params as $v) {
                if ($v instanceof \DateTime) {
                    $v = $v->format('Y-m-d H:i:s');
                }

                if ($v === null) {
                    $v = 'NULL';
                }

                if (is_bool($v)) {
                    $v = $v ? 'TRUE' : 'FALSE';
                }

                $v = '<info>'.$v.'</info>';
                $sql = preg_replace('/\?/', $v, $sql, 1);
            }
        }


        $output->writeln('<info>' . date('H:i:s'). ': </info>' . $sql);

//        if ($params) {
//            var_dump($params);
//        }
//
//        if ($types) {
//            var_dump($types);
//        }
    }

    /**
     * {@inheritdoc}
     */
    public function stopQuery()
    {
    }
}