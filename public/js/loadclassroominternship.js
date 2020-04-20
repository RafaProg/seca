$(() => {

    let i = 1;
    $('form').bind('scroll', function() {

        if($(this).scrollTop() + $(this).innerHeight() >= this.scrollHeight) {
            i++;
            $.get("http://localhost:8000/classrooms/config-internship?page=" + i, function (data) {
                if (!data) {
                    $('#atualizar').attr('disabled', false);
                    $('#excluir').attr('disabled', false);
                }

                $('#jq_classrooms_add').append(data);
            });
        }
    });

    

});