<?php
/*
 * Used by http://deployer.org/
 * This file has been generated automatically.
 * Please change the configuration for correct use deploy.
 */

require 'recipe/symfony3.php';

// Set configurations
set('repository', 'https://github.com/stefanius/nationale-feestdag');

// Symfony shared dirs
set('shared_dirs', ['var/cache', 'var/logs', 'var/sessions']);

// Symfony shared files
set('shared_files', ['app/config/parameters.yml']);

// Symfony writable dirs
set('writable_dirs', ['var/cache', 'var/logs', 'var/sessions']);

// Assets
set('assets', ['web/css', 'web/images', 'web/js']);

// Environment vars
env('env_vars', 'SYMFONY_ENV=prod');
env('env', 'prod');


// Configure servers
server('production', 'nationale-feestdag.nl')
    ->user('web')
    ->identityFile()
    ->env('deploy_path', '/home/web/sites/nationale-feestdag.nl');

/**
 * Main task
 */
task('deploy', [
    'deploy:prepare',
    'deploy:release',
    'deploy:update_code',
    'deploy:shared',
    'deploy:vendors',
    'deploy:writable',
    'deploy:symlink',
    'cleanup',
])->desc('Deploy your project');

after('deploy', 'success');
