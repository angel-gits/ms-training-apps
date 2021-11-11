<?php

namespace Symfony\Config;

require_once __DIR__.\DIRECTORY_SEPARATOR.'DoctrineMigrations'.\DIRECTORY_SEPARATOR.'StorageConfig.php';

use Symfony\Component\Config\Loader\ParamConfigurator;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;


/**
 * This class is automatically generated to help creating config.
 *
 * @experimental in 5.3
 */
class DoctrineMigrationsConfig implements \Symfony\Component\Config\Builder\ConfigBuilderInterface
{
    private $name;
    private $migrationsPaths;
    private $storage;
    private $dirName;
    private $namespace;
    private $tableName;
    private $columnName;
    private $columnLength;
    private $executedAtColumnName;
    private $allOrNothing;
    private $customTemplate;
    private $organizeMigrations;
    
    /**
     * @default 'Application Migrations'
     * @param ParamConfigurator|mixed $value
     * @deprecated The "name" option is deprecated.
     * @return $this
     */
    public function name($value): self
    {
        $this->name = $value;
    
        return $this;
    }
    
    /**
     * @param ParamConfigurator|mixed $value
     * @return $this
     */
    public function migrationsPaths(string $name, $value): self
    {
        $this->migrationsPaths[$name] = $value;
    
        return $this;
    }
    
    public function storage(array $value = []): \Symfony\Config\DoctrineMigrations\StorageConfig
    {
        if (null === $this->storage) {
            $this->storage = new \Symfony\Config\DoctrineMigrations\StorageConfig($value);
        } elseif ([] !== $value) {
            throw new InvalidConfigurationException('The node created by "storage()" has already been initialized. You cannot pass values the second time you call storage().');
        }
    
        return $this->storage;
    }
    
    /**
     * @default '%kernel.root_dir%/DoctrineMigrations'
     * @param ParamConfigurator|mixed $value
     * @deprecated The "dir_name" option is deprecated. Use "migrations_paths" instead.
     * @return $this
     */
    public function dirName($value): self
    {
        $this->dirName = $value;
    
        return $this;
    }
    
    /**
     * @default 'Application\\Migrations'
     * @param ParamConfigurator|mixed $value
     * @deprecated The "namespace" option is deprecated. Use "migrations_paths" instead.
     * @return $this
     */
    public function namespace($value): self
    {
        $this->namespace = $value;
    
        return $this;
    }
    
    /**
     * @default 'migration_versions'
     * @param ParamConfigurator|mixed $value
     * @deprecated The "table_name" option is deprecated. Use "storage.table_storage.table_name" instead.
     * @return $this
     */
    public function tableName($value): self
    {
        $this->tableName = $value;
    
        return $this;
    }
    
    /**
     * @default 'version'
     * @param ParamConfigurator|mixed $value
     * @deprecated The "column_name" option is deprecated. Use "storage.table_storage.version_column_name" instead.
     * @return $this
     */
    public function columnName($value): self
    {
        $this->columnName = $value;
    
        return $this;
    }
    
    /**
     * @default 14
     * @param ParamConfigurator|mixed $value
     * @deprecated The "column_length" option is deprecated. Use "storage.table_storage.version_column_length" instead.
     * @return $this
     */
    public function columnLength($value): self
    {
        $this->columnLength = $value;
    
        return $this;
    }
    
    /**
     * @default 'executed_at'
     * @param ParamConfigurator|mixed $value
     * @deprecated The "executed_at_column_name" option is deprecated. Use "storage.table_storage.executed_at_column_name" instead.
     * @return $this
     */
    public function executedAtColumnName($value): self
    {
        $this->executedAtColumnName = $value;
    
        return $this;
    }
    
    /**
     * @default false
     * @param ParamConfigurator|mixed $value
     * @return $this
     */
    public function allOrNothing($value): self
    {
        $this->allOrNothing = $value;
    
        return $this;
    }
    
