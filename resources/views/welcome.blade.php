<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Leap Room</title>
    <link rel="stylesheet" href="{{ elixir('css/app.css') }}">
    <script src="{{ asset('js/three.js') }}"></script>
    <script src="{{ asset('js/OrbitControls.js') }}"></script>

    <script src="{{ asset('js/socket.io-1.4.5.js') }}"></script>
    <script src="{{ asset('js/echo.js') }}"></script>
    {{--<script src="//leap.dev:6001/socket.io/socket.io.js"></script>--}}
    <script src="{{ elixir('js/app.js') }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Fonts -->
</head>
<body>
<div class="container">
    <h1>press start</h1>
    <div class="row">

        <div class="col-md-12 btn-group">
            <button class="btn btn-success" id="record">
                Start
            </button>

            <button class="btn btn-danger" id="stop">
                Stop
            </button>
        </div>
    </div>
    <video class="thumbnail" muted id="preview" width="1000" height="400"></video>
    <canvas id="canvas" width="1000" height="400"></canvas>



    <div class="row" id="videos">
        @foreach(App\Video::latest()->get() as $video)
            <img class="col-md-2 col-sm-3 thumbnail animated bounceInLeft" data-video="{{$video->filename}}"
                 id={{$video->id}}-preview" src="/screenshots/{{$video->id}}.jpg"/>
        @endforeach
    </div>


    <script>
        // it currently focuses only chrome.
        function PostBlob(audioBlob, videoBlob, fileName) {
            var formData = new FormData();
            formData.append('filename', fileName);
            formData.append('audio-blob', audioBlob);
            formData.append('video-blob', videoBlob);
            xhr('/video/store', formData, function (video) {
                //document.querySelector('h1').innerHTML = ffmpeg_output.replace(/\\n/g, '<br />');
                //preview.src = 'uploads/' + fileName + '-merged.webm';
                //preview.play();
                $("h1").text("playback");
                $("#videos").prepend('<img class="col-md-2 thumbnail animated bounceInLeft" data-video="' + video.filename + '" id="' + video.id + '-preview" src="/screenshots/' + video.id + '.jpg"/>')
                //preview.muted = false;
                console.log(video.filename);
                preview.src = "/" + video.filename;
                preview.muted = false;
                preview.play();

            });
        }
        var record = document.getElementById('record');
        var stop = document.getElementById('stop');
        var audio = document.querySelector('audio');
        var recordVideo = document.getElementById('record-video');
        var preview = document.getElementById('preview');
        var container = document.getElementById('container');
        var recordAudio, recordVideo;
        var length = 2000;
        var display, tick;
        record.onclick = function () {
            record.disabled = true;
            !window.stream && navigator.getUserMedia({
                audio: true,
                video: true
            }, function (stream) {
                window.stream = stream;
                onstream();
            }, function (error) {
                alert(JSON.stringify(error, null, '\t'));
            });
            window.stream && onstream();
            function onstream() {
                preview.src = window.URL.createObjectURL(stream);
                preview.play();
                preview.muted = true;
                console.log(window.stream)
                console.log("got new scream ");

                var display = timer(true);


                recordAudio = RecordRTC(stream, {
                    // bufferSize: 16384,
                    onAudioProcessStarted: function () {

                        recordVideo.startRecording();

                    }
                });
                recordVideo = RecordRTC(stream, {
                    type: 'video'
                });
                recordAudio.startRecording();
                stop.disabled = false;
            }
        };
        var fileName;
        stop.onclick = function () {
            document.querySelector('h1').innerHTML = 'Getting Blobs...';
            record.disabled = false;
            stop.disabled = true;
            preview.src = '';
            preview.poster = '/images/ajax-loader.gif';
            fileName = Math.round(Math.random() * 99999999) + 99999999;

            recordAudio.stopRecording(function () {
                document.querySelector('h1').innerHTML = 'got audio-blob. Getting video-blob...';
                recordVideo.stopRecording(function () {
                    document.querySelector('h1').innerHTML = 'uploading to server...';
                    webcamnOff();
                    PostBlob(recordAudio.getBlob(), recordVideo.getBlob(), fileName);

                });
            });

        };

        function timer(newone) {

            if (newone == true) {
                tick = 0;

            } else {
                tick++;

            }

            display = length - (100 * tick);
            $("h1").text("stopping in " + display / 100 + " ");
            if (display > 0) {
                setTimeout(function () {
                    timer(false);
                }, 100);
            } else {
                console.log("finisshed");
                $("#stop").click();
            }

        }

        function webcamnOff() {
            //clearInterval(theDrawLoop);
            //ExtensionData.vidStatus = 'off';
            preview.pause();
            preview.src = "";
            window.stream.getTracks()[0].stop();
            window.stream.getTracks()[1].stop();
            window.stream = false;
            console.log("Vid off");
        }
        function xhr(url, data, callback) {
            var request = new XMLHttpRequest();
            request.onreadystatechange = function () {
                if (request.readyState == 4 && request.status == 200) {
                    callback(JSON.parse(request.responseText));
                }
            };
            request.open('POST', url);
            request.send(data);
        }
    </script>


    {{--<script>--}}
    {{--function captureUserMedia(mediaConstraints, successCallback, errorCallback) {--}}
    {{--navigator.mediaDevices.getUserMedia(mediaConstraints).then(successCallback).catch(errorCallback);--}}
    {{--}--}}

    {{--var videoElement = document.getElementById('webcamVideo');--}}
    {{--var downloadURL = document.getElementById('download-url');--}}

    {{--var startRecording = document.getElementById('start-recording');--}}
    {{--var stopRecording = document.getElementById('stop-recording');--}}

    {{--startRecording.onclick = function () {--}}
    {{--startRecording.disabled = true;--}}
    {{--stopRecording.disabled = false;--}}

    {{--captureUserMedia00(function (stream) {--}}
    {{--window.audioVideoRecorder = window.RecordRTC(stream, {--}}
    {{--type: 'video'--}}
    {{--});--}}
    {{--window.audioVideoRecorder.startRecording();--}}
    {{--});--}}
    {{--};--}}

    {{--stopRecording.onclick = function () {--}}
    {{--stopRecording.disabled = true;--}}
    {{--startRecording.disabled = false;--}}

    {{--window.audioVideoRecorder.stopRecording(function (url) {--}}
    {{--//downloadURL.innerHTML = '<a href="' + url + '" download="RecordRTC.webm" target="_blank">Save RecordRTC.webm to Disk!</a><hr>';--}}
    {{--videoElement.src = url;--}}
    {{--videoElement.muted = false;--}}
    {{--videoElement.play();--}}

    {{--uploadToServer(window.RecordRTC, function() {--}}
    {{--console.log("Uploading..");--}}

    {{--});--}}


    {{--videoElement.onended = function () {--}}
    {{--videoElement.pause();--}}

    {{--// dirty workaround for: "firefox seems unable to playback"--}}
    {{--videoElement.src = URL.createObjectURL(audioVideoRecorder.getBlob());--}}
    {{--};--}}
    {{--});--}}
    {{--};--}}


    {{--function uploadToServer(recordRTC, callback) {--}}
    {{--var blob = recordRTC instanceof Blob ? recordRTC : recordRTC.blob;--}}
    {{--var fileType = blob.type.split('/')[0] || 'audio';--}}
    {{--var fileName = (Math.random() * 1000).toString().replace('.', '');--}}

    {{--if (fileType === 'audio') {--}}
    {{--fileName += '.' + (!!navigator.mozGetUserMedia ? 'ogg' : 'wav');--}}
    {{--} else {--}}
    {{--fileName += '.webm';--}}
    {{--}--}}

    {{--// create FormData--}}
    {{--var formData = new FormData();--}}
    {{--formData.append(fileType + '-filename', fileName);--}}
    {{--formData.append(fileType + '-blob', blob);--}}

    {{--callback('Uploading ' + fileType + ' recording to server.');--}}

    {{--makeXMLHttpRequest('save.php', formData, function (progress) {--}}
    {{--if (progress !== 'upload-ended') {--}}
    {{--callback(progress);--}}
    {{--return;--}}
    {{--}--}}

    {{--var initialURL = location.href.replace(location.href.split('/').pop(), '') + 'uploads/';--}}

    {{--callback('ended', initialURL + fileName);--}}

    {{--// to make sure we can delete as soon as visitor leaves--}}
    {{--listOfFilesUploaded.push(initialURL + fileName);--}}
    {{--});--}}
    {{--}--}}
    {{--function captureUserMedia00(callback) {--}}
    {{--captureUserMedia({--}}
    {{--audio: true,--}}
    {{--video: true--}}
    {{--}, function (stream) {--}}
    {{--videoElement.src = URL.createObjectURL(stream);--}}
    {{--videoElement.muted = true;--}}
    {{--videoElement.controls = true;--}}
    {{--videoElement.play();--}}

    {{--callback(stream);--}}
    {{--}, function (error) {--}}
    {{--alert(JSON.stringify(error));--}}
    {{--});--}}
    {{--}--}}

    {{--</script>--}}


</div>
</div>
</div>
</body>
</html>
