<?php

/*
 * Copyright (C) 2019 Mazarini <mazarini@protonmail.com>.
 * This file is part of mazarini/package.
 *
 * mazarini/package is free software: you can redistribute it and/or
 * modify it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or (at your
 * option) any later version.
 *
 * mazarini/pagination is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY
 * or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for
 * more details.
 *
 * You should have received a copy of the GNU General Public License
 */

namespace App\Tests\Command;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class InstalledCommandTest extends KernelTestCase
{
    public function testExecute(): void
    {
        $kernel = static::createKernel();
        $application = new Application($kernel);

        $command = $application->find('package:installed');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'command' => $command->getName(),
        ]);
        $output = $commandTester->getDisplay();
        foreach (['symfony/console', 'symfony/dotenv', 'symfony/flex', 'symfony/framework-bundle', 'symfony/test-pack', 'symfony/yaml'] as $package) {
            $this->assertStringContainsString($package, $output);
        }
    }
}
