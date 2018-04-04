<?php

namespace FondOfSpryker\Zed\Contentful\Business\Model;

use Contentful\Delivery\Client;
use Contentful\Delivery\Query;
use Contentful\ResourceArray;
use DateTime;

/**
 * @author mnoerenberg
 */
class ContentfulImporter implements ContentfulImporterInterface
{
    /**
     * @var \FondOfSpryker\Zed\Contentful\Business\Model\ContentfulMapperInterface
     */
    protected $contentfulMapper;

    /**
     * @var string[]
     */
    protected $localeMapping;

    /**
     * @var \FondOfSpryker\Zed\Contentful\Communication\Plugin\ContentfulImporterPluginInterface[]
     */
    protected $plugins;

    /**
     * @var \Contentful\Delivery\Client
     */
    protected $client;

    /**
     * @param \Contentful\Delivery\Client $client
     * @param \FondOfSpryker\Zed\Contentful\Business\Model\ContentfulMapperInterface $contentfulMapper
     * @param \FondOfSpryker\Zed\Contentful\Communication\Plugin\ContentfulImporterPluginInterface[] $plugins
     * @param string[] $localeMapping
     */
    public function __construct(Client $client, ContentfulMapperInterface $contentfulMapper, array $plugins, array $localeMapping)
    {
        $this->client = $client;
        $this->contentfulMapper = $contentfulMapper;
        $this->plugins = $plugins;
        $this->localeMapping = $localeMapping;
    }

    /**
     * @author mnoerenberg
     *
     * @inheritdoc
     */
    public function importLastChangedEntries(): int
    {
        $query = new Query();
        $query->where('sys.updatedAt', (new DateTime())->modify('-5 minutes'), 'gte');
        $query->setLimit(1000);
        $query->setLocale('*');

        return $this->import($this->client->getEntries($query));
    }

    /**
     * @author mnoerenberg
     *
     * @inheritdoc
     */
    public function importAllEntries(): int
    {
        $query = new Query();
        $query->where('sys.createdAt', new DateTime('2010-01-01 00:00:00'), 'gte');
        $query->setLimit(1000);
        $query->setLocale('*');

        return $this->import($this->client->getEntries($query));
    }

    /**
     * @author mnoerenberg
     *
     * @inheritdoc
     */
    public function importEntry($entryId): int
    {
        $query = new Query();
        $query->where('sys.id', $entryId, 'match');
        $query->setLimit(10);
        $query->setLocale('*');

        return $this->import($this->client->getEntries($query));
    }

    /**
     * @author mnoerenberg
     *
     * @param \Contentful\ResourceArray $entries
     *
     * @return int
     */
    private function import(ResourceArray $entries): int
    {
        foreach ($entries as $dynamicEntry) {
            foreach ($this->localeMapping as $contentfulLocale => $locale) {
                /** @var \Contentful\Delivery\DynamicEntry $dynamicEntry */

                $dynamicEntry->setLocale($contentfulLocale);
                $entryArray = $this->contentfulMapper->from($dynamicEntry);

                foreach ($this->plugins as $plugin) {
                    $plugin->handle($dynamicEntry, $entryArray, $locale);
                }
            }
        }

        return count($entries);
    }
}
