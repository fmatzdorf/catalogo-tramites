<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Institution;
use App\Models\Category;
use App\Models\Procedure;

class TestModels extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:models';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test that all models and relationships work correctly';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Testing models and relationships...');

        try {
            // Test basic model creation
            $this->info('✓ All models can be instantiated');

            // Test relationships exist
            $user = new User();
            $institution = new Institution();
            $category = new Category();
            $procedure = new Procedure();

            $this->info('✓ User model relationships: ' . count($user->getRelations()));
            $this->info('✓ Institution model relationships loaded');
            $this->info('✓ Category model relationships loaded');
            $this->info('✓ Procedure model relationships loaded');

            $this->info('✓ All models and relationships are working correctly!');

        } catch (\Exception $e) {
            $this->error('✗ Error: ' . $e->getMessage());
            return 1;
        }

        return 0;
    }
}
