<?php

namespace Smpl\DI\Contracts;

interface ContainerAware
{
    /**
     * Set the container instance
     *
     * @param \Smpl\DI\Contracts\Container $container
     *
     * @return static
     */
    public function setContainer(Container $container): static;

    /**
     * Check if a container instance is present
     *
     * @return bool
     */
    public function hasContainer(): bool;

    /**
     * Get the container instance
     *
     * @return \Smpl\DI\Contracts\Container
     */
    public function getContainer(): Container;
}
