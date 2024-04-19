<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, target-densityDpi=device-dpi" />
    <title>Chatting Application</title>
    <link rel="icon" type="image/png" href="/assets/images/favicon.png">
    <link rel="stylesheet" href="/assets/css/all.min.css">
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/slick.css">
    <link rel="stylesheet" href="/assets/css/venobox.min.css">
    <link rel="stylesheet" href="/assets/css/emojionearea.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">

    <link rel="stylesheet" href="/assets/css/spacing.css">
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/responsive.css">

</head>

<body>

    <!--==================================
        Chatting Application Start
    ===================================-->
        @yield('content')
    <!--==================================
        Chatting Application End
    ===================================-->


    <!--jquery library js-->
    <script src="/assets/js/jquery-3.7.1.min.js"></script>
    <!--bootstrap js-->
    <script src="/assets/js/bootstrap.bundle.min.js"></script>
    <!--font-awesome js-->
    <script src="/assets/js/Font-Awesome.js"></script>
    <script src="/assets/js/slick.min.js"></script>
    <script src="/assets/js/venobox.min.js"></script>
    <script src="/assets/js/emojionearea.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    <!--main/custom js-->
    <script src="/assets/js/main.js"></script>
    <script src="/assets/js/messenger.js"></script>
    <script>
        var notyf = new Notyf({
            duration: 5000,
        });
    </script>


    @stack('custom-scripts')


</body>

</html>
