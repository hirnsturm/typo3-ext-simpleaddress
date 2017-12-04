TYPO3 CMS Extension *simpleaddress*
===================================

## Table of contents
Inhalt
* [What does it do?](#what-does-it-do)
* [Supported languages](#supported-languages)
* [Dependencies](#dependencies)
* [Installation](#installation)
    * [TypoScript Setup](#TypoScript-Setup)
    * [TypoScript Constants](#TypoScript-Constants)
    * [RealURL Konfiguration](#RealURL)
* [Configuration](#configuration)
* [Plugins](#plugins)
* [Known problems](#known-problems)
* [To Do](#to-do)

## <a name="what-does-it-do"></a>What does it do?
This extension offers an simple way for displaying an address block with or without a Google Maps and the address location on it. The address will rendered in vCard format and the whole template is full responsive because it based on Twitter Bootstrap.

## <a name="supported-languages"></a>Supported languages
* English
* Deutsch

## <a name="dependencies"></a>Dependencies
* See composer.json

## <a name="installation"></a>Installation
1. Install extension with composer

    ```
    $ composer require sle/simpleaddress
    ```

2. Add TypoScript template to your website root template
3. Include JavaScript

    ```
    (function(win, $) {
       $.getScript('https://maps.googleapis.com/maps/api/js?v=3.exp&key=YOUR-API-KEY')
           .done(function() {
               win.SleSimpleaddress.initialize();
           });
    })(window, jQuery);
    ```

    ```
    page.includeJSFooter.file999 = EXT:simpleaddress/Resources/Public/js/simpleaddress.js
    ```

## <a name="configuration"></a>Configuration

* You can change the default map marker icon in `Templates\Address\Show.html` by adding following attribute

    ```html
    data-map-marker-icon="{f:uri.resource(extensionName: 'my_ext_key', path: 'Icons/my_marker_icon.png', absolute: 1)}"
    ```
    to

    ```html
    <div id="google-map-{cObjectData.uid}"
         class="ext-simpleaddess-map"
         data-config="{mapConfig}"
         data-map-marker-icon="{f:uri.resource(extensionName: 'my_ext_key', path: 'Icons/my_marker_icon.png', absolute: 1)}"
         style="height:400px;"></div>
    ```

## <a name="plugins"></a>Plugins

### <a name="plugins-address"></a>Address
* Displays the address block with or without a Google Maps

## <a name="known-problems"></a>Known problems
neither

## <a name="to-do"></a>To do
Feel free and add a issue, pull request or ask for a missing feature.
