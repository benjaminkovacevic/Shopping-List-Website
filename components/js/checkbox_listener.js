// Add an event listener to all checkboxes
const checkboxes = document.querySelectorAll('input[type="checkbox"]');
checkboxes.forEach(function (checkbox) {
    checkbox.addEventListener('change', function () {
        const itemId = checkbox.id.replace('item', '');
        const checked = checkbox.checked ? 0 : 1; // Update the value

        // Make an AJAX request to update the database
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'components/actions/update_item.php');
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send('item_id=' + itemId + '&checked=' + checked);
    });
});
