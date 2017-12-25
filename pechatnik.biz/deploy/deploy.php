<?php

namespace Deployer;

require_once '../vendor/deployer/deployer/recipe/yii2-app-advanced.php';

inventory('hosts.yml');

// Yii 2 Advanced Project Template shared dirs
set('shared_dirs', [
    'frontend/runtime',
    'backend/runtime',
    'console/runtime',
    'backend/web/images'
]);

set('writable_dirs', [
    'frontend/web/assets',
    'backend/web/assets',
    'backend/web/images',
    'backend/web/files'
]);

set('shared_files', [
    '.env.sample',
    '.env',
]);

/**
 * Run migrations
 */
task('deploy:run_migrations', function () {
    run('{{bin/php}} {{release_path}}/console/yii migrate up --interactive=0');
})->desc('Run migrations');

/**
 * Main task
 */
task('deploy', [
    'deploy:info',
    'deploy:prepare',
    'deploy:lock',
    'deploy:release',
    'deploy:update_code',
    'deploy:vendors',
    'deploy:shared',
    'deploy:writable',
    'deploy:run_migrations',
    'deploy:symlink',
    'deploy:unlock',
    'cleanup',
])->desc('Deploy your project');

after('deploy', 'success');