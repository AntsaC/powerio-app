<?php

namespace App\Providers;

use App\Contracts\AgentIAInterface;
use App\Services\AI\AgentIAService;
use App\Services\AI\OpenAIAgent;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Bind the AgentIA interface to OpenAI implementation
        $this->app->bind(AgentIAInterface::class, function ($app) {
            $model = config('services.openai.model', 'gpt-4o');
            return new OpenAIAgent($model);
        });

        // Register AgentIAService as singleton
        $this->app->singleton(AgentIAService::class, function ($app) {
            return new AgentIAService($app->make(AgentIAInterface::class));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
