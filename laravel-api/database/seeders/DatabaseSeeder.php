<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin Onboarding Setup
        User::firstOrCreate(
            ['email' => 'admin@hyorios.com'],
            [
                'name' => 'Hyorios Admin',
                'password' => bcrypt('password'), // simple password limit context for local setup
                'is_admin' => true,
            ]
        );

        // Demo Case Study Project
        \App\Models\Project::firstOrCreate(
            ['slug' => 'demo-case-study'],
            [
                'title' => [
                    'en' => 'FinTech Scale-up Automation',
                    'de' => 'FinTech Scale-up Automatisierung',
                ],
                'description' => [
                    'en' => 'A complete architectural redesign of legacy banking infrastructure into a reactive, cloud-native microservice environment.',
                    'de' => 'Ein komplettes Redesign der veralteten Bankeninfrastruktur in eine reaktive, Cloud-native Microservice-Umgebung.',
                ],
                'excerpt' => [
                    'en' => 'Migrated monolithic banking logic to 20+ microservices.',
                    'de' => 'Monolithische Banken-Logik auf über 20 Microservices migriert.',
                ],
                'problem' => [
                    'en' => 'Existing infrastructure was slow, expensive to maintain, and lacked horizontal scalability for weekend traffic spikes.',
                    'de' => 'Bestehende Infrastruktur war langsam, teuer in der Wartung und ohne horizontale Skalierbarkeit für Wochenend-Traffic.',
                ],
                'solution' => [
                    'en' => 'We introduced a Kubernetes-based container strategy using Laravel Octane and isolated domain context domains.',
                    'de' => 'Wir führten eine Kubernetes-basierte Containerstrategie mit Laravel Octane und isolierten Domain-Kontexten ein.',
                ],
                'implementation' => [
                    'en' => 'Phased 6-month rollout. Reverse-proxied legacy routes over to the new Nuxt 3 frontend step-by-step.',
                    'de' => 'Gestaffelter 6-Monats-Rollout. Routen wurden schrittweise über Reverse-Proxies an das neue Nuxt 3 Frontend übergeben.',
                ],
                'result' => [
                    'en' => 'Zero-downtime deployment achieved. Response times dropped by 70%.',
                    'de' => 'Deployment ohne Ausfallzeiten. Server-Antwortzeiten sanken um 70%.',
                ],
                'metrics' => json_encode([
                    'Uptime' => '99.99%',
                    'Response Time' => '-70%',
                    'Cloud Costs' => '-40%',
                ]),
                'tech_stack' => ['Laravel', 'Vue 3', 'Kubernetes', 'Redis'],
                'cover_image' => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=800&q=80',
                'repo_url' => 'https://github.com/hyorios/case-study',
                'live_url' => 'https://example.com',
                'is_featured' => true,
                'is_published' => true,
                'published_at' => now(),
            ]
        );
    }
}
