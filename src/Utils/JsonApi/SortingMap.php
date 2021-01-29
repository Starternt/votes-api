<?php

namespace App\Utils\JsonApi;

use InvalidArgumentException;
use Neomerx\JsonApi\Contracts\Encoder\Parameters\SortParameterInterface;
use Neomerx\JsonApi\Encoder\Parameters\SortParameter;

/**
 * Mapping configuration for sorting parameters
 *
 * @package App\Utils\JsonApi
 */
class SortingMap
{
    /**
     * Default sorting field
     *
     * @var SortParameterInterface
     */
    protected $defaultField;

    /**
     * Resource aliases
     *
     * @var array
     */
    protected $resourceAliases;

    /**
     * Field aliases
     *
     * @var array
     */
    protected $fieldAliases;

    /**
     * Constructor
     *
     * @param string|SortParameterInterface|null $default
     * @param array $resourceAliases
     * @param array $fieldAliases
     */
    public function __construct($default = null, array $resourceAliases = [], array $fieldAliases = [])
    {
        $this
            ->setDefaultSortingField($default)
            ->setResourceAliases($resourceAliases)
            ->setFieldAliases($fieldAliases);
    }

    /**
     * Add alias for specified resource field
     *
     * @param string $field
     * @param string $alias
     * @param string $resource
     *
     * @return SortingMap
     */
    public function addFieldAlias($field, $alias, $resource = ''): self
    {
        if (!array_key_exists($resource, $this->fieldAliases)) {
            $this->fieldAliases[$resource] = [];
        }

        $this->fieldAliases[$resource][$field] = $alias;

        return $this;
    }

    /**
     * Sets field aliases
     *
     * @param array $map
     *
     * @return $this
     */
    public function setFieldAliases(array $map): self
    {
        $this->fieldAliases = [];

        foreach ($map as $resource => $fields) {
            foreach ($fields as $field => $alias) {
                $this->addFieldAlias($field, $alias, $resource);
            }
        }

        return $this;
    }

    /**
     * Returns alias for specified resource field
     *
     * @param string $field
     * @param string $resource
     *
     * @return string|null
     */
    public function getFieldAlias($field, $resource = ''): ?string
    {
        if (!isset($this->fieldAliases[$resource][$field])) {
            return null;
        }

        return $this->fieldAliases[$resource][$field];
    }

    /**
     * Add resource alias
     *
     * @param string $resource
     * @param string $alias
     *
     * @return self
     */
    public function addResourceAlias($resource, $alias): self
    {
        $this->resourceAliases[$resource] = $alias;

        return $this;
    }

    /**
     * Sets resource aliases
     *
     * @param array $map
     *
     * @return $this
     */
    public function setResourceAliases(array $map): self
    {
        $this->resourceAliases = [];

        foreach ($map as $resource => $alias) {
            $this->addResourceAlias($resource, $alias);
        }

        return $this;
    }

    /**
     * Returns alias for specified resource
     *
     * @param string $resource
     *
     * @return string|null
     */
    public function getResourceAlias($resource): ?string
    {
        return (array_key_exists($resource, $this->resourceAliases)) ? $this->resourceAliases[$resource] : null;
    }

    /**
     * Sets default sorting field
     *
     * @param string|SortParameterInterface $field
     *
     * @return $this
     */
    public function setDefaultSortingField($field = null): self
    {
        if (is_string($field)) {
            $this->defaultField = new SortParameter($field, true);
        } elseif ($field instanceof SortParameterInterface) {
            $this->defaultField = $field;
        } elseif (null !== $field) {
            throw new InvalidArgumentException(
                sprintf(
                    "Value must be a string or %s instance",
                    SortParameterInterface::class
                )
            );
        }

        return $this;
    }

    /**
     * Returns default sorting field
     *
     * @return SortParameterInterface|null
     */
    public function getDefaultSortingField(): ?SortParameterInterface
    {
        return $this->defaultField;
    }
}