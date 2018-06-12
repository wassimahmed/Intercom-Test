# Intercom Assessment
## Preface
This code was submitted on 13-Jun-2018 by Waseem Ahmed for position of Software Engineer at Intercom.

I've chosen to complete this assessment with PHP as my programming language for being very comfortable at it.
Rest of the documentation would assume no PHP background and hence would explain certain things along the way.

## Objectives
We are required to process, filter and output certain data read from a file containing JSON formatted data.

Input file contains many lines, each line represents one customer record with `name`, `geo coordinates`, and `user-id`.
Need to find customers within **100km** of coordinate **53.339428, -6.257664**, sort by `user-id` (ascending).

It involves converting **degrees** to **radians**, and distance calculation is described in Wikipedia article (https://en.wikipedia.org/wiki/Great-circle_distance)

## Introduction

The initial version of the assessment is written as a CLI application since its quick and easy to get started. Aim is to solve the problem first and then enhance it; from proto-typing to final ship-ready product.

Package `Symfony/Console` (http://symfony.com/doc/current/components/console.html) was chosen to built standardize CLI application for output styling and command-line argument parsing.

Without further ado, let's get started.

## Getting Started
Productivity is everything for a developer.
To ease getting started, `Makefile` has been created for convenience.
Following instructions below.

### Get Composer
`Composer` (https://getcomposer.org/) is a defacto package manager for PHP.
First, let's download that to help install our dependencies.
Download composer using following command:

```shell
make get-composer
```

### Install Dependencies
Application dependencies are declared in `composer.json` file and for version lock-down, Composer uses `composer.lock` file.

Install application dependencies using following command:

```shell
make install
```

### Run
Run application with suitable defaults using following command:

```shell
make run
```

### Tests
Unit tests are written using `PHP-Unit` (https://phpunit.de/)
Run PHP-Unit for running application tests with following command:

```shell
make test
```

## Development

In-order to assist in setting-up development environment, following documentation should help.

### Install Dev Tools

#### PHP Coding Standards Fixer

Coding style of the application is based on industry standards (described here: https://www.php-fig.org/psr/). Helper package `PHP-CS-Fixer` (PHP Coding Standards fixer, available at: https://cs.sensiolabs.org/) assists in finding violations and fixing many automatically.

```shell
make get-cs-fixer
```

And to run it:

```shell
make build
```

## Future Improvements
* CLI arguments for:
  * file to parse (file-system or even URL),
  * JSON key to output,
  * Field for sort.
* Web version with basic Bootstrap, submits form with:
  * URL / file-upload, 
  * JSON key to output,
  * Field for sort.
* Dockerize application(s); first CLI, then Web
* Go-version, why not?