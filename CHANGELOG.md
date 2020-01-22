# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog][keepachangelog] and this project adheres to [Semantic Versioning][semver].

## v3.2.1

### Added

- Tests running using GitHub Actions
- `phpstan` configuration file with disabled `checkGenericClassInNonGenericObjectType` and `checkMissingIterableValueType`

### Changed

- StyleCI rules. Enabled: `length_ordered_imports`, disabled: `alpha_ordered_imports`
- Updated dev-dependency versions
- Anonymous functions now static (where this is possible)
- `BadResponseException::wrongJson` now returns `self` instead `static`
- `TokenParserException::cannotParseToken` now returns `self` instead `static`
- Method `::fromHttpResponse` in all response classes now returns `self` instead `static`
- Method `::fromArray` in all entity classes now returns `self` instead `static`

## v3.2.0

### Added

- Interface `WithRawResponseGetterInterface`
- Each `\Avtocod\B2BApi\Responses\*Response` class now implements `WithRawResponseGetterInterface`

## v3.1.0

### Added

- Interface `WithSettingsInterface`
- Interface `WithEventsHandlerSetterInterface`

### Changed

- Class `Client` now implements `WithSettingsInterface` and `WithEventsHandlerSetterInterface`

## v3.0.0

### Changed

- Package totally rewritten _(previous versions [available here][previous_package])_

[previous_package]:https://github.com/avto-dev/b2b-api-php
[keepachangelog]:https://keepachangelog.com/en/1.0.0/
[semver]:https://semver.org/spec/v2.0.0.html
