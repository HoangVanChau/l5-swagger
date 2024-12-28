<!-- HTML for static distribution bundle build -->
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>{{ config('swagger.title') }}</title>
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700|Source+Code+Pro:300,600|Titillium+Web:400,600,700" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/swagger-ui/5.18.2/swagger-ui.css">
        <style>
            html
            {
                box-sizing: border-box;
                overflow: -moz-scrollbars-vertical;
                overflow-y: scroll;
            }

            *,
            *:before,
            *:after
            {
                box-sizing: inherit;
            }

            body
            {
                margin:0;
                background: #fafafa;
            }
        </style>
    </head>

    <body>
        <div id="swagger-ui"></div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/swagger-ui/5.18.2/swagger-ui-bundle.js" crossorigin="anonymous" charset="UTF-8"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/swagger-ui/5.18.2/swagger-ui-standalone-preset.js" crossorigin="anonymous" charset="UTF-8"></script>

        <script type="text/javascript">
            window.onload = function() {
                const ui = SwaggerUIBundle({
                    url: "{!! $urlToDocs !!}",
                    dom_id: '#swagger-ui',
                    presets: [
                        SwaggerUIBundle.presets.apis,
                        SwaggerUIStandalonePreset
                    ],
                    plugins: [
                        SwaggerUIBundle.plugins.DownloadUrl
                    ],
                    layout: "StandaloneLayout",
                    filter: true,
                    deepLinking: true,
                    displayRequestDuration: true,
                    showExtensions: true,
                    showCommonExtensions: true,
                    queryConfigEnabled: true,
                    persistAuthorization: true,
                    // "list", "full", "none"
                    docExpansion: "{{ request()->get('expansion', 'list') }}"
                });

                window.ui = ui;
            }
        </script>
    </body>
</html>
