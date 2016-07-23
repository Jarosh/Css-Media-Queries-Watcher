# Jarosh-Css-Media-Queries-Watcher

Media queries are an essential part of responsive web design, not the most obvious part however.
Have you ever been wondering what resolution your 400dpi phone screen has from browser perspective? Did you know that 'portrait' mode is not a prerogative of exclusively vertically rotated tablet devices and most desktop browsers will pass into 'portrait' as soon as a height of a viewport is getting larger than its width while resizing a window? Do you have any idea what's the difference between just 'width' and 'device-width' on a specific target device?

This tiny CSS-based solution was invented to satisfy curiosity and give all the answers.

Just use the Jarosh Media Query Watcher in order to integrate small HTML block with an actual media query information directly into page(s) of your website for a time of development.

You're free to chose whether to use one of the preset files, or use PHP script that may be used to generate custom CSS for inclusion, or even include the script instead of *.css file on hosts wherever PHP code could be executed, e.g.:
<link type="text/css" rel="stylesheet" href="JaroshMediaQueryWatcher.php?minify=1" />
