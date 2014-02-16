<?php

namespace Shop\Tests\Functional;

use Doctrine\ORM\EntityManager;
use \Silex\WebTestCase;

class ShopWebTestCase extends WebTestCase
{
    public function createApplication()
    {
        putenv('APP_ENV=test');
        return require __DIR__.'/../../../app.php';
    }

    public function setUp()
    {
        parent::setUp();

        putenv('APP_ENV=test');

        $command = 'cd ' . realpath(__DIR__ . '/../../../');

        $commands = [
            './vendor/bin/doctrine orm:schema-tool:drop --force',
            './vendor/bin/doctrine orm:schema-tool:update --force',
            './bin/load-fixtures.sh'
        ];

        foreach ($commands as $c) {
            $command .= ' && APP_ENV=test ' . $c;
        }

        exec($command, $output);
    }

    /**
     * @return EntityManager
     */
    protected function getEm()
    {
        return $this->app['db.em'];
    }
}