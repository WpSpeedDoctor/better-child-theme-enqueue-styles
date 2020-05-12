# better-child-theme-enqueue-styles

1. Create the child theme
2. Download file and add to child theme folder
3. activate by adding to functions.php 

include ( trailingslashit( get_theme_file_path() ) . 'enqueue-styles.php'); 

4. create folders in the child theme if don't exist assets/css/
5. If child theme is using parent theme CSS, copy it manually into child theme e.g. /child-theme/style.css
6. Disable parent theme CSS
7. Enqueue child theme main CSS
6. Add template CSS files
7. Add page ID files or inlined


