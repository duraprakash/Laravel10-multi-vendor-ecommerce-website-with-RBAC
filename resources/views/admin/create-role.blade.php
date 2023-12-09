{{-- resources/views/admin/create-role.blade.php --}}

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Create New Role</h1>

        <form action="{{ route('admin.store-role') }}" method="post">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Role Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>

            {{-- starts here --}}
            <h3>Assign Permissions To Your New Role</h3>
            <!-- Global Buttons -->
            <div class="global-buttons mb-3">
                <button type="button" class="btn btn-primary global-select" disabled>Global Select All</button>
                <button type="button" class="btn btn-warning global-deselect" disabled>Global Deselect All</button>
                <button type="button" class="btn btn-secondary global-show-hide" data-toggle="collapse"
                    data-target=".group-details">Global Show All</button>
                <button type="button" class="btn btn-info global-previous-set-permission">Global Previous Set
                    Permission</button>
            </div>

            <!-- Group Permissions -->
            @foreach ($permissionsByGroup as $group => $permissions)
                <div class="card mb-3">
                    <div class="card-header">
                        <div class="form-check">
                            <input class="form-check-input group-checkbox" type="checkbox" id="{{ $group }}"
                                name="groups[]" value="{{ $group }}"
                                {{ $role->permissions->contains($group) ? 'checked' : '' }}>
                            <label class="form-check-label" for="{{ $group }}" data-toggle="collapse"
                                data-target="#{{ $group }}Details">{{ $group }}</label>
                            <button type="button" class="btn btn-secondary hide-show"
                                data-target="#{{ $group }}Details">Show</button>
                            <button type="button" class="btn btn-success select-all {{ $group }}Details-select-all"
                                data-target="{{ $group }}" disabled>Select All</button>
                            <button type="button"
                                class="btn btn-danger unselect-all {{ $group }}Details-unselect-all"
                                data-target="{{ $group }}" disabled>Unselect All</button>
                            <button type="button" class="btn btn-info previous-set-permission"
                                data-target="{{ $group }}">Previous Set Permission</button>
                        </div>
                    </div>
                    <div class="card-body collapse group-details" id="{{ $group }}Details">
                        @foreach ($permissions as $permission)
                            <div class="form-check">
                                <input class="form-check-input permission-checkbox" type="checkbox" name="permissions[]"
                                    value="{{ $permission->name }}" data-group="{{ $group }}"
                                    {{ $role->permissions->contains($permission) ? 'checked' : '' }}>
                                <label class="form-check-label">{{ $permission->name }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
            {{-- ends here --}}


            <button type="submit" class="btn btn-primary">Create Role</button>
        </form>
    </div>

    <!-- JavaScript Section -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Event listener for group checkboxes
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

                    // Enable or disable group-select-all and group-unselect-all buttons based on the group checkbox state
                    toggleGroupButtons(groupName, !groupCheckbox.checked);
                });
            });

            // Event listeners for global buttons
            document.querySelector('.global-select').addEventListener('click', function() {
                toggleAllPermissions(true);
            });

            document.querySelector('.global-deselect').addEventListener('click', function() {
                toggleAllPermissions(false);
            });

            document.querySelector('.global-previous-set-permission').addEventListener('click', function() {
                applyPreviousSetPermissionsGlobally();
            });

            // Event listeners for hide/show buttons
            var hideShowButtons = document.querySelectorAll('.hide-show');
            hideShowButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    toggleGroupVisibility(this);
                });
            });

            function toggleGroupVisibility(button) {
                var targetId = button.getAttribute('data-target');
                var targetElement = document.querySelector(targetId);
                var targetGroup = targetElement.id;

                // Toggle visibility of the target group details
                targetElement.classList.toggle('show');
                button.innerText = targetElement.classList.contains('show') ? 'Hide' : 'Show';

                // Enable or disable group-select-all and group-unselect-all buttons based on the group visibility
                toggleGroupButtons(targetGroup, !targetElement.classList.contains('show'));

                // Toggle global select/deselect buttons and text based on group visibility
                toggleGlobalSelectDeselectButtons();
            }

            function toggleGroupButtons(targetGroup, disable) {
                var btnSelectAll = document.querySelector('.' + targetGroup + '-select-all');
                var btnUnselectAll = document.querySelector('.' + targetGroup + '-unselect-all');

                if (btnSelectAll && btnUnselectAll) {
                    btnSelectAll.disabled = disable;
                    btnUnselectAll.disabled = disable;
                } else {
                    console.error('Buttons not found within the group element.');
                }
            }

            // Event listener for global show/hide button
            document.querySelector('.global-show-hide').addEventListener('click', function() {
                // Toggle visibility of all group details
                var groupDetails = document.querySelectorAll('.group-details');
                groupDetails.forEach(function(details) {
                    details.classList.toggle('show', this.innerText.toLowerCase().includes('show'));
                }.bind(this));

                // Update hide/show toggle text for all group buttons
                var buttonText = this.innerText.toLowerCase().includes('show') ? 'Hide' : 'Show';
                hideShowButtons.forEach(function(button) {
                    button.innerText = buttonText;
                });

                // Enable or disable group-select-all and group-unselect-all buttons based on the global show/hide button
                toggleGroupButtonsGlobally(!this.innerText.toLowerCase().includes('show'));

                // Toggle global select/deselect buttons and text based on group visibility
                toggleGlobalSelectDeselectButtons();
            });

            // Enable or disable group-select-all and group-unselect-all buttons based on the global show/hide button
            function toggleGroupButtonsGlobally(enable) {
                var groupSelectButtons = document.querySelectorAll('.select-all');
                var groupUnselectButtons = document.querySelectorAll('.unselect-all');

                groupSelectButtons.forEach(function(button) {
                    button.disabled = enable;
                });

                groupUnselectButtons.forEach(function(button) {
                    button.disabled = enable;
                });
            }

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

            // Event listeners for select all buttons
            var selectAllButtons = document.querySelectorAll('.select-all');
            selectAllButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    toggleGroupPermissions(this.getAttribute('data-target'), true);
                });
            });

            // Event listeners for unselect all buttons
            var unselectAllButtons = document.querySelectorAll('.unselect-all');
            unselectAllButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    toggleGroupPermissions(this.getAttribute('data-target'), false);
                });
            });

            // Event listeners for previous set permission buttons (group level)
            var previousSetPermissionButtons = document.querySelectorAll('.previous-set-permission');
            previousSetPermissionButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    applyPreviousSetPermissionsForGroup(this.getAttribute('data-target'));
                });
            });

            // Event listener for previous set permission button (global level)
            document.querySelector('.global-previous-set-permission').addEventListener('click', function() {
                applyPreviousSetPermissionsGlobally();
            });

            // Event listeners for clickable labels
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
@endsection
