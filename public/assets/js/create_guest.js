const webcamElement = document.getElementById('webcam');
const canvasElement = document.getElementById('canvas');
const snapSoundElement = document.getElementById('snapSound');
const webcam = new Webcam(webcamElement, 'user', canvasElement, snapSoundElement);


function cameraStarted() {
    $("#webcam-caption").html("Camera On");
    $("#webcam-control").removeClass("webcam-off");
    $("#webcam-control").addClass("webcam-on");
    if (webcam.webcamList.length > 1) {
        $("#cameraFlip").removeClass('d-none');
    }
    window.scrollTo(0, 0);
    $('#webcam').removeClass('d-none');
    $('#take-photo').removeClass('d-none');
}

function cameraStopped() {
    $("#webcam-control").removeClass("webcam-on");
    $("#webcam-control").addClass("webcam-off");
    $("#cameraFlip").addClass('d-none');
    $("#webcam-caption").html("Camera Off");
    $('#webcam').addClass('d-none');
    $('#take-photo').addClass('d-none');
}

function init_webcam() {

    $("#take-photo").click(function() {
        let picture = webcam.snap();
        $('#download-photo').attr("src", picture);
        $('#foto').val(encodeURI(picture));
        $('#download-photo').removeClass('d-none');
        $("#webcam-switch").prop("checked", false).change();
        setTimeout(function() {
            $('.modal').modal('hide');
        }, 500);
    });

    $("#webcam-switch").change(function() {
        if (this.checked) {
            webcam.start()
                .then(result => {
                    cameraStarted();
                    console.log("webcam started");
                });
        } else {
            cameraStopped();
            webcam.stop();
            console.log("webcam stopped");
        }
    });

    $('#cameraFlip').click(function() {
        webcam.flip();
        webcam.start();
    });
}