{{$cluster := or (env "CLUSTER") "production"}}

# This file is the entry point to configure your own services.
# Files in the packages/ subdirectory configure your dependencies.

# Put parameters here that don't need to change on each machine where the app is deployed
# https://symfony.com/doc/current/best_practices/configuration.html#application-related-configuration

parameters:
    app.environment: '%env(resolve:APP_ENV)%'
    {{ range $idx, $node := service (printf "%s.kafka" $cluster)}}
    kafka.host: '{{ $node.Address }}'
    kafka.port: {{ $node.Port }}{{end}}
    {{range $idx, $node := service (printf "%s.mysql" $cluster) }}{{ if eq $idx 0 }}
    host: '{{ $node.Address }}'
    port: {{ $node.Port }}{{ end }}{{ end }}
services:
    # default configuration for services in *this* file
    _defaults:
        autowire: true      # Automatically injects dependencies in your services.
        autoconfigure: true # Automatically registers your services as commands, event subscribers, etc.

    # makes classes in src/ available to be used as services
    # this creates a service per class whose id is the fully-qualified class name
    App\:
        resource: '../src/*'
        exclude: '../src/{DependencyInjection,Entity,Tests,Dto,Schema,Utils,Event,Kernel.php}'

    app.gelf_formatter:
        class: 'Monolog\Formatter\GelfMessageFormatter'
        arguments: ['votes-api']

    # controllers are imported separately to make sure services can be injected
    # as action arguments even if you don't extend any base controller class
    App\Controller\:
        resource: '../src/Controller'
        tags: ['controller.service_arguments']

    App\Utils\DataMappers\VotesMapper:
        arguments:

    App\Service\VotesService:
        arguments:
            - '%kafka.host%'
            - '%kafka.port%'