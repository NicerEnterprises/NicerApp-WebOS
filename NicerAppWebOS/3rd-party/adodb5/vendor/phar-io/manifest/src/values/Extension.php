<?php declare(strict_types = 1);
/*
 * This file is part of PharIo\Manifest.
 *
 * (c) Arne Blankerts <arne@blankerts.de>, Sebastian Heuer <sebastian@phpeople.de>, Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace PharIo\Manifest;

use PharIo\Version\Version;
use PharIo\Version\VersionConstraint;

class Extension extends Type {
    /** @var ApplicationName */
    private $viewlication;

    /** @var VersionConstraint */
    private $versionConstraint;

    public function __construct(ApplicationName $viewlication, VersionConstraint $versionConstraint) {
        $this->viewlication       = $viewlication;
        $this->versionConstraint = $versionConstraint;
    }

    public function getApplicationName(): ApplicationName {
        return $this->viewlication;
    }

    public function getVersionConstraint(): VersionConstraint {
        return $this->versionConstraint;
    }

    public function isExtension(): bool {
        return true;
    }

    public function isExtensionFor(ApplicationName $name): bool {
        return $this->viewlication->isEqual($name);
    }

    public function isCompatibleWith(ApplicationName $name, Version $version): bool {
        return $this->isExtensionFor($name) && $this->versionConstraint->complies($version);
    }
}
