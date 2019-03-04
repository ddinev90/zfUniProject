# Zend university project application

## Introduction

This is a minimalistic application to show creation of an MVC application with Zend Framework

## Installation using Composer

To run the project, use the sql file in the data folder to create a new database. To start the application use 
"composer run --timeout 0 serve". You will be able to access it on localhost:8080

## Development mode

```bash
$ composer development-enable  # enable development mode
$ composer development-disable # disable development mode
$ composer development-status  # whether or not development mode is enabled
```

You may provide development-only modules and bootstrap-level configuration in
`config/development.config.php.dist`, and development-only application
configuration in `config/autoload/development.local.php.dist`. Enabling
development mode will copy these files to versions removing the `.dist` suffix,
while disabling development mode will remove those copies.

Development mode is automatically enabled as part of the skeleton installation process. 
After making changes to one of the above-mentioned `.dist` configuration files you will
either need to disable then enable development mode for the changes to take effect,
or manually make matching updates to the `.dist`-less copies of those files.
