<?php

namespace Laraflock\Dashboard\Repositories\Module;

interface ModuleRepositoryInterface
{
    /**
     * Registers a dashboard module into the ecosystem
     *
     * @param ModuleInterface $module
     * @return bool
     */
    public function register(ModuleInterface $module);

    /**
     * Loads all registered dashboard modules
     *
     * @return array
     */
    public function getRegistered();

    /**
     * Verify whether a module has been registered
     *
     * @param ModuleInterface $module
     * @return mixed
     */
    public function isRegistered(ModuleInterface $module);
}