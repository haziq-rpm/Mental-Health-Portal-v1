<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

// Register your policy classes here
use App\Models\SessionNote;
use App\Policies\SessionNotePolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        SessionNote::class => SessionNotePolicy::class,
        // Add other model => policy mappings here
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Optional: additional gates
        // Gate::define('view-sessionnote', [SessionNotePolicy::class, 'view']);
    }
}
