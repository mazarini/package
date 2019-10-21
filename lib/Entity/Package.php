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

namespace Mazarini\PackageBundle\Entity;

class Package
{
    private $name = '';

    private $version = '';

    private $requireVersion = '';

    private $dev = false;

    private $requireDev = false;

    private $requirers = [];

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getVersion(): string
    {
        return $this->version;
    }

    public function setVersion(string $version): self
    {
        if (mb_strlen($version) > 15) {
            $parts = explode('-', $version);
            $this->version = $parts[0];
        } else {
            $this->version = $version;
        }

        return $this;
    }

    public function isDev(): bool
    {
        return $this->dev;
    }

    public function getDev(): string
    {
        if ($this->dev) {
            return 'dev';
        }

        return '';
    }

    public function setDev(bool $dev): self
    {
        $this->dev = $dev;

        return $this;
    }

    public function getRequireVersion(): string
    {
        return $this->requireVersion;
    }

    public function setRequireVersion(string $requireVersion): self
    {
        $this->requireVersion = $requireVersion;

        return $this;
    }

    public function isRequire(): bool
    {
        return '' !== $this->requireVersion;
    }

    public function isRequireDev(): bool
    {
        return $this->requireDev;
    }

    public function getRequire(): string
    {
        if (!$this->isRequire()) {
            return '';
        }
        if ($this->requireDev) {
            return 'require-dev';
        }

        return 'require';
    }

    public function setRequireDev(bool $requireDev): self
    {
        $this->requireDev = $requireDev;

        return $this;
    }

    public function addRequirer(self $package): bool
    {
        if (isset($this->requirers[$package->getName()])) {
            return false;
        }
        $this->requirers[$package->getName()] = $package;

        return true;
    }

    public function getRequirers(): array
    {
        return $this->requirers;
    }

    public function cleanRequirer(): self
    {
        $this->requirers = array_filter($this->requirers, function ($package) { return $package->isRequire(); });
        ksort($this->requirers);

        return $this;
    }
}
