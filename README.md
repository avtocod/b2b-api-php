<p align="center">
  <img alt="logo" src="https://hsto.org/webt/59/df/45/59df45aa6c9cb971309988.png" width="70" height="70" />
</p>

# PHP client for B2B API service

[![Version][badge_packagist_version]][link_packagist]
[![PHP Version][badge_php_version]][link_packagist]
[![Build Status][badge_build_status]][link_build_status]
[![Coverage][badge_coverage]][link_coverage]
[![Downloads count][badge_downloads_count]][link_packagist]
[![License][badge_license]][link_license]

## Install

Require this package with composer using the following command:

```shell
$ composer require avtocod/b2b-api-php "^3.3"
```

> Installed `composer` is required ([how to install composer][getcomposer]).

> You need to fix the major version of package.

## Usage

Before using this package you must have:

- Service user login
- User password
- User domain name
- Report type name

> For getting this values contact with our B2B Sale Managers (`b2b@avtocod.ru`)

Now, let's create B2B API Client instance:

```php
<?php

use Avtocod\B2BApi\Client;
use Avtocod\B2BApi\Settings;
use Avtocod\B2BApi\Tokens\Auth\AuthToken;

$client = new Client(new Settings(AuthToken::generate('username', 'password', 'domain')));
```

And then we can make next operations _(each call will returns an object with server response data)_:

```php
<?php

use \Avtocod\B2BApi\Client;
use \Avtocod\B2BApi\Params\DevPingParams;
use \Avtocod\B2BApi\Params\DevTokenParams;
use \Avtocod\B2BApi\Params\UserParams;
use \Avtocod\B2BApi\Params\UserBalanceParams;
use \Avtocod\B2BApi\Params\UserReportTypesParams;
use \Avtocod\B2BApi\Params\UserReportsParams;
use \Avtocod\B2BApi\Params\UserReportParams;
use \Avtocod\B2BApi\Params\UserReportMakeParams;
use \Avtocod\B2BApi\Params\UserReportRefreshParams;

/** @var Client $client */

// Test connection
$client->devPing(new DevPingParams());

// Debug token generation
$client->devToken(new DevTokenParams('username', 'password'));

// Retrieve information about current user
$client->user((new UserParams)->setDetailed(true));

// Retrieve balance information for report type
$client->userBalance(new UserBalanceParams('report_type_uid@domain'));

// Retrieve report types data
$client->userReportTypes(new UserReportTypesParams);

// Get reports list
$client->userReports(new UserReportsParams);

// Get report by unique report ID
$client->userReport(new UserReportParams('report_uid_SOMEIDENTIFIERGOESHERE@domain'));

// Make (generate) report
$client->userReportMake(new UserReportMakeParams('report_type_uid@domain', 'VIN', 'Z94CB41AAGR323020'));

// Refresh existing report
$client->userReportRefresh(new UserReportRefreshParams('report_uid_SOMEIDENTIFIERGOESHERE@domain'));
```

For example, if you want to generate report for `A111AA177` (`GRZ` type), you can:

```php
<?php

use \Avtocod\B2BApi\Client;
use \Avtocod\B2BApi\Params\UserReportMakeParams;
use \Avtocod\B2BApi\Params\UserReportParams;

/** @var Client $client */

// Make report (this operation is asynchronous)
$report_uid = $client
    ->userReportMake(
        (new UserReportMakeParams(`some_report_uid`, 'GRZ', 'A111AA177'))
            ->setForce(true)
            ->setOnUpdateUrl('https://example.com/webhook/updated')
            ->setOnCompleteUrl('https://example.com/webhook/completed')
    )
    ->first()
    ->getReportUid();

// Wait for report is ready
while (true) {
    if ($client->userReport((new UserReportParams($report_uid))->setIncludeContent(false))->first()->isCompleted()) {
        break;
    }

    \sleep(1);
}

$content = $client->userReport(new UserReportParams($report_uid))->first()->getContent();

$vin_code  = $content->getByPath('identifiers.vehicle.vin');   // (string) 'JTMHX05J704083922'
$engine_kw = $content->getByPath('tech_data.engine.power.kw'); // (int) 227
```

### Testing

For package testing we use `phpunit` framework and `docker-ce` + `docker-compose` as develop environment. So, just write into your terminal after repository cloning:

```shell
$ make build
$ make latest # or 'make lowest'
$ make test
```

## Changes log

[![Release date][badge_release_date]][link_releases]
[![Commits since latest release][badge_commits_since_release]][link_commits]

Changes log can be [found here][link_changes_log].

## Support

[![Issues][badge_issues]][link_issues]
[![Issues][badge_pulls]][link_pulls]

If you will find any package errors, please, [make an issue][link_create_issue] in current repository.

## License

This is open-sourced software licensed under the [MIT License][link_license].

[badge_packagist_version]:https://img.shields.io/packagist/v/avtocod/b2b-api-php.svg?maxAge=180
[badge_php_version]:https://img.shields.io/packagist/php-v/avtocod/b2b-api-php.svg?longCache=true
[badge_build_status]:https://img.shields.io/github/workflow/status/avtocod/b2b-api-php/tests/master
[badge_coverage]:https://img.shields.io/codecov/c/github/avtocod/b2b-api-php/master.svg?maxAge=60
[badge_downloads_count]:https://img.shields.io/packagist/dt/avtocod/b2b-api-php.svg?maxAge=180
[badge_license]:https://img.shields.io/packagist/l/avtocod/b2b-api-php.svg?longCache=true
[badge_release_date]:https://img.shields.io/github/release-date/avtocod/b2b-api-php.svg?style=flat-square&maxAge=180
[badge_commits_since_release]:https://img.shields.io/github/commits-since/avtocod/b2b-api-php/latest.svg?style=flat-square&maxAge=180
[badge_issues]:https://img.shields.io/github/issues/avtocod/b2b-api-php.svg?style=flat-square&maxAge=180
[badge_pulls]:https://img.shields.io/github/issues-pr/avtocod/b2b-api-php.svg?style=flat-square&maxAge=180
[link_releases]:https://github.com/avtocod/b2b-api-php/releases
[link_packagist]:https://packagist.org/packages/avtocod/b2b-api-php
[link_build_status]:https://github.com/avtocod/b2b-api-php/actions
[link_coverage]:https://codecov.io/gh/avtocod/b2b-api-php/
[link_changes_log]:https://github.com/avtocod/b2b-api-php/blob/master/CHANGELOG.md
[link_issues]:https://github.com/avtocod/b2b-api-php/issues
[link_create_issue]:https://github.com/avtocod/b2b-api-php/issues/new/choose
[link_commits]:https://github.com/avtocod/b2b-api-php/commits
[link_pulls]:https://github.com/avtocod/b2b-api-php/pulls
[link_license]:https://github.com/avtocod/b2b-api-php/blob/master/LICENSE
[getcomposer]:https://getcomposer.org/download/
