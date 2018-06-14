# Intercom Assessment
## Preface
This code was submitted on 14-Jun-2018 by Waseem Ahmed for position of Software Engineer at Intercom.

I've chosen to work on this assessment with PHP as my programming language.
Rest of the documentation would assume no PHP background and hence would explain certain things along the way.

## Objectives
We are required to process, filter and output certain data read from a file containing JSON formatted data.

Input file contains many lines, each line represents one customer record with `name`, `geo coordinates`, and `user-id`.
Need to find customers within **100km** of coordinate **53.339428, -6.257664**, sort by `user-id` (ascending).

It involves converting **degrees** to **radians**, and distance calculation is described in Wikipedia article (https://en.wikipedia.org/wiki/Great-circle_distance)

## Introduction

Assessment was solved with iterative development approach where first prototype was created (see git tag `'problem-solved'`) and then progressively built into CLI application with unit-tests and Docker support.

Developer productivity is paramount importance.
To save muscle memory and keystrokes, `Makefile` was added for convenience.

## Usage

Easiest way to run this code is using Docker.

### Docker

1. First you need to build Docker image to run. Run following command on your terminal:
    ```shell
    make docker-build
    ```
2. Once image is built successfully, you may launch Docker container as following:
    ```shell
    make docker-run
    ```

### Manual

If you prefer, you may manually run commands to suite yourself.

#### Setup

You may need to install `PHP` interpreter on your machine based on your Linux operating system.

For `Ubuntu`, you may find this page helpful: https://tecadmin.net/install-php-7-on-ubuntu/.
For latest `Debian`, this page has instructions to install PHP: https://tecadmin.net/install-php7-on-debian/

For `Ubuntu`, run following command from your terminal to install other required packages:

```shell
make setup
```

#### The Solution

See the solution per requirements, run following command in your terminal where you have cloned this repository:

```
make run
```

#### Tests

To run tests, you need install additional packages (once).

```shell
make dev-setup #only once
make test
```

#### Customize

Want to evaluate different input file? Use `--file=` option as:

```shell
make run ARGS="-- --file='/file/path.txt'"
```

Or, interested in sort by `name` rather by ID (default)? Use `--sort=` option with value either `name` or `user_id`, as:

```shell
make run ARGS="-- --sort=name"
```

Or, may be sort descending? Use `--order=` option with value either `a` for ascending, or `d` for descending, as:

```shell
make run ARGS="-- --order=d"
```

Or, use error prune but simpler formula for geo-coordinates distance calculation with option `--basic`, as:

```shell
make run ARGS="-- --basic"
```

lastly, feel free to combine multiple options, as:

```shell
make run ARGS="-- --sort=name --order=d --basic"
```

## Solution Brief

Package `Symfony/Console` (http://symfony.com/doc/current/components/console.html) was chosen to built this CLI application which offers simplistic output styling and command-line argument parsing features.

`Composer` (https://getcomposer.org/) is a defacto package manager for PHP.
Application dependencies are declared in `composer.json` file and for version lock-down, Composer uses `composer.lock` file.

`PHPUnit` (https://phpunit.de/) is used for unit-tests placed under `tests` directory. On every run of ```make test```, code coverage report is written out on stdout as well as saved in `assets/code-coverage-report.txt` file for later reference.

Coding style of the application is based on industry standards (described here: https://www.php-fig.org/psr/). Helper package `PHP-CS-Fixer` (PHP Coding Standards fixer, available at: https://cs.sensiolabs.org/) assists in finding violations and fixing most of those automatically.

## Project Structure

| Directory | Comment |
|-----------|---------|
| `asset` | Contains project assets. File `customers.txt` contains sample data provided in email. While, file `code-coverage-report.txt` offers code coverage details captured during unit-testing code. |
| `src \ Command` | `Symfony\Console` component is an implementation of [Command Pattern](https://en.wikipedia.org/wiki/Command_pattern) and this directory contains commands available in an application. For this assessment, there is only one command i.e. `Run` command |
| `src \ Library` | Re-usable pieces of code are placed in here |
| `src \ Service` | Classes housing business logics are placed in here |
| `tests` | Directory contains `PHPUnit` unit-tests to cover all business logic |
| `vendor` | Contains dependent packages. Only available after `Composer` was executed successfully. |

## Future Improvements
* Use `Symfony Dependency Injection` (a.k.a Service-Container, https://symfony.com/doc/current/components/dependency_injection.html) to instantiate services and dependencies.
* Web version with basic Bootstrap, submits form with:
  * URL / file-upload, 
  * JSON key to output,
  * Field for sort.
* Go-version, why not?