<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <script async src="https://unpkg.com/@material-tailwind/html@latest/scripts/ripple.js"></script>
</head>

<body class="text-white bg-dark">
    <nav class="flex items-center justify-between px-6 py-4">
        <img class="w-10 shadow-lg" src="{{ asset('logo.png') }}" alt="logo">
    </nav>
    <div class="container mx-auto">
        <div class="grid min-h-[140px] w-full place-items-center overflow-x-scroll rounded-lg p-6 lg:overflow-visible">
            <div class="mb-8">
                <h3 class="text-xl tracking-wide">BMW GSF800 2009 </h3>
            </div>
            <img class="object-cover object-center w-full rounded-lg h-96"
                src="https://scontent-sin6-4.xx.fbcdn.net/v/t39.30808-6/403599051_1414505246116587_8149516749010567783_n.jpg?stp=cp6_dst-jpg&_nc_cat=103&ccb=1-7&_nc_sid=dd5e9f&_nc_ohc=K1-W5_pjnQ0AX-aYXG1&_nc_ht=scontent-sin6-4.xx&oh=00_AfAgoDiSluPpEHRsaTaIgBu4RWI8iOVLGVcY7Wa7m9_RGA&oe=656E7220"
                alt="nature image" />

            <a class="text-lg text-white"
                href="https://www.messenger.com/closeWindow/?image_url=https://yataicheng.info/storage/abc.jpeg&display_text=Closed">Close
                This</a>
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

        window.extAsyncInit = function() {
            alert('done loading');
            // the Messenger Extensions JS SDK is done loading 
        };
    </script>

</body>

</html>
