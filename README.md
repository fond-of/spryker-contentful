# fond-of-spryker/contentful
[![PHP from Travis config](https://img.shields.io/travis/php-v/symfony/symfony.svg)](https://php.net/)
[![license](https://img.shields.io/github/license/mashape/apistatus.svg)](https://packagist.org/packages/fond-of-spryker/contentful)

A Spryker-Contentful connector. 
Import content from contentful to storage and updates it via cronjob.

## Install

```
composer require fond-of-spryker/contentful
```

### 1. Add twig service provider to YvesBootstrap.php in registerServiceProviders()
```
$this->application->register(new ContentfulTwigServiceProvider());
```

### 2. Add ContentfulRouter to YvesBootstrap.php in registerRouters()
```
$this->application->addRouter((new ContentfulRouter())->setSsl(false));
```

### 3. Add console command to ConsoleDependencyProvider.php in getConsoleCommands()
```
new ContentfulConsole(),
```

### 4. Add configs to your shop config file or in config/Shared/config_default.php 
Example configuration
```
// API-Key
$config[\FondOfSpryker\Shared\Contentful\ContentfulConstants::CONTENTFUL_ACCESS_TOKEN] = 'fu';
// Space id
$config[\FondOfSpryker\Shared\Contentful\ContentfulConstants::CONTENTFUL_SPACE_ID] = 'bar';
// Space default locale
$config[\FondOfSpryker\Shared\Contentful\ContentfulConstants::CONTENTFUL_DEFAULT_LOCALE] = 'en';
// Optional: To deactivate an entry. If Field doesn't exists entry is always shown. Default is "isActive"
$config[\FondOfSpryker\Shared\Contentful\ContentfulConstants::CONTENTFUL_FIELD_NAME_ACTIVE] = 'isActive';
// Optional: If entry is a page, this is the field where the url is stored. Default is "identifier"
$config[\FondOfSpryker\Shared\Contentful\ContentfulConstants::CONTENTFUL_FIELD_NAME_IDENTIFIER] = 'identifier';
// Mapping of contentful locales to available shop locales
$config[\FondOfSpryker\Shared\Contentful\ContentfulConstants::CONTENTFUL_LOCALE_TO_STORE_LOCALE] = [
    'en' => 'en_US',
    'de' => 'de_DE'
];
```

### 5. Add cronjob in jobs.php
Retrieve updated contentful entries every 5min.
```
$jobs[] = [
    'name' => 'contentful-updater',
    'command' => '$PHP_BIN vendor/bin/console contentful:import -vvv',
    'schedule' => '*/5 * * * *',
    'enable' => true,
    'run_on_non_production' => true,
    'stores' => $allStores,
];
```

### 6. Run
```
vendor/bin/console transfer:generate
vendor/bin/console contentful:import --all
```

# Console commands

Import last updated entries (last 5min)
```
vendor/bin/console contentful:import
```

Import all
```
vendor/bin/console contentful:import --all
```

Import entry by id
```
vendor/bin/console contentful:import [entryId]
```

# Usage in twig templates
Template path is Theme/default/contentful/[contentType].twig
```
 {{ contentfulEntry('contentfulEntryId') }}
```

Access contentful properties in twig templates like the following example:
```
 {{ entry.[fieldname].value }}
```

Markdown to html
```
 {{ entry.[markdownFieldName].value | Markdown }}
```

Image resize
```
{{ contentfulImage(entry.[assetFieldName].value, int width, int height) }}
```

# Fields

Text
```
{{ entry.[assetFieldName].type }} // 'Text'
{{ entry.[assetFieldName].value }} // Value
```

Boolean
```
{{ entry.[assetFieldName].type }} // 'Boolean'
{{ entry.[assetFieldName].value }} // Value
```

Asset
```
{{ entry.[assetFieldName].type }} // 'Asset'
{{ entry.[assetFieldName].value }} // Url of asset
{{ entry.[assetFieldName].title }}
{{ entry.[assetFieldName].description }}
```

Array
```
{{ entry.[assetFieldName].type }} // 'Array'
{{ entry.[assetFieldName].value }} // Array of fields
```

Reference
```
{{ entry.[assetFieldName].type }} // 'Reference'
{{ entry.[assetFieldName].value }} // ContentfulEntryId
```

# Pages
- If the contentful entry has a "Indentifier" field (URL) it will be imported as page with the given route via IdentifierImporterPlugin.
- Add an additional ResourceCreator to add custom logic to a special contentful entry type.
- More documentation soon