/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */


$(function () {



    $('[data-video]').on('click', function (e) {
        var video = $(this).data("video");

        $("#preview").removeAttr('muted');
        $("#preview").attr('src', video);
        $("#preview").get(0).play();


    });


    // create the audio context (chrome only for now)
    // create the audio context (chrome only for now)
    if (!window.AudioContext) {
        if (!window.webkitAudioContext) {
            alert('no audiocontext found');
        }
        window.AudioContext = window.webkitAudioContext;
    }
    var context = new AudioContext();
    //

    //var analyser = context.createAnalyser();

    // sourceNode.connect(analyserNode);
    // analyserNode.connect(context.destination);
    //
    var audioBuffer;
    var sourceNode;
    var analyser;
    var javascriptNode;

    // get the context from the canvas to draw on
    var ctx = $("#canvas").get()[0].getContext("2d");

    // create a gradient for the fill. Note the strange
    // offset, since the gradient is calculated based on
    // the canvas, not the specific element we draw
    var gradient = ctx.createLinearGradient(0, 0, 0, 100);
    gradient.addColorStop(1, '#000000');
    gradient.addColorStop(0.75, '#ff0000');
    gradient.addColorStop(0.25, '#ffff00');
    gradient.addColorStop(0, '#ffffff');

    // load the sound
    setupAudioNodes();

    function setupAudioNodes() {

        // setup a javascript node
        javascriptNode = context.createScriptProcessor(2048, 1, 1);
        // connect to destination, else it isn't called
        javascriptNode.connect(context.destination);


        // setup a analyzer
        analyser = context.createAnalyser();
        analyser.smoothingTimeConstant = 0.3;
        analyser.fftSize = 512;

        // create a buffer source node
        sourceNode = context.createMediaElementSource(document.getElementById('preview'));
        sourceNode.connect(analyser);
        analyser.connect(javascriptNode);
        sourceNode.connect(context.destination);
    }

    // log if an error occurs
    function onError(e) {
        console.log(e);
    }

    // when the javascript node is called
    // we use information from the analyzer node
    // to draw the volume
    javascriptNode.onaudioprocess = function () {

        // get the average for the first channel
        var array = new Uint8Array(analyser.frequencyBinCount);
        analyser.getByteFrequencyData(array);

        // clear the current state
        ctx.clearRect(0, 0, 1000, 400);

        // set the fill style
        ctx.fillStyle = gradient;
        drawSpectrum(array);

    }


    function drawSpectrum(array) {
        for (var i = 0; i < (array.length); i++) {
            var value = array[i];

            ctx.fillRect(i * 5, 400 - value, 3, 400);
            //  console.log([i,value])
        }
    };

});