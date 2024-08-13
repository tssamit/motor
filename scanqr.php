<!DOCTYPE html>
<html>
    <head>
        <title>QR Code Scanner</title>
        <script type="text/javascript" src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
    </head>
    <body>
        <video id="preview" style="width:100%; height: auto;"></video>
        <script type="text/javascript">
            let scanner = new Instascan.Scanner({video: document.getElementById('preview')});

            scanner.addListener('scan', function (content) {
                // Handle the scanned content as needed
                //  alert('Scanned: ' + content);
                var url = content;
                window.location.replace(content);
                // You can redirect the user to the appropriate URL or handle the content as required.
            });

            Instascan.Camera.getCameras().then(function (cameras) {
                if (cameras.length > 0) {
                    scanner.start(cameras[0]);
                } else {
                    console.error('No cameras found.');
                }
            }).catch(function (e) {
                console.error(e);
            });
        </script>
    </body>
</html>