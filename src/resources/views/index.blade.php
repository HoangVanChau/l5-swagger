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

            .btn.btn-secondary.theme-btn {
              width: 60px;
              height: 60px;
              display: flex;
              align-items: center;
              justify-content: center;
              border-radius: 50%;
              background: #4CAF50;
              color: white;
              border: none;
              box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2);
              cursor: pointer;
              transition: background 0.3s ease, box-shadow 0.3s ease;
              z-index: 999;
              position: fixed;
              top: 70px;
              right: 10px;
            }

            .btn.btn-secondary.theme-btn img {
              width: 24px;
              height: 24px;
              pointer-events: none;
            }

            .btn.btn-secondary.theme-btn:hover {
              background: #45a049;
              box-shadow: 0px 6px 8px rgba(0, 0, 0, 0.3);
            }
        </style>
    </head>

    <body>
        <a type="button" href="{{ route('l5-swagger.download') }}" class="btn btn-secondary theme-btn">
            <img src="https://img.icons8.com/ios/50/000000/download.png" alt="download"/>
        </a>
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
