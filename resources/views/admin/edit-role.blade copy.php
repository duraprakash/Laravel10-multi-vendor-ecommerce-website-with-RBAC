@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Role: {{ $role->name }}</h1>

    <form action="{{ route('admin.update-role', $role->id) }}" method="post">
        @csrf
        @method('put')

        <div class="mb-3">
            <label for="name" class="form-label">Role Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $role->name }}" required>
        </div>

        <h3>Assign Permissions</h3>
        <div class="global-buttons mb-3">
            <button type="button" class="btn btn-primary global-select" disabled>Global Select All</button>
            <button type="button" class="btn btn-warning global-deselect" disabled>Global Deselect All</button>
            <button type="button" class="btn btn-secondary global-show-hide" data-toggle="collapse" data-target=".group-details">Global Show All</button>
            <button type="button" class="btn btn-info global-previous-set-permission">Global Previous Set
                Permission</button>
        </div>

        @foreach ($permissionsByGroup as $group => $permissions)
        <div class="card mb-3">
            <div class="card-header">
                <div class="form-check">
                    <input class="form-check-input group-checkbox" type="checkbox" id="{{ $group }}" name="groups[]" value="{{ $group }}" {{ $role->permissions->contains($group) ? 'checked' : '' }}>
                    <label class="form-check-label" for="{{ $group }}" data-toggle="collapse" data-target="#{{ $group }}Details">{{ $group }}</label>
                    <button type="button" class="btn btn-secondary hide-show" data-target="#{{ $group }}Details">Show</button>
                    <button type="button" class="btn btn-success select-all {{ $group }}Details-select-all" data-target="{{ $group }}" disabled>Select All</button>
                    <button type="button" class="btn btn-danger unselect-all {{ $group }}Details-unselect-all" data-target="{{ $group }}" disabled>Unselect All</button>
                    <button type="button" class="btn btn-info previous-set-permission" data-target="{{ $group }}">Previous Set Permission</button>
                </div>
            </div>
            <div class="card-body collapse group-details" id="{{ $group }}Details">
                @foreach ($permissions as $permission)
                <div class="form-check">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="permissions[]" value="{{ $permission->name }}" data-group="{{ $group }}" {{ $role->permissions->contains($permission) ? 'checked' : '' }}>
                    <label class="form-check-label">{{ $permission->name }}</label>
                </div>
                @endforeach
            </div>
        </div>
        @endforeach

        <button type="submit" class="btn btn-primary">Update Role</button>
    </form>
