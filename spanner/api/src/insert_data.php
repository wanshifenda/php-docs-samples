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

/**
 * For instructions on how to run the full sample:
 *
 * @see https://github.com/GoogleCloudPlatform/php-docs-samples/tree/master/spanner/api/README.md
 */

namespace Google\Cloud\Samples\Spanner;

# [START insert_data]
use Google\Cloud\Spanner\SpannerClient;

/**
 * Create a database in spanner
 * Example:
 * ```
 * // create an empty database
 * insert_data($instanceId, $databaseId);
*
 * // create a database with tables
 * insert_data($instanceId, $databaseId, [
 *   "CREATE TABLE Singers (
 *       SingerId     INT64 NOT NULL,
 *       FirstName    STRING(1024),
 *       LastName     STRING(1024),
 *       SingerInfo   BYTES(MAX)
 *   ) PRIMARY KEY (SingerId)",
 *   "CREATE TABLE Albums (
 *       SingerId     INT64 NOT NULL,
 *       AlbumId      INT64 NOT NULL,
 *       AlbumTitle   STRING(MAX)
 *   ) PRIMARY KEY (SingerId, AlbumId),
 *   INTERLEAVE IN PARENT Singers ON DELETE CASCADE"
 * ]);
 * ```
 *
 * @param string $instanceId The Spanner instance ID.
 * @param string $databaseId The Spanner database ID.
 */
function insert_data($instanceId, $databaseId)
{
    $spanner = new SpannerClient();
    $instance = $spanner->instance($instanceId);

    if (!$instance->exists()) {
        throw new \LogicException("Instance $instanceId does not exist");
    }

    $operation = $instance->createDatabase($databaseId, [
        'statements' => $statements
    ]);

    print('Waiting for operation to complete...' . PHP_EOL);
    $operation->pollUntilComplete();

    printf('Created database %s on instance %s' . PHP_EOL,
        $databaseId, $instanceId);
}
# [END insert_data]
