<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ServiceServiceProvider extends ServiceProvider
{
    /**
     * Path que é utilizado para realizar o use
     * das classes de implementação das services
     *
     * @var array
     */
    protected $implementationPaths = [
        'default' => 'App\\Services\\',
    ];

    /**
     * Path que é utilizado para realizar o use
     * das classes de interface das services
     *
     * @var array
     */
    protected $interfacePaths = [
        'default' => 'App\\Services\\Contracts\\',
    ];

    /**
     * Path dos diretórios que são utilizados
     * para salvar as classes de service
     *
     * @var array
     */
    protected $directoriesPaths = [
        'default' => 'Services/Contracts',
    ];

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        array_walk($this->implementationPaths, function ($implementationPath, $identifier) {
            // Verificando se o diretório existe
            if (!file_exists(app_path($this->directoriesPaths[$identifier]))) {
                return false;
            }

            // Obtendo todas as interfaces declaradas
            $interfaces = collect(scandir(app_path($this->directoriesPaths[$identifier])));

            // Obtendo o nome das interfaces sem a extensão do arquivo
            $interfaces = $interfaces->reject(function ($interface) {
                return in_array($interface, ['.', '..']);
            })
            ->map(function ($interface) {
                return str_replace('.php', '', $interface);
            });

            // Ralizando o bind da classe que irá implementar a interface
            $interfaces->each(function ($interfaceClassName) use ($implementationPath, $identifier) {
                $serviceClassName = str_replace('Interface', '', $interfaceClassName);

                $pathInterfaceClass = $this->interfacePaths[$identifier] . $interfaceClassName;
                $pathImplementationClass = $implementationPath . $serviceClassName;

                $this->app->bind(
                    $pathInterfaceClass,
                    $pathImplementationClass
                );
            });
        });
    }
}
