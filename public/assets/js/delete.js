function delete_record(action) {
    if (action) {


        Swal.fire({
            icon: 'question',
            title: 'Hapus data ini?',
            showDenyButton: false,
            showCancelButton: true,
            confirmButtonText: 'Yes'
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {

                // Ajax config
                $.ajax({
                    type: "POST", //we are using GET method to get data from server side
                    url: action, // get the route value
                    beforeSend: function() { //We add this before send to disable the button once we submit it so that we prevent the multiple click

                    },
                    success: function(response) { //once the request successfully process to the server side it will return result here
                        // Reload lists 
                        if (response == 'OK') {
                            location.reload(true);
                        } else {
                            swal({
                                title: "ERROR",
                                text: "Hapus data gagal.",
                                icon: "error",
                                button: "Ok",
                                timer: 1000
                            });
                        }

                    }
                });

            }
        });
    }
}