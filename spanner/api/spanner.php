<?php
/**
 * Copyright 2016 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Cloud\Samples\Spanner;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputDefinition;

# Includes the autoloader for libraries installed with composer
require __DIR__ . '/vendor/autoload.php';

$application = new Application();

$inputDefinition = new InputDefinition([
    new InputArgument('instance_id', InputArgument::REQUIRED, 'The instance id'),
    new InputArgument('database_id', InputArgument::REQUIRED, 'The database id'),
]);

// Create Database command
$application->add((new Command('create_database'))
    ->setDefinition($inputDefinition)
    ->addArgument('some_argument', InputArgument::OPTIONAL, 'an additional argument for kicks')
    ->addOption('some_option', null, InputOption::VALUE_REQUIRED, 'an additional option for kicks')
    ->setCode(function($input, $output) {
        create_database(
            $input->getArgument('instance_id'),
            $input->getArgument('database_id')
        );
    })
);

// Insert data command
$application->add((new Command('insert_data'))
    ->setDefinition($inputDefinition)
    ->setCode(function($input, $output) {
        insert_data(
            $input->getArgument('instance_id'),
            $input->getArgument('database_id')
        );
    })
);

$application->run();
