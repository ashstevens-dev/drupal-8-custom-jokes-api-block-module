# drupal-8-custom-jokes-api-block-module
Drupal 8 Custom Module which creates a block that pulls in and displays data from the Jokes API. The block allows you to control how many jokes you would like to display.

## Installation
Create a ``custom`` directory in the ``modules`` directory for your Drupal 8 website if you don't have one already. Place this ``jokes_api`` directory inside. Enable the module like you would any other module (it will show under ``Custom`` in the list on the modules page (Extend)).

## Configuration
Place the block in the region you'd like it to show - it will be called ``Jokes API block`` in the list. In the Output Limit field, type in how many jokes you would like to display in the block.

## :sparkles: Moving on
This is an example to show how you can create a simple custom module in Drupal 8 and how you can integrate an API's fetched data inside of a block. It can be easily expanded on and modified for other applications.
