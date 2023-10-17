 <script>
     document.addEventListener('DOMContentLoaded', function() {
         // Add event listener to group checkboxes
         var groupCheckboxes = document.querySelectorAll('.group-checkbox');
         groupCheckboxes.forEach(function(groupCheckbox) {
             groupCheckbox.addEventListener('change', function() {
                 var groupName = this.value;
                 var permissionCheckboxes = document.querySelectorAll(
                     '.permission-checkbox[data-group="' + groupName + '"]');

                 // Update state of permission checkboxes based on the state of the group checkbox
                 permissionCheckboxes.forEach(function(permissionCheckbox) {
                     permissionCheckbox.checked = groupCheckbox.checked;
                 });
             });
         });

         // Add event listener to global select all button
         document.querySelector('.global-select').addEventListener('click', function() {
             toggleAllPermissions(true);
         });

         // Add event listener to global deselect all button
         document.querySelector('.global-deselect').addEventListener('click', function() {
             toggleAllPermissions(false);
         });

         // Add event listener to global previous set permission button
         document.querySelector('.global-previous-set-permission').addEventListener('click', function() {
             applyPreviousSetPermissionsGlobally();
         });

         // Add event listener to hide/show buttons
         var hideShowButtons = document.querySelectorAll('.hide-show');
         hideShowButtons.forEach(function(button) {
             button.addEventListener('click', function() {
                 var targetId = this.getAttribute('data-target');
                 var targetElement = document.querySelector(targetId);
                 var targetGroup = targetElement.id;

                 if (targetElement.classList.contains('show')) {
                     targetElement.classList.remove('show');
                     this.innerText = 'Show';

                     // Disable group-select-all and group-deselect-all
                     toggleGroupButtons(targetGroup, true);
                 } else {
                     targetElement.classList.add('show');
                     this.innerText = 'Hide';

                     // Enable group-select-all and group-deselect-all
                     toggleGroupButtons(targetGroup, false);
                 }
             });
         });

         function toggleGroupButtons(targetGroup, disable) {
             var groupSelectAll = document.querySelector('.select-all[data-target="' + targetGroup + '"]');
             var groupDeselectAll = document.querySelector('.unselect-all[data-target="' + targetGroup + '"]');
             groupSelectAll.disabled = disable;
             groupDeselectAll.disabled = disable;
         }

         // Add event listener to select all buttons
         var selectAllButtons = document.querySelectorAll('.select-all');
         selectAllButtons.forEach(function(button) {
             button.addEventListener('click', function() {
                 toggleGroupPermissions(this.getAttribute('data-target'), true);
             });
         });

         // Add event listener to unselect all buttons
         var unselectAllButtons = document.querySelectorAll('.unselect-all');
         unselectAllButtons.forEach(function(button) {
             button.addEventListener('click', function() {
                 toggleGroupPermissions(this.getAttribute('data-target'), false);
             });
         });

         // Add event listener to previous set permission buttons (group level)
         var previousSetPermissionButtons = document.querySelectorAll('.previous-set-permission');
         previousSetPermissionButtons.forEach(function(button) {
             button.addEventListener('click', function() {
                 applyPreviousSetPermissionsForGroup(this.getAttribute('data-target'));
             });
         });

         // Add event listener to previous set permission button (global level)
         document.querySelector('.global-previous-set-permission').addEventListener('click', function() {
             applyPreviousSetPermissionsGlobally();
         });

         // Add event listener to clickable labels
         var permissionLabels = document.querySelectorAll('.permission-label');
         permissionLabels.forEach(function(label) {
             label.addEventListener('click', function() {
                 var checkbox = document.querySelector('#' + label.getAttribute('for'));
                 checkbox.checked = !checkbox.checked;
             });
         });

         function toggleAllPermissions(state) {
             var permissionCheckboxes = document.querySelectorAll('.permission-checkbox');
             permissionCheckboxes.forEach(function(permissionCheckbox) {
                 permissionCheckbox.checked = state;
             });
         }

         // Add event listener to global show/hide button
         document.querySelector('.global-show-hide').addEventListener('click', function() {
             toggleGroupDetailsVisibility();
             // toggleGlobalGroupButtons(); // Add this line
             toggleGlobalSelectDeselectButtons();
             /**
              * Disable global select all, deselect all, pevious set permission
              * when gloabal hide/show button is set to hide
              */
         });

         function toggleGlobalGroupButtons() {
             var globalShowHideButton = document.querySelector('.global-show-hide');
             var groupShowHideButtons = document.querySelectorAll('.hide-show');

             // Set the state of all group hide/show buttons based on the state of the global button
             groupShowHideButtons.forEach(function(button) {
                 button.innerText = globalShowHideButton.innerText;
                 // button.innerText = groupShowHideButtons.innerText;
             });
         }

         function toggleGroupDetailsVisibility() {
             var groupDetails = document.querySelectorAll('.group-details');
             var globalShowHideButton = document.querySelector('.global-show-hide');

             var showDetails = globalShowHideButton.innerText.toLowerCase().includes('show');

             groupDetails.forEach(function(details) {
                 details.classList.toggle('show', showDetails);
             });

             // Change hide/show toggle text on clicking
             var buttonTextElement = document.querySelector('.global-show-hide');
             buttonTextElement.innerText = showDetails ? 'Global Hide All' : 'Global Show All';

             // Dynamically update text of group hide/show buttons
             var showHideButtonText = showDetails ? 'Hide' : 'Show';
             var hideShowButtons = document.querySelectorAll('.hide-show');
             hideShowButtons.forEach(function(button) {
                 button.innerText = showHideButtonText;
             });
         }

         function toggleGlobalSelectDeselectButtons() {
             var globalSelectButton = document.querySelector('.global-select');
             var globalDeselectButton = document.querySelector('.global-deselect');
             var groupDetails = document.querySelectorAll('.group-details');

             // Check if any group details are visible
             var isAnyGroupVisible = Array.from(groupDetails).some(function(details) {
                 return details.classList.contains('show');
             });

             // Enable or disable the global select/deselect button based on visibility
             globalSelectButton.disabled = !isAnyGroupVisible;
             globalDeselectButton.disabled = !isAnyGroupVisible;
         }

         function toggleGroupPermissions(targetGroup, state) {
             var permissionCheckboxes = document.querySelectorAll('.permission-checkbox[data-group="' +
                 targetGroup + '"]');
             permissionCheckboxes.forEach(function(permissionCheckbox) {
                 permissionCheckbox.checked = state;
             });
         }

         function applyPreviousSetPermissionsGlobally() {
             var rolePermissions = {!! json_encode($role->permissions->pluck('name')) !!};
             var permissionCheckboxes = document.querySelectorAll('.permission-checkbox');
             permissionCheckboxes.forEach(function(permissionCheckbox) {
                 permissionCheckbox.checked = rolePermissions.includes(permissionCheckbox.value);
             });
         }

         function applyPreviousSetPermissionsForGroup(groupName) {
             var rolePermissions = {!! json_encode($role->permissions->pluck('name')) !!};
             var permissionCheckboxes = document.querySelectorAll('.permission-checkbox[data-group="' +
                 groupName + '"]');
             permissionCheckboxes.forEach(function(permissionCheckbox) {
                 permissionCheckbox.checked = rolePermissions.includes(permissionCheckbox.value);
             });
         }
     });
 </script>
