<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    @vite('resources/css/app.css')
    <title>My Awesome Webview</title>
    <script async src="https://unpkg.com/@material-tailwind/html@latest/scripts/ripple.js"></script>
</head>

<body class="text-white bg-dark">
    <div class="container mx-auto">
        <div class="grid min-h-[140px] w-full place-items-center overflow-x-scroll rounded-lg p-6 lg:overflow-visible">
            <div class="mb-8">
                <h3 class="text-xl tracking-wide">BMW GSF800 2009 </h3>
            </div>
            <img class="object-cover object-center w-full rounded-lg h-96"
                src="https://scontent-sin6-4.xx.fbcdn.net/v/t39.30808-6/403599051_1414505246116587_8149516749010567783_n.jpg?stp=cp6_dst-jpg&_nc_cat=103&ccb=1-7&_nc_sid=dd5e9f&_nc_ohc=K1-W5_pjnQ0AX-aYXG1&_nc_ht=scontent-sin6-4.xx&oh=00_AfAgoDiSluPpEHRsaTaIgBu4RWI8iOVLGVcY7Wa7m9_RGA&oe=656E7220"
                alt="nature image" />


        </div>

    </div>


    <script>
        (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {
                return;
            }
            js = d.createElement(s);
            js.id = id;
            js.src = "//connect.facebook.net/en_US/messenger.Extensions.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'Messenger'));

        window.extAsyncInit = function() {};
    </script>

</body>

</html>
