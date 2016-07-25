# Jarosh-Css-Media-Queries-Watcher

Media queries are an essential part of responsive web design, not the most obvious part however.
Have you ever been wondering what resolution your 400dpi phone screen has from browser perspective? Did you know that 'portrait' mode is not a prerogative of exclusively vertically rotated tablet devices and most desktop browsers will switch to 'portrait' as soon as a height of a viewport is getting larger than its width while resizing a window? Do you have any idea what's the difference between just 'width' and 'device-width' on a specific target device? Or maybe you're curious whether page scaling will affect dimensions, those seen by CSS.

This tiny CSS-based solution was invented to satisfy curiosity and give all the answers.

You may either use the Css Media Queries Watcher in order to integrate small HTML block with an actual media query information directly into page(s) of your website for a time of development or just use the Demo.html page for investigational purposes.

You're also free to chose whether to use one of the preset *.css files, or use PHP script that may be used to generate custom CSS for inclusion, or even include the script instead of *.css file on hosts wherever PHP code could be executed, e.g.:

    <link type="text/css" rel="stylesheet" href="jarosh-css-media-queries-watcher.php?minify=1" />

Generator may be used as both the script executed by the webserver sending its output through the HTTP and as a command line tool. For both cases it may accept following optional parameters:

 - **minify** - specifies whether  output must be minified or not; should take value of 1 to enable minification when passed as a part of a query string; shouldn't take any value when used as a command line option, the presence of --minify option itself is just enough  in order to enable minification.
 - **cclass** - outermost class name of an HTML block;  the default value is *JaroshCssMediaQueriesWatcher*
 - **prefix** - prefix of classes of internal informational blocks; empty by default;

Usage:

    <link type="text/css" rel="stylesheet" href="jarosh-css-media-queries-watcher.php?minify=1&cclass=SomeDummyClassName&prefix=css-" />

the same as a command

    php jarosh-css-media-queries-watcher.php --minify --cclass=SomeDummyClassName --prefix=css-media-

Both will generate CSS code that will expect following (approximately) HTML to work properly:

    <ul class="SomeDummyClassName">
        <li>
            <b>Device Type:</b>
            <span class="css-media-type">;</span>
        </li>
        <li>
            <b>Orientation:</b>
            <span class="css-media-orientation">;</span>
        </li>
        <li>
            <b>Resolution</b>
            <span class="css-media-resolution">dpi;</span>
        </li>
        <li>
            <b>Width</b>
            <span class="css-media-width">px;</span>
        </li>
        <li>
            <b>Height</b>
            <span class="css-media-height">px;</span>
        </li>
        <li>
            <b>Device Width</b>
            <span class="css-media-device-width">px;</span>
        </li>
        <li>
            <b>Device Height</b>
            <span class="css-media-device-height">px;</span>
        </li>
    </ul>

