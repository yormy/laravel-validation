<?php

return [

    // leave the extensions empty for all allowed extensions
    "upload" => [
        "mime_allowed" => [
            'image/jpeg' => [
                'jpg',
                'jpeg'
            ],
            'image/gif' => [],
            'image/png' => [],
            'image/bmp' => [],
            'application/pdf' => [],
        ],

        "max_file_size_kb" => 600000000,

        "inconsistent_extension" => true,

        "inconsistent_mime" => true,

        "inconsistent_mime_extension" => true,

        'content_blacklist' => [
            '<?php',
            'bzip2://',
            'expect://',
            'glob://',
            'phar://',
            'php://',
            'ogg://',
            'rar://',
            'ssh2://',
            'zip://',
            'zlib://',
        ],

        'exceptions' => [
            'NullByteFoundException',
            'SizeNotAllowedException',
            'MimeTypeNotAllowedException',
            'InconsistentMimeException',
            'ExtensionInconsistentException',
            'ExtensionInvalidException',
            'BlacklistedContentException'
        ],

    ]

];
