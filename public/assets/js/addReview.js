document.getElementById('date').valueAsDate = new Date();
$("#addReview").submit(function(e) {
    e.preventDefault();
    var form = $(this);
    var url = form.attr('action');
    $.ajax({
        type: "POST",
        url: url,
        data: form.serialize(),
        success: function(data)
        {
            var json = JSON.parse(data);
            if(json.error == false) {
                $(".alert-danger").addClass('d-none');
                $(".alert-success").removeClass('d-none').text(json.msg);
                $("#addReview")[0].reset();
                $("#add").addClass('d-none');
                setTimeout(function() { location.reload(); }, 700);
            }
            if(json.error == true) {
                $(".alert-success").addClass('d-none');
                $(".alert-danger").removeClass('d-none').text(json.msg);
            }
        }
    });
});