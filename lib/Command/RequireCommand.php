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
use Symfony\Bundle\FrameworkBundle\Console\Helper\DescriptorHelper;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class RequireCommand extends Command
{
    protected static $defaultName = 'package:require';

    protected function configure()
    {
        $this
        ->setDefinition([
        ])
            ->setDescription('List the required packages')
            ->addOption('dev', null, InputOption::VALUE_NONE, 'require-dev only')
            ->addOption('no-dev', null, InputOption::VALUE_NONE, 'require only')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $dev = $input->getOption('dev');
        $prod = $input->getOption('no-dev');
        if (!$dev && !$prod) {
            $dev = true;
            $prod = true;
        }

        $loader = new Loader();
        $helper = new DescriptorHelper(null);
        $installed = $loader->getInstalled($dev, $prod);
        $lines = [];
        foreach ($loader->getRequire($dev, $prod) as $name => $data) {
            if ((($dev && $data['dev']) or ($prod && !$data['dev'])) && isset($installed[$name])) {
                $lines[] = [$name, $data['version'], $installed[$name]['version'], $data['dev']];
            }
        }
        $table = new table($output);
        $table->setHeaders(['package', 'req.', 'install', 'dev']);
        $table->setRows($lines);
        $table->render();
        $output->writeln(sprintf('%d packages.', \count($lines)));
    }
}