    /**
     * @default null
     * @param ParamConfigurator|mixed $value
     * @return $this
     */
    public function customTemplate($value): self
    {
        $this->customTemplate = $value;
    
        return $this;
    }
    
    /**
     * Organize migrations mode. Possible values are: "BY_YEAR", "BY_YEAR_AND_MONTH", false
     * @default false
     * @param ParamConfigurator|mixed $value
     * @return $this
     */
    public function organizeMigrations($value): self
    {
        $this->organizeMigrations = $value;
    
        return $this;
    }
    
    public function getExtensionAlias(): string
    {
        return 'doctrine_migrations';
    }
            
    
    public function __construct(array $value = [])
    {
    
        if (isset($value['name'])) {
            $this->name = $value['name'];
            unset($value['name']);
        }
    
        if (isset($value['migrations_paths'])) {
            $this->migrationsPaths = $value['migrations_paths'];
            unset($value['migrations_paths']);
        }
    
        if (isset($value['storage'])) {
            $this->storage = new \Symfony\Config\DoctrineMigrations\StorageConfig($value['storage']);
            unset($value['storage']);
        }
    
        if (isset($value['dir_name'])) {
            $this->dirName = $value['dir_name'];
            unset($value['dir_name']);
        }
    
        if (isset($value['namespace'])) {
            $this->namespace = $value['namespace'];
            unset($value['namespace']);
        }
    
        if (isset($value['table_name'])) {
            $this->tableName = $value['table_name'];
            unset($value['table_name']);
        }
    
        if (isset($value['column_name'])) {
            $this->columnName = $value['column_name'];
            unset($value['column_name']);
        }
    
        if (isset($value['column_length'])) {
            $this->columnLength = $value['column_length'];
            unset($value['column_length']);
        }
    
        if (isset($value['executed_at_column_name'])) {
            $this->executedAtColumnName = $value['executed_at_column_name'];
            unset($value['executed_at_column_name']);
        }
    
        if (isset($value['all_or_nothing'])) {
            $this->allOrNothing = $value['all_or_nothing'];
            unset($value['all_or_nothing']);
        }
    
        if (isset($value['custom_template'])) {
            $this->customTemplate = $value['custom_template'];
            unset($value['custom_template']);
        }
    
        if (isset($value['organize_migrations'])) {
            $this->organizeMigrations = $value['organize_migrations'];
            unset($value['organize_migrations']);
        }
    
        if ([] !== $value) {
            throw new InvalidConfigurationException(sprintf('The following keys are not supported by "%s": ', __CLASS__).implode(', ', array_keys($value)));
        }
    }
    
    
    public function toArray(): array
    {
        $output = [];
        if (null !== $this->name) {
            $output['name'] = $this->name;
        }
        if (null !== $this->migrationsPaths) {
            $output['migrations_paths'] = $this->migrationsPaths;
        }
        if (null !== $this->storage) {
            $output['storage'] = $this->storage->toArray();
        }
        if (null !== $this->dirName) {
            $output['dir_name'] = $this->dirName;
        }
        if (null !== $this->namespace) {
            $output['namespace'] = $this->namespace;
        }
        if (null !== $this->tableName) {
            $output['table_name'] = $this->tableName;
        }
        if (null !== $this->columnName) {
            $output['column_name'] = $this->columnName;
        }
        if (null !== $this->columnLength) {
            $output['column_length'] = $this->columnLength;
        }
        if (null !== $this->executedAtColumnName) {
            $output['executed_at_column_name'] = $this->executedAtColumnName;
        }
        if (null !== $this->allOrNothing) {
            $output['all_or_nothing'] = $this->allOrNothing;
        }
        if (null !== $this->customTemplate) {
            $output['custom_template'] = $this->customTemplate;
        }
        if (null !== $this->organizeMigrations) {
            $output['organize_migrations'] = $this->organizeMigrations;
        }
    
        return $output;
    }
    

}
