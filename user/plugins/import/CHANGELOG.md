# v1.1.0
## 11/05/2016

1. [](#new)
    * Now supports JSON importing
    * Can load data from `user/data` folder now as well
2. [](#bugfix)
    * Thanks to @onionradish for fixing a typo that impacted loading single files.

# v1.0.0
## 01/28/2016

1. [](#new)
    * Initial release of the Import Plugin (Yay!)
1. [](#improved)
    * Changed from `onPageContentRaw` event hook, to `onPageInitialized` event hook to run even if the page is cached
