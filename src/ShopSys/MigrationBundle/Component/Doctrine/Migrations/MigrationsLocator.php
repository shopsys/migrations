<?php

namespace ShopSys\MigrationBundle\Component\Doctrine\Migrations;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\KernelInterface;

class MigrationsLocator
{
    const MIGRATIONS_DIRECTORY = 'Migrations';
    const MIGRATIONS_NAMESPACE = 'Migrations';

    /**
     * @var \Symfony\Component\HttpKernel\KernelInterface
     */
    private $kernel;

    /**
     * @var \Symfony\Component\Filesystem\Filesystem
     */
    private $filesystem;

    /**
     * @param \Symfony\Component\HttpKernel\KernelInterface $kernel
     * @param \Symfony\Component\Filesystem\Filesystem $filesystem
     */
    public function __construct(KernelInterface $kernel, Filesystem $filesystem)
    {
        $this->kernel = $kernel;
        $this->filesystem = $filesystem;
    }

    /**
     * @return \ShopSys\MigrationBundle\Component\Doctrine\Migrations\MigrationsLocation[]
     */
    public function getMigrationsLocations()
    {
        $migrationsLocations = [];

        foreach ($this->kernel->getBundles() as $bundle) {
            $migrationsDirectory = $bundle->getPath() . '/' . self::MIGRATIONS_DIRECTORY;
            $migrationsNamespace = $bundle->getNamespace() . '\\' . self::MIGRATIONS_NAMESPACE;

            if ($this->filesystem->exists($migrationsDirectory)) {
                $migrationsLocations[] = new MigrationsLocation($migrationsDirectory, $migrationsNamespace);
            }
        }

        return $migrationsLocations;
    }
}
