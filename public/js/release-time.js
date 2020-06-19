$(() => {
    $('#add-time').click(
        () => {
            $.ajax({
                method: 'POST',
                url: "/release-times/add-release-time",
                datatype: 'json',
                data: {
                    release_time: releaseTime.value,
                    release_in_sequence: modeRelease.value,
                    _token: tokenAdd.value,
                }
            })
                .done(
                    result => {
                        let data = JSON.parse(result);

                        if (!data.error) {
                            $('table tbody').append(data.row);
                        } else {
                            $('.alert-box').removeClass('d-none');
                            $('.msg-alert').html(data.messageError);
                        }
                    }
                )
                .fail(
                    () => {
                        console.log('Não foi possivel processar');
                    }
                );
        }
    );

    $('table').on(
        'click',
        'button',
        (event) => {
            let id = event.currentTarget.id.substring(11);

            $.ajax({
                method: 'POST',
                url: `/release-times/delete-release-time/${id}`,
                data: {
                    _token: $('#tokenDelete' + id).val(),
                    _method: 'DELETE',
                }
            })
                .done(
                    result => {
                        $('#line' + result).remove();
                    }
                )
                .fail(
                    () => {
                        // implementar tratamento
                    }
                );
        }
    );

    $('#save-release-time').click(
        () => {
            //console.log(intervalBetweenRelease.value);
            //console.log(tokenInterval.value);
            $.ajax({
                method: 'POST',
                url: '/release-times/interval-between-release',
                data: {
                    interval: intervalBetweenRelease.value,
                    _token: tokenInterval.value,
                }
            })
                .done(
                    result => {
                        console.log(result);
                    }
                )
                .fail(
                    () => {
                        // implementar tratamento
                    }
                );
        }
    );
});