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
     | For example for site.com, www.site.com
     |
    */
    'default_language' => 'en',

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
     |
     */
    'modes' => [
        'session',
        'cookie',
        'domain'
    ]
];
