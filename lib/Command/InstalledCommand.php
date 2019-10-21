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

namespace Mazarini\PackageBundle\Command;

use Mazarini\PackageBundle\Tool\Loader;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class InstalledCommand extends Command
{
    protected static $defaultName = 'package:installed';

    protected function configure()
    {
        $this
            ->setDescription('List the intalled packages')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $loader = new Loader();
        $lines = [];
        foreach ($loader->getInstalled(true, true) as $package) {
            $lines[] = [$package->getName(), $package->getDev(), $package->getVersion(), $package->getRequire(), $package->getRequireVersion()];
        }
        $table = new table($output);
        $table->setHeaders(['package', 'dev', 'version', 'require', 'version']);
        $table->setRows($lines);
        $table->render();
        $output->writeln(sprintf('%d packages.', \count($lines)));

        return 0;
    }
}
