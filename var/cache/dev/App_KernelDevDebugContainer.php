<?php

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.

if (\class_exists(\ContainerM0th7PI\App_KernelDevDebugContainer::class, false)) {
    // no-op
} elseif (!include __DIR__.'/ContainerM0th7PI/App_KernelDevDebugContainer.php') {
    touch(__DIR__.'/ContainerM0th7PI.legacy');

    return;
}

if (!\class_exists(App_KernelDevDebugContainer::class, false)) {
    \class_alias(\ContainerM0th7PI\App_KernelDevDebugContainer::class, App_KernelDevDebugContainer::class, false);
}

return new \ContainerM0th7PI\App_KernelDevDebugContainer([
    'container.build_hash' => 'M0th7PI',
    'container.build_id' => 'd82a54d2',
    'container.build_time' => 1611885801,
], __DIR__.\DIRECTORY_SEPARATOR.'ContainerM0th7PI');