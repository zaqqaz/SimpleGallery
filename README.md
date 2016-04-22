SimpleGallery project
=====================

## What included

 - Configured PHP 5.6
 - Configured Apache 2.4
 - Symfony 2.8.*
 - Doctrine ORM 2.5
 - Enabled APCu cache for Doctrine and Validator (only in prod environment)
 - Gulp build toolchain (webpack, ES6 - babel)
 - Angular 1.5

## Required software

 - VirtualBox
 - [Vagrant](https://www.vagrantup.com/)
 - [vagrant-host-shell](https://github.com/phinze/vagrant-host-shell) for auto install galaxy roles
 - [Vagrant Host Manager](https://github.com/smdahlen/vagrant-hostmanager) for handling local DNS and DHCP instead of static IP
 - [Ansible](http://docs.ansible.com/intro_installation.html)

## Development

To prepare your local dev environment just run `vagrant up`. All actions to setup projects should be automated and ideally shouldn't require any manual actions. Project will be available at [simplegallery.vagrant](http://simplegallery.vagrant).

### Front-end
Just type `cd front` and then:
* `gulp` or `gulp build` to build an optimized CLIENT version of your application in `/dist`
* `gulp build --side admin` to build an optimized ADMIN version of your application in `/dist` -- not actual now
* `gulp serve` to launch a browser sync server on your CLIENT source files
* `gulp serve --side admin` to launch a browser sync server on your ADMIN source files -- not actual now

### Ansible verbocity level

If you want to debug your ansible provisioner, you can just run `vagrant provision --debug`. Also you can specify verbosity level via `VAGRANT_LOG` env variable (`info` or `debug`)

### XDebug

This project template provides simple remote debugging with xdebug. To use xdebug sessions verify that your IDE KEY is `PHPSTORM` and xdebug port is `9000`.