# Coding standards
Some scripts to help developers use the same coding style. It adds the script `scripts\phpcs-check` to the
vendor/bin directory which can be called in several ways (also in pre-commit git hook).

## Installation
Add this repo to the list of repositories in your composer.json file:

```
"repositories": [
  {
    "type": "vcs",
    "url": "https://github.com/remko79/coding-standards.git"
  }
]
```

Then install it: `composer require --dev remko79/coding-standards`.

## Git hook
There is an option to install the pre-commit git hook to your project.
This will make sure that the modified files are checked before committing.
Add the following command to one of the post install/update hooks of composer.json:
```
"scripts": {
  "post-install-cmd": [
    "DrupalProject\\composer\\CodingStandards::setGitHooks"
  ]
}
```

## PHPCS
You can add your own phpcs configuration file to extend the default configuration.
The file will be automatically found if:
1. it exists in `<PROJECTDIR>/config` or `<PROJECTDIR>/scripts`
2. the filename ends with `_phpcs.xml`, for example `myproject_phpcs.xml`

Example file `myproject_phpcs.xml`:
```
<?xml version="1.0"?>
<ruleset name="My Coding Standards">
  <description>My coding standards</description>

  <exclude-pattern>/scripts/*</exclude-pattern>
  <exclude-pattern>*.css$</exclude-pattern>

  <!-- This is the rule we inherit from. If you want to exclude some specific rules, see the docs on how to do that -->
  <rule ref="../vendor/remko79/coding-standards/drupal_cs.xml"/>
</ruleset>
```

### Run the script
Running the phpcs script can be done by calling:
```
  ./vendor/bin/phpcs-check
```
The following parameters are supported:

    `diff`: runs the check on all (git) staged and non-staged files
    `staged`: runs the check on all stages files (used by pre-commit hook)
    `<none>`: runs the check on all files in `web/modules/custom`, `web/themes`, `behat`
    `--drupalpractice`: as first or second parameter to run with the default
       coding standard 'DrupalPractice'. This will _not_ use any custom ruleset.

A simple alias for changed files can be created in the scripts section of your composer.json:
```
  "phpcs": "./vendor/bin/phpcs-check diff"
```
This gives you the option to run the script using `composer run phpcs` for all changed files.
