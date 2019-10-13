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
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class WhyCommand extends Command
{
    protected static $defaultName = 'package:why';

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
        $requires = $loader->getRequire(true, true);
        $lines = [];
        $whys = $loader->getWhy();
        foreach ($whys as $why => $becauses) {
            if (('php' !== $why) && ('ext-' !== mb_substr($why, 0, 4))) {
                foreach ($becauses as $because => $dummy) {
                    if ('require' !== $because) {
                        if (isset($requires[$because])) {
                            if ('yes' === $requires[$because]['dev']) {
                                if ($dev) {
                                    $require = 'require-dev';
                                    $lines[] = [$why, $because, $require];
                                }
                            } else {
                                if ($prod) {
                                    $require = 'require';
                                    $lines[] = [$why, $because, $require];
                                }
                            }
                        }
                    }
                }
            }
        }
        $table = new table($output);
        $table->setHeaders(['why', 'because', 'composer']);
        $table->setRows($lines);
        $table->render();
    }
}
