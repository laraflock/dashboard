<?php

namespace Laraflock\Dashboard\Repositories\Module;

use Illuminate\Support\Collection;

class ModuleRepository implements ModuleRepositoryInterface
{

    /**
     * @var Collection
     */
    protected $modules;

    public function __construct()
    {
        $this->modules = new Collection();
    }

    /**
     * Registers a dashboard module into the ecosystem
     *
     * @param ModuleInterface $module
     * @return bool
     */
    public function register(ModuleInterface $module)
    {
        $this->modules->put(get_class($module), $module);
    }

    /**
     * Loads all registered dashboard modules
     *
     * @return array
     */
    public function getRegistered()
    {
        return $this->modules;
    }

    /**
     * Verify whether a module has been registered
     *
     * @param ModuleInterface $module
     * @return mixed
     */
    public function isRegistered(ModuleInterface $module)
    {
        return $this->modules->offsetExists(get_class($module));
    }
}