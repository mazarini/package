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

namespace Mazarini\PackageBundle\Tool;

class Loader
{
    private $why = [];

    protected function getFile(string $file): array
    {
        if (!file($file)) {
            throw new \RuntimeException(sprintf('The "%s" file does not exist', $file));
        }
        $content = file_get_contents($file);
        if (false === $content) {
            throw new \RuntimeException(sprintf('Error reading file "%s"', $file));
        }

        return json_decode($content, true);
    }

    public function getRequire($dev, $prod): array
    {
        $array = $this->getfile('composer.json');

        $require = [];
        if ($prod) {
            foreach ($array['require'] as $name => $version) {
                $require[$name] = ['version' => $version, 'dev' => ''];
            }
        }
        if ($dev) {
            foreach ($array['require-dev'] as $name => $version) {
                $require[$name] = ['version' => $version, 'dev' => 'yes'];
            }
        }
        ksort($require);

        return $require;
    }

    public function getInstalled($dev, $prod): array
    {
        $array = $this->getfile('composer.lock');
        $installed = [];
        if ($prod) {
            foreach ($array['packages'] as $package) {
                $installed[$package['name']] = ['version' => $package['version'], 'dev' => ''];
            }
        }
        if ($dev) {
            foreach ($array['packages-dev'] as $package) {
                $installed[$package['name']] = ['version' => $package['version'], 'dev' => 'yes'];
            }
        }
        ksort($installed);

        return $installed;
    }

    public function getWhy()
    {
        $because = 'require';
        $requires = $this->getRequire(true, true);
        foreach ($requires as $why => $dummy) {
            $this->why[$why][$because] = false;
        }
        $json = $this->getfile('composer.lock');
        foreach ($json['packages'] as $package) {
            foreach ($package['require'] as $why => $dummy) {
                $this->why[$why][$package['name']] = true;
            }
        }
        foreach ($json['packages-dev'] as $package) {
            foreach ($package['require'] as $why => $version) {
                $this->why[$why][$package['name']] = true;
            }
        }
        $end = false;
        while (!$end) {
            $end = true;
            foreach ($this->why as $why => $becauses) {
                foreach ($becauses as $because => $ko) {
                    if ($ko) {
                        $this->why[$why][$because] = false;
                        foreach ($this->why[$because] as $because2 => $dummy) {
                            if (!isset($this->why[$why][$because2])) {
                                $this->why[$why][$because2] = ('require' !== $because2);
                                $end = false;
                            }
                        }
                    }
                }
            }
        }
        foreach ($this->why as $why => $becauses) {
            ksort($this->why[$why]);
        }
        ksort($this->why);

        return $this->why;
    }
}
