# Better child theme enqueue styles.

Why you should use this script:
The old style of creating stylesheets is to create one general style.css and then in the child theme your own style.css that will override parent theme styles. Then all styles are loaded on all pages of the website. If you want to to have top speed on mobile devices you have to load the least amount of styles on a given page. Why? Because CSS (JS too) have to be processed every time and low-tier mobiles with slower CPU it will take significant time, sometimes even 2-3 seconds more than on top-tier mobiles. The best practice is to have one style that has all styles that are general for all website like styles for header, footer, headers, body text an so on, and on templates and individual pages load styles that are related to a given template or page. My recommendation is not to load parent stylesheet, rather copy styles from parent style.css to child-theme style.css, filter it and remove parts that are not used on your type of website. An example would be if you have a blog and parent style.css contain CSS styles for Woocommerce, but you don't use Woocommerce, then just delete it. This way you can save easily 20% of its original size. 

Installation:
1. Create the child theme
2. Download files and add to the child theme folder
3. unpack files, a new folder 'custom-styles' will be created, delete .zip file
3. activate by adding to functions.php 

```require_once ( trailingslashit( get_theme_file_path() ) . 'custom-styles/custom-styles.php');```

This script will load individual CSS files for template, page or inlined in the page header.
Files that are loaded has to be in ```/child-theme/assets/css/```. If this folder is not created yet, this script will create it for you.

Example of use:

Let's say you have template 'woocommerce' then in order to load CSS file only for this template you have to have ```/child-theme/assets/css/template-woocommerce.css```. You can create it manually or when logged in, go to the page where this template was used and add query string ?css=template. Similar way you can create the CSS file for the page by using query string ```?css=page``` or inline by ```?css=inline```. Otherwise, you need to create for the page with WordPress ID=2 ```/child-theme/assets/css/page-2.css``` or inline ```/child-theme/assets/css/inline-2.css```.

For debugging purposes, I have included a debugging window. It will display the file path of files that been loaded or, if not present, would be loaded if they been present. To display this debugging window just add on a given page query string ```?css``` and you have to be logged in. An example would be ``` https://mywebsite.com/shop/?css```.

Then go and add your styles into created files.

The priority of loading styles are the following:

Template
Page
Inline

Enjoy!
