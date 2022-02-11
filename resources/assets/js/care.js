$(function() {
    const foodSupplyCategory = '4';
    const $category = $('#category');
    const $foodSupplyItem = $('.food-supply-item');
    
    //
    // FoodSupply制御
    //
    
    $foodSupplyItem.hide();
    if ($category.val() === foodSupplyCategory) {
        $foodSupplyItem.show();
    }
    
    $category.on('change', function() {
        if ($category.val() === foodSupplyCategory) {
            $foodSupplyItem.show();
        } else {
            $foodSupplyItem.hide();
        }
    });
    
    //
    // delete
    //
    const $careDeleteForm = $('#careDeleteForm');
    const $careDeleteBtn = $('#careDeleteBtn');
    $careDeleteBtn.on('click', function() {
        $careDeleteForm.submit();
    });
});