</div>
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
                var targetId = this.getAttribute('data-target'); //  #dashboardDetails
                var targetElement = document.querySelector(
                    targetId); // [object HTMLDivElement] 
                var targetGroup = targetElement.id; // dashboardDetails

                // alert('id ' + targetId + ' element ' +targetElement+ ' group ' +targetGroup+ ' class has ' +targetElement.classList.contains('show'));
                // alert(' group ' + '#' + targetGroup);
                if (targetElement.classList.contains('show')) {
                    targetElement.classList.remove('show');
                    this.innerText = 'Show';

                    // Disable group-select-all and group-unselect-all
                    toggleGroupButtons(targetGroup, true); // dashboardDetails,true
                } else {
                    targetElement.classList.add('show');
                    this.innerText = 'Hide';

                    // Enable group-select-all and group-unselect-all
                    toggleGroupButtons(targetGroup, false); // dashboardDetails,false
                }


                // if all group-checkboxes are visible then enable global select-all/unselect-all and change global-hide/show text start here
                var globalSelectButton = document.querySelector('.global-select');
                var globalDeselectButton = document.querySelector('.global-deselect');
                var groupCheckboxes = document.querySelectorAll('.group-checkbox');

                // Check if all group buttons called 'Show' are visible
                var areAllGroupButtonsVisible = Array.from(groupCheckboxes).every(function(
                    groupCheckbox) {
                    var groupName = groupCheckbox.value;
                    var targetElement = document.querySelector('#' + groupName +
                        'Details');
                    return targetElement.classList.contains('show');
                });

                // Enable or disable the global select/deselect button based on the visibility of group buttons
                globalSelectButton.disabled = !areAllGroupButtonsVisible;
                globalDeselectButton.disabled = !areAllGroupButtonsVisible;

                // Change the global hide/show button text based on the visibility of group buttons
                var globalShowHideButton = document.querySelector('.global-show-hide');
                globalShowHideButton.innerText = areAllGroupButtonsVisible ? 'Global Hide All' :
                    'Global Show All';
                var globalSelectButton = document.querySelector('.global-select');
                var globalDeselectButton = document.querySelector('.global-deselect');
                var groupCheckboxes = document.querySelectorAll('.group-checkbox');

                // Check if all group buttons called 'Show' are visible
                var areAllGroupButtonsVisible = Array.from(groupCheckboxes).every(function(
                    groupCheckbox) {
                    var groupName = groupCheckbox.value;
                    var targetElement = document.querySelector('#' + groupName +
                        'Details');
                    return targetElement.classList.contains('show');
                });

                // Enable or disable the global select/deselect button based on the visibility of group buttons
                globalSelectButton.disabled = !areAllGroupButtonsVisible;
                globalDeselectButton.disabled = !areAllGroupButtonsVisible;

                // Change the global hide/show button text based on the visibility of group buttons
                var globalShowHideButton = document.querySelector('.global-show-hide');
                globalShowHideButton.innerText = areAllGroupButtonsVisible ? 'Global Hide All' :
                    'Global Show All';
                // if all group-checkboxes are visible then enable global select-all/unselect-all and change global-hide/show text ends here
            });
        });

        function toggleGroupButtons(targetGroup, disable) { // dashboardDetails/blogDetails,true/false
            // // Select buttons within the specific group
            // var groupSelectAllButton = document.querySelector('.card-body#' + targetGroup);
            // var targetGroup1 = groupSelectAllButton.id; // dashboardDetails/blogDetails

            // var groupUnselectAllButton = document.querySelector('.card-body#' + targetGroup);
            // var targetGroup2 = groupUnselectAllButton.id; // dashboardDetails/blogDetails

            // // alert('select' + groupSelectAllButton + ' group ' + targetGroup1 + '-select-all' + ' unselect ' +
            // //     groupUnselectAllButton + ' group ' + targetGroup2 + '-unselect-all');

            // var btnSelectAll = document.querySelector('.' + targetGroup1 + '-select-all');
            // var btnUnselectAll = document.querySelector('.' + targetGroup1 + '-unselect-all');
            var btnSelectAll = document.querySelector('.' + targetGroup + '-select-all');
            var btnUnselectAll = document.querySelector('.' + targetGroup + '-unselect-all');
            // alert(btnSelectAll + ' ' + btnUnselectAll);
            // Enable or disable buttons
            if (btnSelectAll && btnUnselectAll) {
                btnSelectAll.disabled = disable;
                btnUnselectAll.disabled = disable;
            } else {
                console.error('Buttons not found within the group element.');
            }
        }

        // Add event listener to global show/hide button
        document.querySelector('.global-show-hide').addEventListener('click', function() {
            /**
             * Disable global select all, deselect all, pevious set permission
             * when gloabal hide/show button is set to hide
             */
            toggleGroupDetailsVisibility();
            toggleGlobalSelectDeselectButtons();
        });

        function toggleGlobalSelectDeselectButtons() {
            var globalSelectButton = document.querySelector('.global-select');
            var globalDeselectButton = document.querySelector('.global-deselect');
            var groupCheckboxes = document.querySelectorAll('.group-checkbox');

            // Check if all group buttons called 'Show' are visible
            var areAllGroupButtonsVisible = Array.from(groupCheckboxes).every(function(groupCheckbox) {
                var groupName = groupCheckbox.value;
                var targetElement = document.querySelector('#' + groupName + 'Details');
                return targetElement.classList.contains('show');
            });

            // Enable or disable the global select/deselect button based on the visibility of group buttons
            globalSelectButton.disabled = !areAllGroupButtonsVisible;
            globalDeselectButton.disabled = !areAllGroupButtonsVisible;

            // Change the global hide/show button text based on the visibility of group buttons
            var globalShowHideButton = document.querySelector('.global-show-hide');
            globalShowHideButton.innerText = areAllGroupButtonsVisible ? 'Global Hide All' : 'Global Show All';

        }

        function toggleGroupDetailsVisibility() {
            var groupDetails = document.querySelectorAll('.group-details');
            var globalShowHideButton = document.querySelector('.global-show-hide');
            var showDetails = globalShowHideButton.innerText.toLowerCase().includes('show');
            // alert('details ' + groupDetails + ' hide/show btn ' + globalShowHideButton + ' showDetails ' +
            //     showDetails)
            groupDetails.forEach(function(details) {
                details.classList.toggle('show', showDetails);
            });

            // Change hide/show toggle text on clicking
            // var buttonTextElement = document.querySelector('.global-show-hide');
            // buttonTextElement.innerText = showDetails ? 'Global Hide All' : 'Global Show All';

            // Dynamically update text of group hide/show buttons
            var showHideButtonText = showDetails ? 'Hide' : 'Show';
            var hideShowButtons = document.querySelectorAll('.hide-show');
            hideShowButtons.forEach(function(button) {
                button.innerText = showHideButtonText;
            });

            // Check if all group buttons called 'Show' are visible
            var areAllGroupButtonsVisible = Array.from(hideShowButtons).every(function(button) {
                return button.innerText.toLowerCase() === 'show';
            });

            // Enable or disable group-select-all and group-unselect-all based on the visibility of group buttons
            var groupSelectButtons = document.querySelectorAll('.select-all');
            var groupUnselectButtons = document.querySelectorAll('.unselect-all');

            groupSelectButtons.forEach(function(button) {
                button.disabled = areAllGroupButtonsVisible;
            });

            groupUnselectButtons.forEach(function(button) {
                button.disabled = areAllGroupButtonsVisible;
            });

            // Update the global select/deselect buttons and text based on the visibility of group buttons
            toggleGlobalSelectDeselectButtons();
        }

        // Add event listener to select all buttons
        var selectAllButtons = document.querySelectorAll('.select-all');
        selectAllButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                toggleGroupPermissions(this.getAttribute('data-target'), true);
            });
        });

        function toggleGroupPermissions(targetGroup, state) {
            var permissionCheckboxes = document.querySelectorAll('.permission-checkbox[data-group="' +
                targetGroup + '"]');
            permissionCheckboxes.forEach(function(permissionCheckbox) {
                permissionCheckbox.checked = state;
            });
        }

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

        function toggleGroupPermissions(targetGroup, state) {
            var permissionCheckboxes = document.querySelectorAll(
                '.permission-checkbox[data-group="' +
                targetGroup + '"]');
            permissionCheckboxes.forEach(function(permissionCheckbox) {
                permissionCheckbox.checked = state;
            });
        }

        function applyPreviousSetPermissionsGlobally() {
            var rolePermissions = {
                !!json_encode($role - > permissions - > pluck('name')) !!
            };
            var permissionCheckboxes = document.querySelectorAll('.permission-checkbox');
            permissionCheckboxes.forEach(function(permissionCheckbox) {
                permissionCheckbox.checked = rolePermissions.includes(permissionCheckbox
                    .value);
            });
        }

        function applyPreviousSetPermissionsForGroup(groupName) {
            var rolePermissions = {
                !!json_encode($role - > permissions - > pluck('name')) !!
            };
            var permissionCheckboxes = document.querySelectorAll(
                '.permission-checkbox[data-group="' +
                groupName + '"]');
            permissionCheckboxes.forEach(function(permissionCheckbox) {
                permissionCheckbox.checked = rolePermissions.includes(permissionCheckbox
                    .value);
            });
        }
    });
</script>
@endsection