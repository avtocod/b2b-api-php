# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog][keepachangelog] and this project adheres to [Semantic Versioning][semver].

## v3.3.1

### Fixed

- Default value for parameter `data` in `::userReportMake` (`ClientInterface` and `Client`) set to `null`

## v3.3.0

### Added

- Additional (optional) parameter `data` for `::userReportMake` in `ClientInterface` and `Client` [#8]

[#8]:https://github.com/avtocod/b2b-api-php/pull/8

## v3.2.1

### Added

- Tests running using GitHub Actions
- `phpstan` configuration file with disabled `checkGenericClassInNonGenericObjectType` and `checkMissingIterableValueType`
- PHP 7.4 tests using CI

### Changed

- StyleCI rules. Enabled: `length_ordered_imports`, disabled: `alpha_ordered_imports`
- Updated dev-dependency versions
- Anonymous functions now static (where this is possible)

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
