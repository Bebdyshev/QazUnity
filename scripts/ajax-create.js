document.addEventListener('DOMContentLoaded', function() {
    const submitBtn = document.querySelector('#form');


    submitBtn.addEventListener('submit', function(e) { 
        e.preventDefault();
        var formData = $(this).serialize();

        console.log(formData);

        $.ajax({
            url: '../regprocces/create.php',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    console.log('succcces:', response.message);
                    popup.hide();
                } else {
                    console.error('loh:', response.message);
                }
            },
            error: function(error) {
                console.error('loh:', error);
            }
        });

    });
});