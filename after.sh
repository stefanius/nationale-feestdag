#!/usr/bin/env bash

#Install Dutch locales
sudo locale-gen nl_NL
sudo locale-gen nl_NL.utf8


sudo locale-gen ru_RU
sudo locale-gen ru_RU.UTF-8

sudo update-locale
sudo apt-get install language-pack-nl
sudo service php7.0-fpm restart

#Install ZSH
sudo apt-get -y install zsh
touch ~/.zshrc

#composer install
cd /home/vagrant/nationale-feestdag && composer install --no-scripts
