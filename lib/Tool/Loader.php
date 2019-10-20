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

use Mazarini\PackageBundle\Entity\Package;

class Loader
{
    private $why = [];
    private $packages = [];

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

    public function getRequire(): array
    {
        $this->loadPackages();

        return array_filter($this->packages, function ($package) { return $package->isRequire(); });
    }

    public function getInstalled($dev, $prod): array
    {
        $this->loadPackages();

        if ($dev === $prod) {
            return $this->packages;
        }
        if ($dev) {
            return array_filter($this->packages, function ($package) { return true === $package->isDev; });
        }

        return array_filter($this->packages, function ($package) { return false === $package->isDev; });
    }

    public function getWhy()
    {
        $this->loadPackages();

        $end = false;
        while (!$end) {
            $end = true;
            foreach ($this->packages as $package) {
                foreach ($package->getRequirers() as $requirer) {
                    foreach ($requirer->getRequirers() as $farRequirer) {
                        if ($package->addRequirer($farRequirer)) {
                            $end = false;
                        }
                    }
                }
            }
        }
        foreach ($this->packages as $package) {
            $package->cleanRequirer();
        }
        ksort($this->packages);

        return $this->packages;
    }

    protected function loadRequire(array $packages, bool $dev = false)
    {
        foreach ($packages as $name => $version) {
            $package = $this->getPackage($name, true);
            $package->setRequireVersion($version)
                    ->setRequireDev($dev)
                    ->addRequirer($package);
        }
    }

    protected function loadInstalled(array $packages, bool $dev = false): void
    {
        foreach ($packages as $data) {
            $package = $this->getPackage($data['name']);
            $package->setVersion($data['version'])
                    ->setDev($dev);
            foreach ($data['require'] as $name => $dummy) {
                $this->addRequirer($name, $package);
            }
        }
    }

    protected function loadPackages(): void
    {
        if (\count($this->packages) > 0) {
            return;
        }
        $array = $this->getfile('composer.lock');
        $this->loadInstalled($array['packages'], false);
        $this->loadInstalled($array['packages-dev'], true);
        $array = $this->getfile('composer.json');
        $this->loadRequire($array['require'], false);
        $this->loadRequire($array['require-dev'], true);
        ksort($this->packages);
    }

    protected function addRequirer(string $name, Package $requirer)
    {
        $package = $this->getPackage($name);
        $package->addRequirer($requirer);
    }

    protected function getPackage(string $name, bool $require = false)
    {
        switch (true) {
            case isset($this->packages[$name]):
                $package = $this->packages[$name];
                break;
            case $require && 'php' === $name:
                $package = new Package();
                $package->setName($name);
                $package->setVersion(PHP_VERSION);
                $this->packages[$name] = $package;
                break;
            case $require && 'ext-' === mb_substr($name, 0, 4):
                $package = new Package();
                $package->setName($name);
                $version = phpversion(mb_substr($name, 4));
                if (\is_string($version)) {
                    $package->setVersion($version);
                }
                $this->packages[$name] = $package;
                break;
            case $require:
                throw new \RuntimeException(sprintf('The require package "%s" is not installed', $name));
                break;
            default:
                $package = new Package();
                $package->setName($name);
                $this->packages[$name] = $package;
        }

        return $package;
    }
}
