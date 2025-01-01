<h3>Test modals</h3>
<p>Modal loader, will close automatically after a few seconds.</p>
<p><button class="{BUTTON}" type="button" {BTN_SHOW_LOADER} onclick="setTimeout(reloadPage, 1357)">Show loader no JS</button></p>
<p><button class="{BUTTON}" type="button" onclick="showLoader()">Show loader using JS</button></p>
<p><a href="{LINK_ROOT}{REQUEST_URI}" {LNK_SHOW_LOADER}>Using a link</a></p>
<p>&nbsp;</p>
<p>Modal message, close it using the close button in the dialog.</p>
<p><button class="{BUTTON}" type="button" data-bs-toggle="modal" data-bs-target="#modal-message">Show message no JS</button></p>
<p><button class="{BUTTON}" type="button" onclick="showMessage()">Show message using JS</button></p>
<p>&nbsp;</p>
<p>Modal confirm, can only be used with JS, because a callback needs to be setup.</p>
<p><button class="{BUTTON}" type="button" onclick="showConfirm()">Show confirm using JS</button></p>
<script>

'use strict';

// Setup the modal message
document.getElementById('modal-message-title').innerHTML = "Modal message test";
document.getElementById('modal-message-body').innerHTML = "If all work file a message dialog will be shown.";


function reloadPage()
{
   location.reload();
}

function showLoader()
{
    let loader = showModalLoader();
    setTimeout(closeLoader, 1357, loader);
}

function closeLoader(loader)
{
    loader.hide();
}

function showMessage()
{
    showModalMessage("Modal message test", "If all work file a message dialog will be shown.");
}

function showConfirm()
{
    showModalConfirm("Modal confirm test", "Click yes to activate the callback.", confirmCallback);
}

function confirmCallback()
{
    setTimeout(showModalMessage, 200, "Modal confirm test result", "You clicked yes!");
}

</script>
