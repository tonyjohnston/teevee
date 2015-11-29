# teevee for WP

Teevee for WP is a WordPress plugin that acts as a bridge between WordPress and a custom Apple TV TVML app. 

In wp-admin, the plugin allows content creators to attach video meta data to a WordPress post. The plugin uses this meta data to provide end-points for Apple's TVML XML. 

The plugins creates a `menuBarTemplate` with a list with `menuItems` for each TV series, with a "Latest" items displaying most recent show. Episodes are displayed in a TVML `listTemplate`.

Check out the [https://developer.apple.com/library/tvos/documentation/LanguagesUtilities/Conceptual/ATV_Template_Guide/TextboxTemplate.html#//apple_ref/doc/uid/TP40015064-CH2-SW8](Apple TV Markup Language reference) for more info.