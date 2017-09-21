<?php

namespace Swis\LaravelApi\Services;

class CustomFileGenerator
{
    private $modelName;
    private $stubVariables;

    public function __construct()
    {
    }

    protected function setStubVars()
    {
        $this->stubVariables = [
            '$MODEL_NAME$' => $this->modelName,
            '$NAMESPACE_MODEL$' => config('infyom.laravel_generator.namespace.model'),
            '$NAMESPACE_MODEL_EXTEND$' => config('infyom.laravel_generator.model_extend_class'),
            '$NAME_SPACE_REPOSITORY$' => config('infyom.laravel_generator.namespace.repository'),
            '$NAMESPACE_SCHEMA$' => config('laravel_api.namespace.schema'),
            '$NAME_SPACE_POLICY$' => config('laravel_api.namespace.policy'),
            '$NAMESPACE_REPOSITORY$' => config('laravel_api.namespace.repository'),
            '$NAMESPACE_CONTROLLER$' => config('laravel_api.namespace.controller')
        ];

        return $this;
    }

    public function generate($classExtensionName, $stubName, $path)
    {
        if (file_exists($path.$this->modelName.$classExtensionName.'.php')) {
            return;
        }

        $this->setStubVars();

        $filledStub = $this->getStub($stubName);
        $filledStub = $this->fillStub($this->stubVariables, $filledStub);
        $this->createFile($path, $this->modelName.$classExtensionName.'.php', $filledStub);
    }

    public function setModelName($modelName)
    {
        $this->modelName = $modelName;

        return $this;
    }

    public static function createFile($path, $classExtensionName, $filledStub)
    {
        if (!is_dir($path)) {
            mkdir($path);
        }

        $path = $path.$classExtensionName;

        file_put_contents($path, $filledStub);
    }

    protected function getStubDir($stub)
    {
        $stubName = str_replace('.', '/', $stub);

        return config('laravel_api.path.templates').$stubName.'.stub';
    }

    protected function getStub($templateName)
    {
        $path = $this->getStubDir($templateName);

        return file_get_contents($path);
    }

    protected function fillStub($variables, $stub)
    {
        foreach ($variables as $variable => $value) {
            $stub = str_replace($variable, $value, $stub);
        }

        return $stub;
    }
}
