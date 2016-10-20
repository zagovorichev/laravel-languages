<?php
/**
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * MIT Public License for more details.
 *
 * Copyright (c) 2016 (original work) Blog-Tree.com;
 *
 * @author A.Zagovorichev <zagovorichev@gmail.com>
 */

return [

    /*
     |-----------------------------------------------------------------
     | Default language
     |-----------------------------------------------------------------
     |
     | Will be used by default and for common pages
     | Also this language will be used if missed translation
     |
     | For example for site.com, www.site.com without cookies and sessions
     |
    */
    'default_language' => 'en',

    /*
     |---------------------------------------------------------------
     | List of the languages
     |---------------------------------------------------------------
     |
     | Will be displayed only languages from that list
     |
     */
    'languages' => ['en'],

    /*
     |-----------------------------------------------------------------
     | Language modes
     |-----------------------------------------------------------------
     |
     | By default language stored in the user session and in the browser's cookies
     | (but you can change that option)
     |
     | # session -> store in the $_SESSION
     | # cookie -> store in the browser $_COOKIES
     | # domain -> use domain name for determining current language (www.example.com, en.example.com, es.example.com...)
     | # path -> use uri for language example.com/en/address
     |
     */
    'modes' => [
        'session',
        'cookie',
        'domain',
        'path',
    ],

    /*
     |-----------------------------------------------------------------
     | Path Manager configuration
     |-----------------------------------------------------------------
     |
     | Use it if you want to use path for language detection
     | # example: http://www.example.com/en/post/234
     |
     */
     'pathRegExp' => '{\w+}\/.*',

    /*
     |-----------------------------------------------------------------
     | Domain Manager configuration
     |-----------------------------------------------------------------
     |
     | Use it if you want to use sub domain or different domain for language detection
     | # example: http://www.example.en/post/234 => http://en.example.com/post/234
     |
     */
    'domainRegExp' => 'http://{\w+}.example.com',

];
