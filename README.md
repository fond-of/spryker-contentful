# fond-of-spryker/contentful
[![PHP from Travis config](https://img.shields.io/travis/php-v/symfony/symfony.svg)](https://php.net/)
[![license](https://img.shields.io/github/license/mashape/apistatus.svg)](https://packagist.org/packages/fond-of-spryker/contentful)



## Installation

```
composer require fond-of-spryker/contentful
```

### 1. Add twig service provider to YvesBootstrap.php in registerServiceProviders()
```
$this->application->register(new ContentfulTwigServiceProvider());
```

### 2. Add console command to ConsoleDependencyProvider.php in getConsoleCommands()
```
new ContentfulConsole()
```

### 3. Add configs to your shop config file or in config/Shared/config_default.php 
```
// Contentful configuration
//
// access token/api key
$config[\FondOfSpryker\Shared\Contentful\ContentfulConstants::CONTENTFUL_ACCESS_TOKEN] = '';
//
// Space id
$config[\FondOfSpryker\Shared\Contentful\ContentfulConstants::CONTENTFUL_SPACE_ID] = '';
//
// Space default locale
$config[\FondOfSpryker\Shared\Contentful\ContentfulConstants::CONTENTFUL_DEFAULT_LOCALE] = 'en';
//
// Mapping of contentful locales to available shop locales
$config[\FondOfSpryker\Shared\Contentful\ContentfulConstants::CONTENTFUL_LOCALE_TO_STORE_LOCALE] = [
    'en' => 'en_US',
    'de' => 'de_DE'
];
```

### 4. Add cronjob in jobs.php
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

### 5. Run
```
vendor/bin/console transfer:generate
vendor/bin/console contentful:import
```

# Commands

Import last updated entries (last 5min)
```
vendor/bin/console contentful:import
```

Import all
```
vendor/bin/console contentful:import --all
```

Import entry
```
vendor/bin/console contentful:import [entryId]
```

# Pages
If the contentful entry has a "Indentifier" field (URL) it will be imported as page with the given route.
Add an additional ResourceCreator to add custom logic to a special contentful entry type.

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
{{ contentfulImage(entry.[assetFieldName].value, width, height) }}
```

# Fields

Default
```
{{ entry.[assetFieldName].type }} // Possible Values: 'Boolean', 'Text'
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