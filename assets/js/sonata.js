const $form = $('.sonata-ba-form').find('form');
$form.submit( function(){
    let parentLocation = $form.find('.parent-category option:selected').attr('location');
    let name = $form.find('.category-name').val()
    if (parentLocation ==='none'){
        $form.find('.parent-category-key').val(name+'/')
    } else {
        $form.find('.parent-category-key').val(parentLocation+name+'/')
    }
});
