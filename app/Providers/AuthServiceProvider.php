<?php

namespace App\Providers;

use App\Models\Berita; // Import Model
use App\Policies\BeritaPolicy; // Import Policy
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // Letakkan di sini: 'NamaModel' => 'NamaPolicy'
        \App\Models\Berita::class => \App\Policies\BeritaPolicy::class,
        \App\Models\DaftarKegiatan::class => \App\Policies\DaftarKegiatanPolicy::class,
        \App\Models\Lpj::class => \App\Policies\LpjPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies(); // Pastikan baris ini ada (opsional di Laravel versi terbaru, tapi baik untuk disertakan)
    }
}