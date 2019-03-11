<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Error</title>
    <base href="{{ asset('') }}">
    <link rel="stylesheet" href="css/404.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/blue/pace-theme-minimal.min.css">
</head>
<body>
    <div class="wrapper row2">
        <div id="container" class="clear">
            <section id="fof" class="clear">
                <h1>WHOOPS!</h1>
                <h2>Unnkown error! Please contact admin</h2>
            </section>
        </div>
    </div>
    <script
  src="https://code.jquery.com/jquery-3.2.1.min.js"
  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
  crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js"></script>
    <script>
        paceOptions = {
                catchupTime : 10000,
                maxProgressPerFrame:1,
                ghostTime: Number.MAX_SAFE_INTEGER,
                checkInterval :{
                    checkInterval: 10000
                },
                eventLag : {
                    minSamples: 1,
                    sampleCount: 50000,
                    lagThreshold: 0.1
                }
            }
        $(document).ready(function () {
                window.setTimeout(function(){

                // Move to a new location or you can do something else

                window.location.href = "http://corenksnews.dev/admin";

            }, 5000)

        });
    </script>
</body>
</html>