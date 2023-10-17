  <div class="global-buttons mb-3">
      <button type="button" class="btn btn-primary global-select" disabled>Global Select All</button>
      <button type="button" class="btn btn-warning global-deselect" disabled>Global Deselect All</button>
      <button type="button" class="btn btn-secondary global-show-hide" data-toggle="collapse"
          data-target=".group-details">Global Show All</button>
      <button type="button" class="btn btn-info global-previous-set-permission">Global Previous Set
          Permission</button>
  </div>

  <script>
      // Add event listener to global show/hide button
      document.querySelector('.global-show-hide').addEventListener('click', function() {
          toggleGroupDetailsVisibility();
          toggleGlobalSelectDeselectButtons();
          /**
           * Disable global select all, deselect all, pevious set permission
           * when gloabal hide/show button is set to hide
           */
      });

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
  </script>

  <div class="form-check">
      <input class="form-check-input group-checkbox" type="checkbox" id="{{ $group }}" name="groups[]"
          value="{{ $group }}" {{ $role->permissions->contains($group) ? 'checked' : '' }}>
      <label class="form-check-label" for="{{ $group }}" data-toggle="collapse"
          data-target="#{{ $group }}Details">{{ $group }}</label>
      <button type="button" class="btn btn-secondary hide-show" data-target="#{{ $group }}Details">Show</button>
      <button type="button" class="btn btn-success select-all" data-target="{{ $group }}">Select All</button>
      <button type="button" class="btn btn-danger unselect-all" data-target="{{ $group }}">Unselect All</button>
      <button type="button" class="btn btn-info previous-set-permission" data-target="{{ $group }}">Previous Set
          Permission</button>
  </div>

  <script>
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
                  // toggleMe();
                  toggleGroupButtons(targetGroup, true);
              } else {
                  targetElement.classList.add('show');
                  this.innerText = 'Hide';

                  // Enable group-select-all and group-deselect-all
                  // toggleMe();
                  toggleGroupButtons(targetGroup, false);
              }
          });
      });

      function toggleMe() {
          var groupSelectButton = document.querySelector('.select-all');
          var groupDeselectButton = document.querySelector('.deselect-all');
          var groupDetails = document.querySelectorAll('.group-details');

          groupSelectButton.innerText = "select-all button";
          groupDeselectButton.innerText = "un-select-all button";
          // Check if any group details are visible
          // var isAnyGroupVisible = Array.from(groupDetails).some(function(details) {
          //     return details.classList.contains('show');
          // });

          // Enable or disable the global select/deselect button based on visibility
          // globalSelectButton.disabled = !isAnyGroupVisible;
          // globalDeselectButton.disabled = !isAnyGroupVisible;
      }

      function toggleGroupButtons(targetGroup, disable) {
          // alert('hit omg' + targetGroup);
          // var groupSelectAll = document.querySelector('.select-all[data-target="' + targetGroup + '"]');
          // var groupDeselectAll = document.querySelector('.unselect-all[data-target="' + targetGroup + '"]');
          var groupSelectAll = document.querySelector('.select-all');
          var groupDeselectAll = document.querySelector('.unselect-all');
          groupSelectAll.disabled = disable;
          groupDeselectAll.disabled = disable;
      }
  </script>
