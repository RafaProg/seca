$( () =>  {
    let classrooms = [];

    (() => {
        $('tbody tr').each((index, element) => {
            classrooms.push({
                classroom:   element.children[0].innerText.replace(' ', '').toLowerCase(),
                oldPosition: element.children[3].innerText,
                newPosition: element.children[4].innerText,
            });
        });
    })();

    $("#sortable").sortable({
        placeholder: 'sortable',
        deactivate: (event, ui) => {
            classrooms = [];
            let id = ui.item.attr('id');
            let el = $('#' + id);

            $('tbody tr').each((currentIndex, element1) => {
                let nameRoom = element1.children[0].innerText
                                .replace(' ', '').toLowerCase();
                
                if (nameRoom === id) {
                    $('tbody tr').each((index2, element2) => {  
                        element2.children[4].innerHTML = '<span class="badge bg-green">' + (index2 + 1) + '</span>';
                        
                        classrooms.push({
                            classroom:   element2.children[0].innerText.replace(' ', '').toLowerCase(),
                            oldPosition: element2.children[3].innerText,
                            newPosition: element2.children[4].innerText,
                        });
                    });
                }
            });

            $('#datarooms').val(JSON.stringify(classrooms));
        }
    });
    $("#sortable").disableSelection();
});