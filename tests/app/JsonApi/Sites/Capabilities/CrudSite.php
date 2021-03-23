<?php
/*
 * Copyright 2021 Cloud Creativity Limited
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

declare(strict_types=1);

namespace App\JsonApi\Sites\Capabilities;

use App\Entities\Site;
use App\Entities\SiteStorage;
use LaravelJsonApi\NonEloquent\Capabilities\Crud;

class CrudSite extends Crud
{

    /**
     * @var SiteStorage
     */
    private SiteStorage $storage;

    /**
     * CrudSite constructor.
     *
     * @param SiteStorage $storage
     */
    public function __construct(SiteStorage $storage)
    {
        $this->storage = $storage;
    }

    /**
     * Create a new site.
     *
     * @param array $validatedData
     * @return Site
     */
    public function create(array $validatedData): Site
    {
        $site = new Site($validatedData['slug']);
        $site->setDomain($validatedData['domain'] ?? null);
        $site->setName($validatedData['name'] ?? null);

        $this->storage->store($site);

        return $site;
    }

    /**
     * Update the provided site.
     *
     * @param Site $site
     * @param array $validatedData
     * @return void
     */
    public function update(Site $site, array $validatedData): void
    {
        if (array_key_exists('domain', $validatedData)) {
            $site->setDomain($validatedData['domain']);
        }

        if (array_key_exists('name', $validatedData)) {
            $site->setName($validatedData['name']);
        }

        $this->storage->store($site);
    }

    /**
     * Delete the site.
     *
     * @param Site $site
     * @return void
     */
    public function delete(Site $site): void
    {
        $this->storage->remove($site);
    }
}
